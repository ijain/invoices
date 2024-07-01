<?php

declare(strict_types=1);

namespace App\Domain\Invoice\Domain\Services;

use App\Domain\Invoice\Domain\Repositories\InvoiceRepositoryInterface;
use App\Modules\Invoices\Api\Dto\InvoiceDto;

class InvoiceService
{
    private string $id;
    private InvoiceRepositoryInterface $invoiceRepository;

    public function __construct(string $id, InvoiceRepositoryInterface $invoiceRepository)
    {
        $this->id = $id;
        $this->invoiceRepository = $invoiceRepository;
    }

    public function getInvoice(): ?InvoiceDto
    {
        return $this->invoiceRepository->findById($this->id);
    }

    public function processApproval(): bool
    {
        $invoiceDto = $this->getInvoice();

        return $invoiceDto && $this->invoiceRepository->approved($invoiceDto);
    }

    public function processRejection(): bool
    {
        $invoiceDto = $this->getInvoice();

        return $invoiceDto && $this->invoiceRepository->rejected($invoiceDto);
    }
}
