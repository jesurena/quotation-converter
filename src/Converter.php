<?php

declare(strict_types=1);

namespace Quotation\Converter;

use Illuminate\Contracts\View\Factory as ViewFactory;
use Dompdf\Dompdf;
use Dompdf\Options;
use Quotation\Converter\Contracts\QuotationDataInterface;
use Quotation\Converter\Data\QuotationData;

/**
 * The main public API — a pure "Data → PDF" engine.
 *
 * This class NEVER touches any database. It accepts a QuotationData DTO
 * (or any implementor of QuotationDataInterface) and renders a PDF via Dompdf.
 */
class Converter
{
    private ?QuotationData $data = null;

    /** Paper size (default: A4). */
    private string $paperSize = 'a4';

    /** Paper orientation. */
    private string $orientation = 'portrait';

    public function __construct(
        private readonly ViewFactory $viewFactory,
    ) {}

    // ─── Input Methods ──────────────────────────────────────────────

    /**
     * Hydrate from a plain associative array.
     */
    public function fromArray(array $data): self
    {
        $this->data = QuotationData::fromArray($data);

        return $this;
    }

    /**
     * Accept a pre-built DTO.
     */
    public function fromDto(QuotationData $dto): self
    {
        $this->data = $dto;

        return $this;
    }

    /**
     * Accept any implementor of the QuotationDataInterface contract.
     */
    public function fromContract(QuotationDataInterface $contract): self
    {
        // Map the interface getters into the concrete DTO via fromArray
        $this->data = QuotationData::fromArray([
            'id'                   => $contract->getId(),
            'quotationName'        => $contract->getQuotationName(),
            'date'                 => $contract->getDate(),
            'company'              => $contract->getCompany(),
            'client'               => $contract->getClient(),
            'lineItems'            => $contract->getLineItems(),
            'totals'               => $contract->getTotals(),
            'currency'             => $contract->getCurrency(),
            'validUntil'           => $contract->getValidUntil(),
            'reference'            => $contract->getReference(),
            'termsOfPayment'       => $contract->getTermsOfPayment(),
            'notes'                => $contract->getNotes(),
            'availability'         => $contract->getAvailability(),
            'warranty'             => $contract->getWarranty(),
            'signatoryName'        => $contract->getSignatoryName(),
            'accountName'          => $contract->getAccountName(),
            'vatType'              => $contract->getVatType(),
            'showValidTill'        => $contract->shouldShowValidTill(),
            'showTermsOfPayment'   => $contract->shouldShowTermsOfPayment(),
            'showWarranty'         => $contract->shouldShowWarranty(),
            'showAvailability'     => $contract->shouldShowAvailability(),
            'showSpecialNotes'     => $contract->shouldShowSpecialNotes(),
            'showPriceColumns'     => $contract->shouldShowPriceColumns(),
            'showTotalPrice'       => $contract->shouldShowTotalPrice(),
            'showItemAvailability' => $contract->shouldShowItemAvailability(),
            'showWarrantyPerItem'  => $contract->shouldShowWarrantyPerItem(),
        ]);

        return $this;
    }

    // ─── Configuration ──────────────────────────────────────────────

    /**
     * Set the paper size (e.g., 'letter', 'a4', 'legal').
     */
    public function paperSize(string $size): self
    {
        $this->paperSize = $size;

        return $this;
    }

    /**
     * Set the paper orientation ('portrait' or 'landscape').
     */
    public function orientation(string $orientation): self
    {
        $this->orientation = $orientation;

        return $this;
    }

    // ─── Output Methods ─────────────────────────────────────────────

    /**
     * Render and return the raw PDF binary string.
     */
    public function stream(): string
    {
        $this->ensureDataIsSet();

        return $this->renderPdf();
    }

    /**
     * Return a download HTTP response.
     */
    public function download(string $filename = 'quotation.pdf'): \Illuminate\Http\Response
    {
        $content = $this->stream();

        return new \Illuminate\Http\Response($content, 200, [
            'Content-Type'        => 'application/pdf',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
            'Content-Length'      => strlen($content),
        ]);
    }

    /**
     * Return an inline (browser-viewable) HTTP response.
     */
    public function inline(string $filename = 'quotation.pdf'): \Illuminate\Http\Response
    {
        $content = $this->stream();

        return new \Illuminate\Http\Response($content, 200, [
            'Content-Type'        => 'application/pdf',
            'Content-Disposition' => 'inline; filename="' . $filename . '"',
            'Content-Length'      => strlen($content),
        ]);
    }

    /**
     * Render only the HTML (useful for debugging the template).
     */
    public function html(): string
    {
        $this->ensureDataIsSet();

        return $this->viewFactory
            ->make('quotation-pkg::pdf', ['quotation' => $this->data])
            ->render();
    }

    // ─── Internals ──────────────────────────────────────────────────

    private function ensureDataIsSet(): void
    {
        if ($this->data === null) {
            throw new \RuntimeException(
                'No quotation data provided. Call fromArray(), fromDto(), or fromContract() first.'
            );
        }
    }

    /**
     * Convert the Blade templates into a PDF binary string via Dompdf.
     */
    private function renderPdf(): string
    {
        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isRemoteEnabled', true);
        $options->set('isPhpEnabled', true);
        $options->set('defaultFont', 'Times New Roman');

        $dompdf = new Dompdf($options);
        
        // Load the full unified HTML content
        $html = $this->html();
        $dompdf->loadHtml($html);

        // Set paper size and orientation
        $dompdf->setPaper($this->paperSize, $this->orientation);

        // Render the PDF
        $dompdf->render();

        // Return the raw PDF binary
        return $dompdf->output();
    }
}
