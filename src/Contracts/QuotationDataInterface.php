<?php

declare(strict_types=1);

namespace Quotation\Converter\Contracts;

use Quotation\Converter\Data\ClientData;
use Quotation\Converter\Data\CompanyData;
use Quotation\Converter\Data\LineItemData;
use Quotation\Converter\Data\TotalsData;

/**
 * Contract interface mirroring QuotationData's shape.
 *
 * Implement this if you prefer interface-driven consumption instead of
 * using the concrete QuotationData DTO directly. The Converter accepts both.
 */
interface QuotationDataInterface
{
    public function getId(): string;

    public function getQuotationName(): string;

    public function getDate(): string;

    public function getCompany(): CompanyData;

    public function getClient(): ClientData;

    /** @return LineItemData[] */
    public function getLineItems(): array;

    public function getTotals(): TotalsData;

    public function getCurrency(): string;

    public function getValidUntil(): ?string;

    public function getReference(): ?string;

    public function getTermsOfPayment(): ?string;

    public function getNotes(): ?string;

    public function getAvailability(): ?string;

    public function getWarranty(): ?string;

    public function getSignatoryName(): ?string;

    public function getAccountName(): ?string;

    public function getVatType(): ?string;

    public function shouldShowValidTill(): bool;

    public function shouldShowTermsOfPayment(): bool;

    public function shouldShowWarranty(): bool;

    public function shouldShowAvailability(): bool;

    public function shouldShowSpecialNotes(): bool;

    public function shouldShowPriceColumns(): bool;

    public function shouldShowTotalPrice(): bool;

    public function shouldShowItemAvailability(): bool;

    public function shouldShowWarrantyPerItem(): bool;
}
