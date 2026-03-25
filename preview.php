<?php

/**
 * Live Preview Utility
 * 
 * Provides an instant HTML/PDF preview of quotation 1080081.
 * Use this to iterate quickly on the design.
 * 
 * To run:
 *   php -S localhost:8000 preview.php
 */

require_once __DIR__ . '/vendor/autoload.php';

use Illuminate\Container\Container;
use Illuminate\Events\Dispatcher;
use Illuminate\Filesystem\Filesystem;
use Illuminate\View\Compilers\BladeCompiler;
use Illuminate\View\Engines\CompilerEngine;
use Illuminate\View\Engines\EngineResolver;
use Illuminate\View\Engines\PhpEngine;
use Illuminate\View\Factory as ViewFactory;
use Illuminate\View\FileViewFinder;
use Quotation\Converter\Converter;

// ─── 1. Boot Environment ──────────────────────────────────────────

$container  = new Container();
$filesystem = new Filesystem();
$dispatcher = new Dispatcher($container);
$cachePath  = __DIR__ . '/tests/cache';

if (!is_dir($cachePath)) mkdir($cachePath, 0755, true);

$viewPaths = [__DIR__ . '/resources/views'];
$finder    = new FileViewFinder($filesystem, $viewPaths);
$finder->addNamespace('quotation-pkg', [__DIR__ . '/resources/views']);

$resolver = new EngineResolver();
$resolver->register('php', fn() => new PhpEngine());
$bladeCompiler = new BladeCompiler($filesystem, $cachePath);
$resolver->register('blade', fn() => new CompilerEngine($bladeCompiler));

$viewFactory = new ViewFactory($resolver, $finder, $dispatcher);

// ─── 2. Load Sample Data ──────────────────────────────────────────

$fixturePath = __DIR__ . '/tests/fixtures/quotation_sample_data.json';
if (!file_exists($fixturePath)) {
    die("Error: Fixture not found. Run php fetch_data.php first.");
}

$fixtureData = json_decode(file_get_contents($fixturePath), true);
$rawQuotation = $fixtureData['quotation_1080081'] ?? reset($fixtureData);

$header    = $rawQuotation['header'][0] ?? [];
$lineItems = $rawQuotation['line_items'] ?? [];

// Map to DTO array (same logic as mapper)
$mapped = [
    'id'                   => (string) ($header['QuotationID'] ?? '1080081'),
    'quotationName'        => $header['QuotationName'] ?? 'Preview Quotation',
    'date'                 => (new \DateTime($header['QuotationDate'] ?? 'now'))->format('m/d/Y'),
    'reference'            => $header['ReferenceNo'] ?? null,
    'currency'             => $header['Currency'] ?? 'PHP',
    'signatoryName'        => $header['SignatoryName'] ?? 'Previewer',
    'signatoryId'          => (int) ($header['Signatory'] ?? 0),
    'company' => [
        'name'      => 'Integrated Computer Systems, Inc.',
        'address'   => '3/F Limketkai Building, Ortigas Avenue',
        'logo'      => 'data:image/png;base64,' . base64_encode(file_get_contents(__DIR__ . '/public/ics_logo.png')),
    ],
    'client' => [
        'name'          => $header['CustomerName'] ?? 'Sample Client',
        'address'       => $header['Address'] ?? 'Sample Address',
        'contactPerson' => $header['ContactName'] ?? 'Attn Person',
    ],
    'lineItems' => array_map(fn($i) => [
        'description'    => $i['Description'] ?? '',
        'quantity'       => (int) ($i['Qty'] ?? 1),
        'unitPrice'      => (float) ($i['UnitPrice'] ?? 0),
        'totalPrice'     => (float) ($i['TotalPrice'] ?? 0),
        'showItemPrices' => true,
    ], $lineItems),
    'totals' => [
        'grandTotal' => (float) ($header['Total'] ?? 0),
    ],
];

// ─── 3. Render ────────────────────────────────────────────────────

$converter = new Converter($viewFactory);
$converter->fromArray($mapped);

$mode = $_GET['mode'] ?? 'html';

if ($mode === 'pdf') {
    return $converter->inline('preview-1080081.pdf')->send();
}

// Default: HTML Preview with Auto-Reload script
$html = $converter->html();

// Inject auto-reload script
$reloadScript = '
<script>
    // Simple polling to check for file changes (mimics hot reload)
    let lastModified = null;
    async function checkChanges() {
        try {
            const resp = await fetch(window.location.href, { method: "HEAD" });
            const modified = resp.headers.get("Last-Modified");
            if (lastModified && modified !== lastModified) {
                window.location.reload();
            }
            lastModified = modified;
        } catch (e) {}
    }
    // Refresh every 1.5 seconds if we were doing real file watching, 
    // but here we just encourage the user to refresh or we can add a simple timer.
    // For now, let\'s just add a floating refresh button for convenience.
</script>
<div style="position: fixed; bottom: 20px; left: 20px; z-index: 9999; display: flex; gap: 10px;">
    <button onclick="window.location.reload()" style="padding: 10px 15px; background: #003366; color: white; border: none; border-radius: 5px; cursor: pointer; font-weight: bold; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">🔄 Refresh Preview</button>
    <a href="?mode=pdf" target="_blank" style="padding: 10px 15px; background: #e11d48; color: white; text-decoration: none; border-radius: 5px; font-weight: bold; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">📄 View as PDF</a>
</div>
';

echo str_replace('</body>', $reloadScript . '</body>', $html);
