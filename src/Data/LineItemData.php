<?php

declare(strict_types=1);

namespace Quotation\Converter\Data;

/**
 * Immutable DTO for a single quotation line item.
 */
final class LineItemData
{
    public function __construct(
        public readonly string  $description,
        public readonly int     $quantity = 1,
        public readonly ?string $unit = null,
        public readonly float   $unitPrice = 0.0,
        public readonly float   $totalPrice = 0.0,
        public readonly ?string $availability = null,
        public readonly ?string $warranty = null,
        public readonly bool    $showItemPrices = true,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            description:    $data['description']    ?? '',
            quantity:        (int) ($data['quantity'] ?? 1),
            unit:           $data['unit']            ?? null,
            unitPrice:      (float) ($data['unitPrice'] ?? 0),
            totalPrice:     (float) ($data['totalPrice'] ?? 0),
            availability:   $data['availability']   ?? null,
            warranty:       $data['warranty']        ?? null,
            showItemPrices: (bool) ($data['showItemPrices'] ?? true),
        );
    }

    public function toArray(): array
    {
        return [
            'description'    => $this->description,
            'quantity'       => $this->quantity,
            'unit'           => $this->unit,
            'unitPrice'      => $this->unitPrice,
            'totalPrice'     => $this->totalPrice,
            'availability'   => $this->availability,
            'warranty'       => $this->warranty,
            'showItemPrices' => $this->showItemPrices,
        ];
    }
}
