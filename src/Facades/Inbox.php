<?php

namespace Xoshbin\Inbox\Facades;

use Illuminate\Support\Facades\Facade;

class Inbox extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'inbox';
    }
}