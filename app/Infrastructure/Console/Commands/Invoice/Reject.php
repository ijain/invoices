<?php

declare(strict_types=1);

namespace App\Infrastructure\Console\Commands\Invoice;

use Illuminate\Console\Command;
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
    protected $description = 'Set invoice status: approve, reject or exit';

    /**
     * Execute the console command.
     *
     */
    public function handle(): int
    {
        return CommandAlias::SUCCESS;
    }
}
