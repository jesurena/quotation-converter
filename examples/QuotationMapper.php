<?php

/**
 * EXAMPLE: Application-side Mapper (not autoloaded by the package).
 *
 * This class lives in YOUR Laravel application, not in the package.
 * It demonstrates how to transform raw SQL results from the legacy
 * QuoteHeader / QuoteLineItem tables into the package's DTO format.
 *
 * When the application is refactored and the schema changes, you only
 * need to update THIS mapper — the package remains untouched.
 */

namespace App\Services;

use Quotation\Converter\Data\QuotationData;

class QuotationMapper
{
    /**
     * Map raw SQL result objects into the package's QuotationData DTO.
     *
     * @param  object   $header    Row from dbo.QuoteHeader
     * @param  array    $lineItems Rows from dbo.QuoteLineItem
     * @return QuotationData
     */
    public function map(object $header, array $lineItems): QuotationData
    {
        return QuotationData::fromArray([
            // ─── Identification ─────────────────────────────────
            'id'             => (string) $header->QuotationID,
            'quotationName'  => $header->QuotationName ?? '',
            'date'           => $this->formatDate($header->QuotationDate),
            'reference'      => $header->ReferenceNo ?? null,
            'validUntil'     => $this->formatDate($header->ValidTill),
            'currency'       => $header->Currency ?? 'PHP',
            'termsOfPayment' => $header->TermsOfPayment ?? null,
            'notes'          => $header->SpecialNotes ?: null,
            'availability'   => $header->Availability ?: null,
            'warranty'       => $header->Warranty ?: null,
            'signatoryName'  => $header->SignatoryName ?? null,
            'accountName'    => $header->AccountName ?? null,
            'vatType'        => $header->lblVATType ?? null,

            // ─── Display Flags ──────────────────────────────────
            'showValidTill'        => (bool) ($header->ShowValidTill ?? false),
            'showTermsOfPayment'   => (bool) ($header->ShowTermsOfPayment ?? true),
            'showWarranty'         => (bool) ($header->ShowWarranty ?? false),
            'showAvailability'     => (bool) ($header->ShowQuotationAvailability ?? false),
            'showSpecialNotes'     => (bool) ($header->ShowSpecialNotes ?? false),
            'showPriceColumns'     => (bool) ($header->ShowPriceColumns ?? false),
            'showTotalPrice'       => (bool) ($header->ShowTotalPrice ?? true),
            'showItemAvailability' => (bool) ($header->ShowItemAvailability ?? false),
            'showWarrantyPerItem'  => (bool) ($header->ShowWarrantyPerItem ?? false),

            // ─── Company (Issuer) ───────────────────────────────
            'company' => [
                'name'      => $this->resolveCompanyName($header->CompanyCode ?? 1),
                'address'   => $header->CompanyAddress ?? '',
                'telephone' => $header->CompanyTelephone ?: null,
                'fax'       => $header->CompanyFax ?: null,
            ],

            // ─── Client (Recipient) ─────────────────────────────
            'client' => [
                'name'          => $header->CustomerName ?? '',
                'contactPerson' => $header->ContactName ?? null,
                'address'       => $header->Address ?? null,
                'telephone'     => $header->Telephone ?: null,
            ],

            // ─── Line Items ─────────────────────────────────────
            'lineItems' => array_map(function ($item) {
                return [
                    'description'    => $item->Description ?? '',
                    'quantity'       => (int) ($item->Qty ?? 1),
                    'unitPrice'      => (float) ($item->UnitPrice ?? 0),
                    'totalPrice'     => (float) ($item->TotalPrice ?? 0),
                    'availability'   => $item->Availability ?: null,
                    'warranty'       => $item->Warranty ?: null,
                    'showItemPrices' => (bool) ($item->ShowItemPrices ?? true),
                ];
            }, $lineItems),

            // ─── Totals ─────────────────────────────────────────
            'totals' => [
                'subtotal'   => (float) ($header->Total ?? 0),
                'grandTotal' => (float) ($header->Total ?? 0),
            ],
        ]);
    }

    /**
     * Format a date string for display.
     */
    private function formatDate(?string $date): ?string
    {
        if (empty($date) || $date === '1990-01-01 00:00:00') {
            return null;
        }

        try {
            return (new \DateTime($date))->format('F j, Y');
        } catch (\Exception $e) {
            return $date;
        }
    }

    /**
     * Resolve company name from CompanyCode.
     * Adjust this lookup to match your application's data.
     */
    private function resolveCompanyName(int $code): string
    {
        $companies = [
            1 => 'ICS (Integrated Computer Systems, Inc.)',
            // Add more company codes as needed
        ];

        return $companies[$code] ?? 'Unknown Company';
    }
}
