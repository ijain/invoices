<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Api\Dto;

use App\Domain\Invoice\Domain\Models\Invoice;
use App\Domain\Invoice\Domain\Models\Product;
use App\Domain\Invoice\Domain\ValueObjects\BilledCompanyVo;
use App\Domain\Invoice\Domain\ValueObjects\CompanyVo;
use App\Domain\Invoice\Domain\ValueObjects\DateVo;
use App\Domain\Invoice\Domain\ValueObjects\MoneyVo;

class InvoiceDto
{
    public string $number;
    public DateVo $date;
    public DateVo $dueDate;
    public CompanyVo $company;
    public BilledCompanyVo $billedCompany;
    public Product $products;
    public MoneyVo $totalPrice;

    private function __construct(
        string $number,
        DateVo $date,
        DateVo $dueDate,
        CompanyVo $company,
        BilledCompanyVo $billedCompany,
        Product $products,
        MoneyVo $totalPrice,
    ) {
        $this->number = $number;
        $this->date = $date;
        $this->dueDate = $dueDate;
        $this->company = $company;
        $this->billedCompany = $billedCompany;
        $this->products = $products;
        $this->totalPrice = $totalPrice;
    }

    public static function fromModel(Invoice $invoice): self
    {
        return new self(
            $invoice->number,
            DateVo::create($invoice->date),
            DateVo::create($invoice->due_date),
            CompanyVo::create($invoice->company),
            BilledCompanyVo::create($invoice->company),
            $invoice->products,
            MoneyVo::create($invoice->total_price)
        );
    }

    /**
     * @return array<string, Invoice, DateVo, CompanyVo, BilledCompanyVo>
     */
    public function toArray(): array
    {
        return [
            'number' => $this->number,
            'date' => $this->date->format(),
            'due_date' => $this->dueDate->format(),
            'company' => $this->company,
            'billed_company' => $this->billedCompany,
            'products' => $this->products,
            'total_price' => $this->totalPrice->format(),
        ];
    }
}
