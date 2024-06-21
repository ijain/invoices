<?php

declare(strict_types=1);

namespace App\Domain\Invoice\Infrastructure\Persistence\Repositories;

use App\Domain\Enums\StatusEnum;
use App\Domain\Invoice\Domain\Models\Invoice;
use App\Domain\Invoice\Domain\Repositories\InvoiceRepositoryInterface;
use App\Modules\Approval\Api\Dto\ApprovalDto;
use App\Modules\Invoices\Api\Dto\InvoiceDto;

/**
 * returns DTOs
 */
class InvoiceRepository implements InvoiceRepositoryInterface
{
    public function findById(string $id): ?InvoiceDto
    {
        $invoice = Invoice::findOrFail($id);

        return InvoiceDto::fromModel($invoice);
    }

    public function approved(Invoice $invoice): ApprovalDto
    {
        return new ApprovalDto(
            $invoice->id,
            StatusEnum::APPROVED,
            Invoice::class
        );
    }

    public function rejected(Invoice $invoice): ApprovalDto
    {
        return new ApprovalDto(
            $invoice->id,
            StatusEnum::REJECTED,
            Invoice::class
        );
    }
}
