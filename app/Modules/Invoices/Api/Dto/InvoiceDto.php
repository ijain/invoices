<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Api\Dto;

use App\Domain\Invoice\Domain\Models\Invoice;
use App\Domain\Invoice\Domain\ValueObjects\BilledCompanyVo;
use App\Domain\Invoice\Domain\ValueObjects\CompanyVo;
use App\Domain\Invoice\Domain\ValueObjects\DateVo;
use App\Domain\Invoice\Domain\ValueObjects\MoneyVo;

final class InvoiceDto
{
    public string $number;
    public DateVo $date;
    public DateVo $dueDate;
    public CompanyVo $company;
    public BilledCompanyVo $billedCompany;
    public InvoiceProductListDto $products;
    public MoneyVo $totalAmount;

    private function __construct(
        string $number,
        DateVo $date,
        DateVo $dueDate,
        CompanyVo $company,
        BilledCompanyVo $billedCompany,
        InvoiceProductListDto $products,
        MoneyVo $totalAmount,
    ) {
        $this->number = $number;
        $this->date = $date;
        $this->dueDate = $dueDate;
        $this->company = $company;
        $this->billedCompany = $billedCompany;
        $this->products = $products;
        $this->totalAmount = $totalAmount;
    }

    public static function fromModel(Invoice $invoice): self
    {
        return new self(
            $invoice->number,
            DateVo::create($invoice->date),
            DateVo::create($invoice->due_date),
            CompanyVo::create($invoice->company),
            BilledCompanyVo::create($invoice->company),
            InvoiceProductListDto::fromCollection($invoice->products),
            MoneyVo::create($invoice->total_amount)
        );
    }

    /**
     * @return array<string, Invoice, DateVo, CompanyVo, BilledCompanyVo>
     */
    public function format(): array
    {
        return [
            'number' => $this->number,
            'date' => $this->date->format(),
            'due_date' => $this->dueDate->format(),
            'company' => $this->company->format(),
            'billed_company' => $this->billedCompany->format(),
            'products' => $this->products->format(),
            'total_amount' => $this->totalAmount->format(),
        ];
    }
}
