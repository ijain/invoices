<?php

declare(strict_types=1);

namespace App\Infrastructure\Console\Commands\Invoice;

use App\Domain\Invoice\Domain\Dto\InvoiceDtoInterface;
use Illuminate\Console\Command;
use Symfony\Component\Console\Command\Command as CommandAlias;

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
    public function handle(): int
    {
        $user = new InvoiceDtoInterface();

        $user->name = $this->argument('name');
        $user->phone = $this->argument('phone');//Value: '212.456.7890'

        $user->save();

        $this->info('User successfully created!');

        return CommandAlias::SUCCESS;
    }
}
