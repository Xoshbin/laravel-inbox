<?php

namespace Xoshbin\Inbox\Console;

use Illuminate\Console\Command;

class InstallInbox extends Command
{
    protected $signature = 'inbox:install';

    protected $description = 'Install Inbox package assets and configurations';

    public function handle()
    {
        $this->info('Installing Inbox...');

        $this->info('Publishing configuration...');
        $this->call('vendor:publish', [
            '--provider' => "Xoshbin\Inbox\InboxServiceProvider",
            '--tag' => "config"
        ]);

        $this->comment('Publishing Migrations...');
        $this->call('vendor:publish', [
            '--provider' => "Xoshbin\Inbox\InboxServiceProvider",
            '--tag' => "migrations"
        ]);

        $this->comment('Publishing Inbox Assets...');
        $this->call('vendor:publish', ['--tag' => 'inbox-assets']);

        $this->info('Installed Inbox');
    }
}
