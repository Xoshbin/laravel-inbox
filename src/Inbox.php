<?php

namespace Xoshbin\Inbox;

use BeyondCode\Mailbox\InboundEmail;
use BeyondCode\Mailbox\Facades\Mailbox;
use Xoshbin\Inbox\Models\InboxEmail;

class Inbox
{
    public function __invoke(InboundEmail $email)
    {
        $InboxEmail = new InboxEmail();
        $InboxEmail->to = $email->to();
        $InboxEmail->from = $email->from();
        $InboxEmail->subject = $email->subject();
        $InboxEmail->body = $email->html();
        $InboxEmail->save();
    }

    /**
     * Get the default JavaScript variables for Inbox.
     *
     * @return array
     */
    public static function scriptVariables()
    {
        return [
            'path' => config('inbox.inbox_path'),
        ];
    }
}