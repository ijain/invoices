<?php

declare(strict_types=1);

namespace App\Domain\Invoice\Domain\ValueObjects;

use Illuminate\Database\Eloquent\Model;

final readonly class BilledCompanyVo
{
    private string $name;
    private string $street;
    private string $city;
    private string $zip;
    private string $phone;
    private string $email;

    private function __construct(Model $company)
    {
        $this->name = $company->name;
        $this->street = $company->street;
        $this->city = $company->city;
        $this->zip = $company->zip;
        $this->phone = $company->phone;
        $this->email = $company->email;
    }

    public static function create(Model|string|int $value): self
    {
        return new self($value);
    }

    /**
     * @return array<string>
     */
    public function format(): array
    {
        return [
            'name' => $this->name,
            'street' => $this->street,
            'city' => $this->city,
            'zip' => $this->zip,
            'phone' => $this->phone,
            'email' => $this->email,
        ];
    }
}
