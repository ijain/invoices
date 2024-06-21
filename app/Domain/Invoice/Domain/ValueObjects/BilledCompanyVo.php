<?php

declare(strict_types=1);

namespace App\Domain\Invoice\Domain\ValueObjects;

use App\Domain\Invoice\Domain\Models\Company;

final readonly class BilledCompanyVo
{
    private string $id;
    private string $name;
    private string $street;
    private string $city;
    private string $zip;
    private string $phone;
    private string $email;

    private function __construct(Company $company)
    {
        $this->id = $company->id;
        $this->name = $company->name;
        $this->street = $company->street;
        $this->city = $company->city;
        $this->zip = $company->zip;
        $this->phone = $company->phone;
        $this->email = $company->email;
    }

    public static function create(Company $company): self
    {
        return new self($company);
    }
}
