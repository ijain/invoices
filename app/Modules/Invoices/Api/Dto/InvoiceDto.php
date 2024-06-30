<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Api\Dto;

use App\Domain\Enums\StatusEnum;
use App\Domain\Invoice\Domain\Models\Invoice;
use App\Domain\Invoice\Domain\ValueObjects\BilledCompanyVo;
use App\Domain\Invoice\Domain\ValueObjects\CompanyVo;
use App\Domain\Invoice\Domain\ValueObjects\DateVo;
use App\Domain\Invoice\Domain\ValueObjects\MoneyVo;

final class InvoiceDto
{
    public ?string $id;
    public string $number;
    public DateVo $date;
    public DateVo $dueDate;
    public CompanyVo $company;
    public BilledCompanyVo $billedCompany;
    public InvoiceProductsDto $products;
    public MoneyVo $totalAmount;
    public StatusEnum $status;

    private function __construct(
        ?string $id,
        string $number,
        DateVo $date,
        DateVo $dueDate,
        CompanyVo $company,
        BilledCompanyVo $billedCompany,
        InvoiceProductsDto $products,
        MoneyVo $totalAmount,
        StatusEnum $status,
    ) {
        $this->id = $id;
        $this->number = $number;
        $this->date = $date;
        $this->dueDate = $dueDate;
        $this->company = $company;
        $this->billedCompany = $billedCompany;
        $this->products = $products;
        $this->totalAmount = $totalAmount;
        $this->status = $status;
    }

    public static function fromModel(Invoice $invoice): self
    {
        return new self(
            $invoice->id,
            $invoice->number,
            DateVo::create($invoice->date),
            DateVo::create($invoice->due_date),
            CompanyVo::create($invoice->company),
            BilledCompanyVo::create($invoice->company),
            InvoiceProductsDto::fromCollection($invoice->products),
            MoneyVo::create($invoice->total_amount),
            $invoice->status,
        );
    }

    /**
     * @return array<string, Invoice, DateVo, CompanyVo, BilledCompanyVo>
     */
    public function format(): array
    {
        return [
            'id' => $this->id,
            'number' => $this->number,
            'date' => $this->date->format(),
            'due_date' => $this->dueDate->format(),
            'company' => $this->company->format(),
            'billed_company' => $this->billedCompany->format(),
            'products' => $this->products->format(),
            'total_amount' => $this->totalAmount->format(),
            'status' => $this->status->value,
        ];
    }
}
