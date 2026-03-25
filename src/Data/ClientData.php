<?php

declare(strict_types=1);

namespace Quotation\Converter\Data;

/**
 * Immutable DTO for the quotation recipient / customer.
 */
final class ClientData
{
    public function __construct(
        public readonly string  $name,
        public readonly ?string $contactPerson = null,
        public readonly ?string $address = null,
        public readonly ?string $telephone = null,
        public readonly ?string $fax = null,
        public readonly ?string $email = null,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            name:          $data['name']          ?? '',
            contactPerson: $data['contactPerson'] ?? null,
            address:       $data['address']       ?? null,
            telephone:     $data['telephone']     ?? null,
            fax:           $data['fax']           ?? null,
            email:         $data['email']         ?? null,
        );
    }

    public function toArray(): array
    {
        return [
            'name'          => $this->name,
            'contactPerson' => $this->contactPerson,
            'address'       => $this->address,
            'telephone'     => $this->telephone,
            'fax'           => $this->fax,
            'email'         => $this->email,
        ];
    }
}
