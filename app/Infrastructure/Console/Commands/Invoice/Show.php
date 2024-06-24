<?php

declare(strict_types=1);

namespace App\Infrastructure\Console\Commands\Invoice;

use App\Domain\Invoice\Domain\Services\InvoiceService;
use Exception;
use Illuminate\Console\Command;
use Ramsey\Uuid\Uuid as UuidValidator;
use Symfony\Component\Console\Command\Command as CommandAlias;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class Show extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'invoice:show';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Print invoice';

    /**
     * Execute the console command.
     *
     */
    public function execute(InputInterface $input, OutputInterface $output): int
    {
        $inputInvoiceId = $this->ask('Give me invoice ID');
        $isValidInput = UuidValidator::isValid($inputInvoiceId);

        if (!$isValidInput) {
            $this->info('Invalid ID');

            return CommandAlias::FAILURE;
        }

        $invoiceService = new InvoiceService($inputInvoiceId);

        try {
            $invoice = $invoiceService->getInvoice()->format();

            $tableInvoiceData = new Table($output);
            $tableInvoiceData
                ->setHeaders(['Number', 'Data', 'Due Date'])
                ->setHeaderTitle('Invoice')
                ->setVertical()
                ->setRows([[$invoice['number'], $invoice['date'], $invoice['due_date']]]);
            $tableInvoiceData->render();

            $tableCompany = new Table($output);
            $tableCompany
                ->setHeaders(['Name', 'Street', 'City', 'Zip', 'Phone'])
                ->setHeaderTitle('Company')
                ->setVertical()
                ->setRows([$invoice['company']]);
            $tableCompany->render();

            $tableBilledCompany = new Table($output);
            $tableBilledCompany
                ->setHeaders(['Name', 'Street', 'City', 'Zip', 'Phone', 'Email'])
                ->setHeaderTitle('Billed Company')
                ->setVertical()
                ->setRows([$invoice['billed_company']]);
            $tableBilledCompany->render();

            $tableProducts = new Table($output);
            $tableProducts
                ->setHeaders(['Name', 'Quantity', 'Price', 'Total Price'])
                ->setHeaderTitle('Products')
                ->setFooterTitle('Total invoice amount: ' . $invoice['total_amount'])
                ->setRows($invoice['products']);
            $tableProducts->render();

            return CommandAlias::SUCCESS;
        } catch (Exception $e) {
            $this->info($e->getMessage());

            return CommandAlias::FAILURE;
        }
    }
}
