<?php

namespace MarJose123\ZohoCliqAlert\Commands;

use Illuminate\Console\Command;

class ZohoCliqAlertCommand extends Command
{
    public $signature = 'laravel-zoho-cliq-alert';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
