<?php

declare(strict_types=1);

namespace App\Infrastructure\Console\Commands\Invoice;

use App\Domain\Invoice\Domain\Models\Invoice;
use App\Domain\Invoice\Domain\Services\InvoiceService;
use App\Domain\Invoice\Infrastructure\Persistence\Repositories\InvoiceRepository;
use App\Modules\Approval\Application\ApprovalFacade;
use Illuminate\Console\Command;
use Illuminate\Events\Dispatcher;
use Symfony\Component\Console\Command\Command as CommandAlias;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Helper\TableSeparator;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

//use Symfony\Component\Console\Command\Command as CommandAlias;

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
    //protected $description = 'Show the invoice data with options to approve, reject or exit';
    protected $description = 'Show invoice';

    /**
     * Execute the console command.
     *
     */
    public function execute(InputInterface $input, OutputInterface $output): int
    {
        /*$user = new InvoiceDtoInterface();

        $user->name = $this->argument('name');
        $user->phone = $this->argument('phone');//Value: '212.456.7890'

        $user->save();

        $this->info('User successfully created!');*/

        $invoice = Invoice::find('0b6b5b90-050a-4776-92fb-78517db83387');
        //dd($invoice->products);
        $dispatcher = new Dispatcher();

        $invoiceService = new InvoiceService(
            '0b6b5b90-050a-4776-92fb-78517db83387',
            new InvoiceRepository(),
            new ApprovalFacade($dispatcher)
        );

        $a = $invoiceService->showInvoice()->format();

        dd($a);

//StatusEnum::cases()[array_rand(StatusEnum::cases())];

        //$output = new \Symfony\Component\Console\Output\ConsoleOutput(2);
        //
        //$output->writeln('hello');

        /// fixed width
        //$mask = "|%5.5s |%-30.30s | x |\n";
        //printf($mask, 'Num', 'Title');
        //printf($mask, '1', 'A value that fits the cell');
        //printf($mask, '2', 'A too long value the end of which will be cut off');

        //https://symfony.com/doc/current/components/console/helpers/table.html

        //$invoice = Invoice::find('0b6b5b90-050a-4776-92fb-78517db83387');
        //dd($invoice->products[0]->pivot->quantity);

        $table = new Table($output);
        $table
            ->setHeaders(['ISBN', 'Title', 'Author'])
            ->setRows([
                ['99921-58-10-7', 'Divine Comedy', 'Dante Alighieri'],
                ['9971-5-0210-0', 'A Tale of Two Cities', 'Charles Dickens'],
                ['960-425-059-0', 'The Lord of the Rings', 'J. R. R. Tolkien'],
                ['80-902734-1-6', 'And Then There Were None', 'Agatha Christie'],
            ])
        ;

        $table->render();

        $table = new Table($output);

        $table->setRows([
            ['99921-58-10-7', 'Divine Comedy', 'Dante Alighieri'],
            ['9971-5-0210-0', 'A Tale of Two Cities', 'Charles Dickens'],
            new TableSeparator(),
            ['960-425-059-0', 'The Lord of the Rings', 'J. R. R. Tolkien'],
            ['80-902734-1-6', 'And Then There Were None', 'Agatha Christie'],
        ]);

        $table->render();

        return CommandAlias::SUCCESS;
    }
}
