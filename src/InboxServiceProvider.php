<?php

namespace Xoshbin\Inbox;

use Illuminate\Support\ServiceProvider;
//use BeyondCode\Mailbox\Facades\Mailbox;
use Xoshbin\Inbox\Inbox;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\View;
use Xoshbin\Inbox\Console\AssetsCommand;
use Xoshbin\Inbox\Console\InstallInbox;
use Xoshbin\Inbox\Models\InboxEmail;

class InboxServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     */
    public function boot()
    {
        //Mailbox::catchAll(Inbox::class);

        $this->registerRoutes();
        $this->registerResources();
        $this->registerMigrations();
        $this->defineAssetPublishing();

        $this->globalVariables();
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        if (!defined('INBOX_PATH')) {
            define('INBOX_PATH', realpath(__DIR__ . '/../'));
        }

        $this->app->bind('Inbox', function ($app) {
            return new Inbox();
        });

        $this->configure();
        $this->offerPublishing();
        $this->registerCommands();
    }

    /**
     * Setup the configuration for Inbox.
     *
     * @return void
     */
    protected function configure()
    {
        //Merge config file with laravel's default config file
        $this->mergeConfigFrom(__DIR__ . '../../config/inbox.php', 'inbox');
    }

    /**
     * Register Inbox routes.
     *
     * @return void
     */
    protected function registerRoutes()
    {
        Route::group([
            'domain' => config('inbox.domain', null),
            'prefix' => 'inbox',
            'namespace' => 'Xoshbin\Inbox\Http\Controllers',
            'middleware' => config('inbox.middleware', 'web'),
        ], function () {
            $this->loadRoutesFrom(__DIR__ . '../../routes/web.php');
        });
    }

    /**
     * Register the Inbox resources.
     *
     * @return void
     */
    protected function registerResources()
    {
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'inbox');
    }

    /**
     * Register the Inbox migrations.
     *
     * @return void
     */
    protected function registerMigrations()
    {
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
    }

    /**
     * Define the asset publishing configuration.
     *
     * @return void
     */
    public function defineAssetPublishing()
    {
        $this->publishes([
            INBOX_PATH . '/public' => public_path('vendor/inbox'),
        ], 'inbox-assets');
    }

    /**
     * Register Inbox routes.
     *
     * @return void
     */
    protected function globalVariables()
    {
        try {
            $emailCount = InboxEmail::where('read', '!=', 1)->orWhereNull('read')->count();
        } catch (\Throwable $th) {
            $emailCount = 0;
        }
        

        View::share('emailCount', $emailCount);
    }

    /**
     * Setup the resource publishing groups for Inbox.
     *
     * @return void
     */
    protected function offerPublishing()
    {
        if ($this->app->runningInConsole()) {

            $this->publishes([
                __DIR__ . '/../config/inbox.php' => config_path('inbox.php'),
            ], 'config');

            $this->publishes([
                __DIR__ . '/../resources/views' => resource_path('views/vendor/inbox'),
            ], 'views');
        }
    }

    /**
     * Register the Inbox Artisan commands.
     *
     * @return void
     */
    protected function registerCommands()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                InstallInbox::class,
                AssetsCommand::class,
            ]);
        }
    }
}
