<?php

namespace Xoshbin\Inbox\Tests;

use Xoshbin\Inbox\InboxServiceProvider;
use Illuminate\Database\Eloquent\Factory as EloquentFactory;

class TestCase extends \Orchestra\Testbench\TestCase
{
  public function setUp(): void
  {
    parent::setUp();
    // additional setup

    $this->app->make(EloquentFactory::class)->load(__DIR__ . '/../database/factories');
  }

  protected function getPackageProviders($app)
  {
    return [
      InboxServiceProvider::class,
    ];
  }

  protected function getPackageAliases($app)
{
    return [
        'Inbox' => 'Xoshbin\Inbox\Facades\Inbox'
    ];
}

  public function getEnvironmentSetUp($app)
  {
    // import the CreatePostsTable class from the migration
    include_once __DIR__ . '/../database/migrations/create_inbox_emails_table.php.stub';

    // run the up() method of that migration class
    (new \CreateInboxEmailsTable)->up();
  }
}