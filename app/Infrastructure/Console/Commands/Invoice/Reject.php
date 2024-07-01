<?php

declare(strict_types=1);

namespace App\Infrastructure\Console\Commands\Invoice;

use App\Domain\Invoice\Domain\Services\InvoiceService;
use App\Domain\Invoice\Infrastructure\Persistence\Repositories\InvoiceRepository;
use Exception;
use Illuminate\Console\Command;
use Ramsey\Uuid\Uuid as UuidValidator;
use Symfony\Component\Console\Command\Command as CommandAlias;

class Reject extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'invoice:reject';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = "Change invoice status from draft to rejected";

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
            $invoiceService->processRejection();
            $this->info('Status changed to Rejected');

            return CommandAlias::SUCCESS;
        } catch (Exception $e) {
            $this->info($e->getMessage());

            return CommandAlias::FAILURE;
        }
    }
}
