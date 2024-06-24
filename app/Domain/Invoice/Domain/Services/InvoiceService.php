<?php

declare(strict_types=1);

namespace App\Domain\Invoice\Domain\Services;

use App\Domain\Invoice\Domain\Models\Invoice;
use App\Domain\Invoice\Domain\Repositories\InvoiceRepositoryInterface;
use App\Domain\Invoice\Infrastructure\Persistence\Repositories\InvoiceRepository;
use App\Modules\Invoices\Api\Dto\InvoiceDto;

class InvoiceService
{
    private string $id;
    private InvoiceRepositoryInterface $invoiceRepository;

    public function __construct(string $id)
    {
        $this->id = $id;
        $this->invoiceRepository = new InvoiceRepository();
    }

    public function getInvoice(): ?InvoiceDto
    {
        return $this->invoiceRepository->findById($this->id);
    }

    public function processApproval(): bool
    {
        $invoice = Invoice::find($this->id);

        return $invoice && $this->invoiceRepository->approved($invoice);
    }

    public function processRejection(): bool
    {
        $invoice = Invoice::find($this->id);

        return $invoice && $this->invoiceRepository->rejected($invoice);
    }
}
