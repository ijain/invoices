<?php

declare(strict_types=1);

namespace App\Modules\Approval\Api\Events;

use App\Domain\Enums\StatusEnum;
use App\Domain\Invoice\Domain\Models\Invoice;
use App\Modules\Approval\Api\Dto\ApprovalDto;

final readonly class EntityApproved
{
    public function __construct(
        public ApprovalDto $approvalDto
    ) {
        $invoice = Invoice::find($approvalDto->id);
        $invoice->status = StatusEnum::APPROVED;
        $invoice->save();
    }
}
