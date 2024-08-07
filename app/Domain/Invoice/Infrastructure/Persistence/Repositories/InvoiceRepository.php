<?php

declare(strict_types=1);

namespace App\Domain\Invoice\Infrastructure\Persistence\Repositories;

use App\Domain\Invoice\Domain\Models\Invoice;
use App\Domain\Invoice\Domain\Repositories\InvoiceRepositoryInterface;
use App\Modules\Approval\Api\Dto\ApprovalDto;
use App\Modules\Approval\Application\ApprovalFacade;
use App\Modules\Invoices\Api\Dto\InvoiceDto;
use Illuminate\Events\Dispatcher;
use Ramsey\Uuid\Uuid;

class InvoiceRepository implements InvoiceRepositoryInterface
{
    public function findById(string $id): ?InvoiceDto
    {
        $invoice = Invoice::findOrFail($id);

        return InvoiceDto::fromModel($invoice);
    }

    public function approved(InvoiceDto $invoiceDto): bool
    {
        $dispatcher = new Dispatcher();
        $approvalFacade = new ApprovalFacade($dispatcher);

        $uuid = Uuid::fromString($invoiceDto->id);
        $approvalDto = new ApprovalDto($uuid, $invoiceDto->status, Invoice::class);

        return $approvalFacade->approve($approvalDto);
    }

    public function rejected(InvoiceDto $invoiceDto): bool
    {
        $dispatcher = new Dispatcher();
        $approvalFacade = new ApprovalFacade($dispatcher);

        $uuid = Uuid::fromString($invoiceDto->id);
        $approvalDto = new ApprovalDto($uuid, $invoiceDto->status, Invoice::class);

        return $approvalFacade->reject($approvalDto);
    }
}
