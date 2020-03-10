<?php

namespace Xoshbin\Inbox\Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Xoshbin\Inbox\Tests\TestCase;
use Xoshbin\Inbox\Models\InboxEmail;

class InboxEmailTest extends TestCase
{
  use RefreshDatabase;

  /** @test */
  function an_email_has_a_subject()
  {
    $this->withoutExceptionHandling();

    $inbox = factory(InboxEmail::class)->create(['subject' => 'Fake Subject']);
    $this->assertEquals('Fake Subject', $inbox->subject);
  }
  
}