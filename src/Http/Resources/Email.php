<?php

namespace Xoshbin\Inbox\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Http\Resources\Json\JsonResource;
use Xoshbin\Inbox\Models\InboxEmails;
use Illuminate\Support\Carbon;

class Email extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'date' => Carbon::parse($this->created_at)->format('m/d/Y'),
            'html' => $this->body,
            'subject' => $this->subject,
            'from' => $this->from,
            'to' => $this->to,
            'starred' => $this->starred == 1 ? true : false,
            'read' => $this->read == 1 ? true : false,
        ];
    }
}
