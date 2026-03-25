<?php

declare(strict_types=1);

namespace Quotation\Converter\Data;

/**
 * Immutable DTO representing the issuing company's details.
 *
 * This is decoupled from any database column — the application-side mapper
 * is responsible for populating these fields from whatever source it uses.
 */
final class CompanyData
{
    public function __construct(
        public readonly string  $name,
        public readonly string  $address,
        public readonly ?string $telephone = null,
        public readonly ?string $fax = null,
        public readonly ?string $email = null,
        public readonly ?string $logo = null, // base64-encoded image or absolute path
    ) {}

    /**
     * Hydrate from a plain associative array.
     */
    public static function fromArray(array $data): self
    {
        return new self(
            name:      $data['name']      ?? '',
            address:   $data['address']   ?? '',
            telephone: $data['telephone'] ?? null,
            fax:       $data['fax']       ?? null,
            email:     $data['email']     ?? null,
            logo:      $data['logo']      ?? null,
        );
    }

    public function toArray(): array
    {
        return [
            'name'      => $this->name,
            'address'   => $this->address,
            'telephone' => $this->telephone,
            'fax'       => $this->fax,
            'email'     => $this->email,
            'logo'      => $this->logo,
        ];
    }
}
