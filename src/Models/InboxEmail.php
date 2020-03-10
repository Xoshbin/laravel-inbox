<?php

namespace Xoshbin\Inbox\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use BeyondCode\Mailbox\InboundEmail as InboundEmail;

class InboxEmail extends Model
{
  use SoftDeletes;

  protected $dates = ['deleted_at'];

  protected $guarded = [];

  /**
   * The attributes that should be cast.
   *
   * @var array
   */
  protected $casts = [
    'to' => 'array',
  ];
}
