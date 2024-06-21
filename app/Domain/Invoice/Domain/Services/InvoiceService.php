<?php

declare(strict_types=1);

namespace App\Domain\Invoice\Domain\Services;

use App\Domain\Invoice\Domain\Repositories\InvoiceRepositoryInterface;
use App\Modules\Approval\Api\ApprovalFacadeInterface;
use App\Modules\Invoices\Api\Dto\InvoiceDto;

class InvoiceService
{
    private InvoiceRepositoryInterface $invoiceRepository;
    private ApprovalFacadeInterface $approvalFacade;
    private string $id;

    public function __construct(
        string $id,
        InvoiceRepositoryInterface $invoiceRepository,
        ApprovalFacadeInterface $approvalFacade
    ) {
        $this->invoiceRepository = $invoiceRepository;
        $this->approvalFacade = $approvalFacade;
        $this->id = $id;
    }

    public function showInvoice(): ?InvoiceDto
    {
        return $this->invoiceRepository->findById($this->id);
    }

    public function processApproval(): bool
    {
        $invoiceDto = $this->invoiceRepository->findById($this->id);

        return $this->approvalFacade->approve($invoiceDto);
    }

    public function processRejection(): bool
    {
        $invoiceDto = $this->invoiceRepository->findById($this->id);

        return $this->approvalFacade->reject($invoiceDto);
    }
}
