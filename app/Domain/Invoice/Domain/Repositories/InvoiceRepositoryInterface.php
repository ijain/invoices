<?php

declare(strict_types=1);

namespace App\Domain\Invoice\Domain\Repositories;

use App\Modules\Invoices\Api\Dto\InvoiceDto;

interface InvoiceRepositoryInterface
{
    public function findById(string $id): ?InvoiceDto;
    public function approved(InvoiceDto $invoiceDto): bool;
    public function rejected(InvoiceDto $invoiceDto): bool;
}
