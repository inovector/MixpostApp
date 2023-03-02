<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Exception;

class Publish extends Command
{
    protected $signature = 'mixpost:publish';

    protected $description = 'Publish all assets requested by Mixpost';

    public function handle(): void
    {
        $this->info('Publishing Mixpost assets...');
        $this->info('');

        $commands = [
            'mixpost:publish-assets --force=true',
            'vendor:publish --tag=mixpost-migrations',
            'vendor:publish --tag=mixpost-auth-assets',
            'horizon:publish',
        ];

        collect($commands)->each(function (string $command) {
            $this->comment("Executing `{$command}`...");

            try {
                Artisan::call($command, [], $this->output);
            } catch (Exception $exception) {
                $this->error("Error executing command: `{$exception->getMessage()}`");
            }

            $this->info('');
        });

        $this->info('All assets has been published!');
    }
}
