<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Str;

class SetupGitIgnore extends Command
{

    protected $signature = 'mixpost:setup-gitignore';

    protected $description = 'Setup the .gitignore';

    public function handle()
    {
        $path = base_path('.gitignore');

        $content = collect(file(base_path('.gitignore')))
            ->reject(fn (string $line) => Str::startsWith($line, 'composer.lock'))
            ->reject(fn (string $line) => Str::startsWith($line, 'public/vendor/mixpost'))
            ->reject(fn (string $line) => Str::startsWith($line, 'public/vendor/mixpost-auth'))
            ->reject(fn (string $line) => Str::startsWith($line, 'public/vendor/horizon'))
            ->implode('');

        file_put_contents($path, $content);

        $this->info('.gitignore setup complete!');
    }
}
