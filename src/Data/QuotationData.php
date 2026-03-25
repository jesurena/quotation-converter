<?php

declare(strict_types=1);

namespace Quotation\Converter\Data;

/**
 * Top-level immutable DTO — the single input contract for the Converter.
 *
 * This is the ONLY shape the package understands. The application-side mapper
 * is responsible for transforming any database result (raw SQL, Eloquent, API)
 * into this structure. If the underlying schema changes during a refactor,
 * only the mapper needs updating — this DTO (and the package) stays stable.
 */
final class QuotationData
{
    /**
     * @param LineItemData[] $lineItems
     */
    public function __construct(
        public readonly string       $id,
        public readonly string       $quotationName,
        public readonly string       $date,
        public readonly CompanyData  $company,
        public readonly ClientData   $client,
        public readonly array        $lineItems,
        public readonly TotalsData   $totals,
        public readonly string       $currency = 'PHP',
        public readonly ?string      $validUntil = null,
        public readonly ?string      $reference = null,
        public readonly ?string      $termsOfPayment = null,
        public readonly ?string      $notes = null,
        public readonly ?string      $availability = null,
        public readonly ?string      $warranty = null,
        public readonly ?string      $signatoryName = null,
        public readonly ?int         $signatoryId = null,
        public readonly ?string      $accountName = null,
        public readonly ?string      $vatType = null,
        public readonly bool         $showValidTill = false,
        public readonly bool         $showTermsOfPayment = true,
        public readonly bool         $showWarranty = false,
        public readonly bool         $showAvailability = false,
        public readonly bool         $showSpecialNotes = false,
        public readonly bool         $showPriceColumns = false,
        public readonly bool         $showTotalPrice = true,
        public readonly bool         $showItemAvailability = false,
        public readonly bool         $showWarrantyPerItem = false,
    ) {}

    /**
     * Hydrate from a plain associative array.
     *
     * This factory is the primary way application-side code creates this DTO
     * from raw query results, API payloads, or any other source.
     */
    public static function fromArray(array $data): self
    {
        $lineItems = array_map(
            fn(array $item) => $item instanceof LineItemData ? $item : LineItemData::fromArray($item),
            $data['lineItems'] ?? []
        );

        $company = $data['company'] instanceof CompanyData
            ? $data['company']
            : CompanyData::fromArray($data['company'] ?? []);

        $client = $data['client'] instanceof ClientData
            ? $data['client']
            : ClientData::fromArray($data['client'] ?? []);

        $totals = $data['totals'] instanceof TotalsData
            ? $data['totals']
            : TotalsData::fromArray($data['totals'] ?? []);

        return new self(
            id:                    (string) ($data['id'] ?? ''),
            quotationName:         $data['quotationName'] ?? '',
            date:                  $data['date'] ?? '',
            company:               $company,
            client:                $client,
            lineItems:             $lineItems,
            totals:                $totals,
            currency:              $data['currency'] ?? 'PHP',
            validUntil:            $data['validUntil'] ?? null,
            reference:             $data['reference'] ?? null,
            termsOfPayment:        $data['termsOfPayment'] ?? null,
            notes:                 $data['notes'] ?? null,
            availability:          $data['availability'] ?? null,
            warranty:              $data['warranty'] ?? null,
            signatoryName:         $data['signatoryName'] ?? null,
            signatoryId:           (int) ($data['signatoryId'] ?? null),
            accountName:           $data['accountName'] ?? null,
            vatType:               $data['vatType'] ?? null,
            showValidTill:         (bool) ($data['showValidTill'] ?? false),
            showTermsOfPayment:    (bool) ($data['showTermsOfPayment'] ?? true),
            showWarranty:          (bool) ($data['showWarranty'] ?? false),
            showAvailability:      (bool) ($data['showAvailability'] ?? false),
            showSpecialNotes:      (bool) ($data['showSpecialNotes'] ?? false),
            showPriceColumns:      (bool) ($data['showPriceColumns'] ?? false),
            showTotalPrice:        (bool) ($data['showTotalPrice'] ?? true),
            showItemAvailability:  (bool) ($data['showItemAvailability'] ?? false),
            showWarrantyPerItem:   (bool) ($data['showWarrantyPerItem'] ?? false),
        );
    }

    public function toArray(): array
    {
        return [
            'id'                   => $this->id,
            'quotationName'        => $this->quotationName,
            'date'                 => $this->date,
            'company'              => $this->company->toArray(),
            'client'               => $this->client->toArray(),
            'lineItems'            => array_map(fn(LineItemData $i) => $i->toArray(), $this->lineItems),
            'totals'               => $this->totals->toArray(),
            'currency'             => $this->currency,
            'validUntil'           => $this->validUntil,
            'reference'            => $this->reference,
            'termsOfPayment'       => $this->termsOfPayment,
            'notes'                => $this->notes,
            'availability'         => $this->availability,
            'warranty'             => $this->warranty,
            'signatoryName'        => $this->signatoryName,
            'signatoryId'          => $this->signatoryId,
            'accountName'          => $this->accountName,
            'vatType'              => $this->vatType,
            'showValidTill'        => $this->showValidTill,
            'showTermsOfPayment'   => $this->showTermsOfPayment,
            'showWarranty'         => $this->showWarranty,
            'showAvailability'     => $this->showAvailability,
            'showSpecialNotes'     => $this->showSpecialNotes,
            'showPriceColumns'     => $this->showPriceColumns,
            'showTotalPrice'       => $this->showTotalPrice,
            'showItemAvailability' => $this->showItemAvailability,
            'showWarrantyPerItem'  => $this->showWarrantyPerItem,
        ];
    }
}
