<?php

declare(strict_types=1);

namespace Quotation\Converter\Data;

/**
 * Immutable DTO for quotation financial totals.
 */
final class TotalsData
{
    public function __construct(
        public readonly float  $subtotal = 0.0,
        public readonly float  $discountTotal = 0.0,
        public readonly float  $taxRate = 0.0,
        public readonly float  $taxAmount = 0.0,
        public readonly float  $grandTotal = 0.0,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            subtotal:      (float) ($data['subtotal']      ?? 0),
            discountTotal: (float) ($data['discountTotal'] ?? 0),
            taxRate:       (float) ($data['taxRate']        ?? 0),
            taxAmount:     (float) ($data['taxAmount']      ?? 0),
            grandTotal:    (float) ($data['grandTotal']     ?? 0),
        );
    }

    public function toArray(): array
    {
        return [
            'subtotal'      => $this->subtotal,
            'discountTotal' => $this->discountTotal,
            'taxRate'       => $this->taxRate,
            'taxAmount'     => $this->taxAmount,
            'grandTotal'    => $this->grandTotal,
        ];
    }
}
