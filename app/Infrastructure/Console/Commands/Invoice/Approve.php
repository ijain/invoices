<?php

declare(strict_types=1);

namespace App\Infrastructure\Console\Commands\Invoice;

use App\Domain\Invoice\Domain\Services\InvoiceService;
use App\Domain\Invoice\Infrastructure\Persistence\Repositories\InvoiceRepository;
use Exception;
use Illuminate\Console\Command;
use Ramsey\Uuid\Uuid as UuidValidator;
use Symfony\Component\Console\Command\Command as CommandAlias;

class Approve extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'invoice:approve';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = "Change invoice status from draft to approved";

    /**
     * Execute the console command.
     *
     */
    public function handle(): int
    {
        $inputInvoiceId = $this->ask('Give me invoice ID');
        $isValidInput = UuidValidator::isValid($inputInvoiceId);

        if (!$isValidInput) {
            $this->info('Invalid ID');

            return CommandAlias::FAILURE;
        }

        $invoiceService = new InvoiceService($inputInvoiceId, new InvoiceRepository());

        try {
            $invoiceService->processApproval();
            $this->info('Status changed to Approved');

            return CommandAlias::SUCCESS;
        } catch (Exception $e) {
            $this->info($e->getMessage());

            return CommandAlias::FAILURE;
        }
    }
}
