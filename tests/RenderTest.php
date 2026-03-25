<?php

/**
 * Integration test: Boots a minimal Blade environment, loads the sample
 * JSON fixture, maps it through the DTO, and renders a PDF.
 *
 * Usage:
 *   cd c:\Projects\quotation-converter
 *   composer install
 *   php tests/RenderTest.php
 *
 * Output:
 *   tests/output/quotation_1080081.pdf
 *   tests/output/quotation_1086483.pdf
 */

require_once __DIR__ . '/../vendor/autoload.php';

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
use Quotation\Converter\Data\QuotationData;

echo "═══════════════════════════════════════════════════════\n";
echo " Quotation Converter — Integration Test\n";
echo "═══════════════════════════════════════════════════════\n\n";

// ─── 1. Boot a minimal Blade view environment ──────────────────

$container  = new Container();
$filesystem = new Filesystem();
$dispatcher = new Dispatcher($container);

// Compiled views cache
$cachePath = __DIR__ . '/cache';
if (!is_dir($cachePath)) {
    mkdir($cachePath, 0755, true);
}

// View paths
$viewPaths = [
    dirname(__DIR__) . '/resources/views',
];

$finder = new FileViewFinder($filesystem, $viewPaths);
// Register the package namespace
$finder->addNamespace('quotation-pkg', [dirname(__DIR__) . '/resources/views']);

$resolver = new EngineResolver();

// Register Php engine
$resolver->register('php', function () {
    return new PhpEngine();
});

// Register Blade engine
$bladeCompiler = new BladeCompiler($filesystem, $cachePath);
$resolver->register('blade', function () use ($bladeCompiler) {
    return new CompilerEngine($bladeCompiler);
});

$viewFactory = new ViewFactory($resolver, $finder, $dispatcher);

echo "[✓] Blade environment booted.\n";

// ─── 2. Load sample JSON fixture ───────────────────────────────

$fixturePath = __DIR__ . '/fixtures/quotation_sample_data.json';
if (!file_exists($fixturePath)) {
    echo "[✗] Fixture not found at: {$fixturePath}\n";
    echo "    Run fetch_data.php first to create the fixture.\n";
    exit(1);
}

$fixtureData = json_decode(file_get_contents($fixturePath), true);
echo "[✓] Loaded fixture: " . count($fixtureData) . " quotation(s).\n\n";

// ─── 3. Output directory ───────────────────────────────────────

$outputDir = __DIR__ . '/output';
if (!is_dir($outputDir)) {
    mkdir($outputDir, 0755, true);
}

// ─── 4. Map & render each quotation ────────────────────────────

$converter = new Converter($viewFactory);
$passed    = 0;
$failed    = 0;

foreach ($fixtureData as $key => $rawQuotation) {
    $header    = $rawQuotation['header'][0] ?? [];
    $lineItems = $rawQuotation['line_items'] ?? [];

    echo "─── Processing: {$key} ───\n";

    // Map raw DB fields → package DTO (same logic as QuotationMapper example)
    $mapped = [
        'id'                   => (string) ($header['QuotationID'] ?? ''),
        'quotationName'        => $header['QuotationName'] ?? '',
        'date'                 => formatDate($header['QuotationDate'] ?? ''),
        'reference'            => $header['ReferenceNo'] ?? null,
        'validUntil'           => formatDate($header['ValidTill'] ?? ''),
        'currency'             => $header['Currency'] ?? 'PHP',
        'termsOfPayment'       => $header['TermsOfPayment'] ?? null,
        'notes'                => !empty($header['SpecialNotes']) ? $header['SpecialNotes'] : null,
        'availability'         => !empty($header['Availability']) ? $header['Availability'] : null,
        'warranty'             => !empty($header['Warranty']) ? $header['Warranty'] : null,
        'signatoryName'        => $header['SignatoryName'] ?? null,
        'signatoryId'          => (int) ($header['Signatory'] ?? 0),
        'accountName'          => $header['AccountName'] ?? null,
        'vatType'              => $header['lblVATType'] ?? null,

        'showValidTill'        => (bool) ($header['ShowValidTill'] ?? false),
        'showTermsOfPayment'   => (bool) ($header['ShowTermsOfPayment'] ?? true),
        'showWarranty'         => (bool) ($header['ShowWarranty'] ?? false),
        'showAvailability'     => (bool) ($header['ShowQuotationAvailability'] ?? false),
        'showSpecialNotes'     => (bool) ($header['ShowSpecialNotes'] ?? false),
        'showPriceColumns'     => (bool) ($header['ShowPriceColumns'] ?? false),
        'showTotalPrice'       => (bool) ($header['ShowTotalPrice'] ?? true),
        'showItemAvailability' => (bool) ($header['ShowItemAvailability'] ?? false),
        'showWarrantyPerItem'  => (bool) ($header['ShowWarrantyPerItem'] ?? false),

        'companyCode'          => (int) ($header['CompanyCode'] ?? 1),
        'company' => [
            'name'      => 'ICS (Integrated Computer Systems, Inc.)',
            'address'   => $header['CompanyAddress'] ?? '',
            'telephone' => !empty($header['CompanyTelephone']) ? $header['CompanyTelephone'] : null,
            'fax'       => !empty($header['CompanyFax']) ? $header['CompanyFax'] : null,
            'logo'      => base64_encode_image(dirname(__DIR__) . '/public/ics_logo.png'),
        ],

        'client' => [
            'name'          => $header['CustomerName'] ?? '',
            'contactPerson' => $header['ContactName'] ?? null,
            'address'       => $header['Address'] ?? null,
            'telephone'     => !empty($header['Telephone']) ? $header['Telephone'] : null,
        ],

        'lineItems' => array_map(function ($item) {
            return [
                'description'    => $item['Description'] ?? '',
                'quantity'       => (int) ($item['Qty'] ?? 1),
                'unitPrice'      => (float) ($item['UnitPrice'] ?? 0),
                'totalPrice'     => (float) ($item['TotalPrice'] ?? 0),
                'availability'   => !empty($item['Availability']) ? $item['Availability'] : null,
                'warranty'       => !empty($item['Warranty']) ? $item['Warranty'] : null,
                'showItemPrices' => (bool) ($item['ShowItemPrices'] ?? true),
            ];
        }, $lineItems),

        'totals' => [
            'subtotal'   => (float) ($header['Total'] ?? 0),
            'grandTotal' => (float) ($header['Total'] ?? 0),
        ],
    ];

    try {
        $pdf = $converter->fromArray($mapped)->stream();

        // Validate PDF header
        if (str_starts_with($pdf, '%PDF-')) {
            $outputPath = $outputDir . '/' . $key . '.pdf';
            file_put_contents($outputPath, $pdf);
            $sizeKb = round(strlen($pdf) / 1024, 1);
            echo "  [✓] PDF generated: {$outputPath} ({$sizeKb} KB)\n";
            $passed++;
        } else {
            echo "  [✗] Output does not start with %PDF- header.\n";
            $failed++;
        }
    } catch (\Throwable $e) {
        echo "  [✗] Error: {$e->getMessage()}\n";
        echo "      File: {$e->getFile()}:{$e->getLine()}\n";
        $failed++;
    }

    echo "\n";
}

// ─── 5. Summary ────────────────────────────────────────────────

echo "═══════════════════════════════════════════════════════\n";
echo " Results: {$passed} passed, {$failed} failed\n";
echo "═══════════════════════════════════════════════════════\n";

exit($failed > 0 ? 1 : 0);

// ────────────────────────────────────────────────────────────────
// Helpers
// ────────────────────────────────────────────────────────────────

function formatDate(?string $date): ?string
{
    if (empty($date) || $date === '1990-01-01 00:00:00') {
        return null;
    }

    try {
        return (new \DateTime($date))->format('m/d/Y');
    } catch (\Exception $e) {
        return $date;
    }
}

/**
 * Helper to encode an image as base64 for Dompdf compatibility.
 */
function base64_encode_image(string $path): ?string
{
    if (!file_exists($path)) {
        return null;
    }

    $type = pathinfo($path, PATHINFO_EXTENSION);
    $data = file_get_contents($path);
    return 'data:image/' . $type . ';base64,' . base64_encode($data);
}
