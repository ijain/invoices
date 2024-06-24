<?php

declare(strict_types=1);

namespace App\Domain\Invoice\Domain\Repositories;

use App\Domain\Invoice\Domain\Models\Invoice;
use App\Modules\Invoices\Api\Dto\InvoiceDto;

interface InvoiceRepositoryInterface
{
    public function findById(string $id): ?InvoiceDto;
    public function approved(Invoice $invoice): bool;
    public function rejected(Invoice $invoice): bool;
}
