<?php

namespace Xoshbin\Inbox\Console;

use Illuminate\Console\Command;

class AssetsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'inbox:assets';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Re-publish the inbox assets';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $this->call('vendor:publish', [
            '--tag' => 'inbox-assets',
            '--force' => true,
        ]);

        $this->call('vendor:publish', [
            '--tag' => 'views',
            '--force' => true,
        ]);
    }
}
