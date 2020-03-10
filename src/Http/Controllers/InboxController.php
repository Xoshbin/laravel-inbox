<?php

namespace Xoshbin\Inbox\Http\Controllers;

use Illuminate\Http\Request;
use Xoshbin\Inbox\Models\InboxEmail;
use Illuminate\Support\Facades\Mail;
use Xoshbin\Inbox\Mail\InboxMail;
use Xoshbin\Inbox\Http\Resources\Email as EmailResource;

class InboxController extends Controller
{

    /**
     * Send dashboard emails in json
     *
     * @return Illuminate\Http\Resources\Json\JsonResource
     */
    public function emails()
    {
        $emails =  InboxEmail::orderBy('created_at', 'desc')->paginate(10);
        return EmailResource::collection($emails);
    }

    /**
     * Send an email in json
     *
     * @param number                   $id
     * 
     * @return Illuminate\Http\Resources\Json\JsonResource
     */
    public function email($id)
    {
        $email = InboxEmail::where('id', $id)->withTrashed()->get();

        InboxEmail::where('id', $id)->update(['read' => 1]);

        return EmailResource::collection($email);
    }

    /**
     * Send a new email
     *
     * @param \Illuminate\Http\Request $request
     * 
     * @return message
     */
    public function send(Request $request)
    {
        $details = [
            'subject' => $request->input('subject'),
            'body' => $request->input('html')
        ];

        $mailbody = new InboxMail($details);

        Mail::to($request->input('to'))->send($mailbody);

        $InboxEmail = new InboxEmail;
        $InboxEmail->to = $request->input('to');
        $InboxEmail->from = 'info@amrotech.com';
        $InboxEmail->subject = $request->input('subject');
        $InboxEmail->body = $mailbody->render();
        $InboxEmail->sent = 1;
        $InboxEmail->save();

        return ['message' => $InboxEmail];
    }

    /**
     * Send a reply
     *
     * @param \Illuminate\Http\Request $request
     * 
     * @return message
     */
    public function sendreply(Request $request)
    {
        $email = InboxEmail::where('id', $request->input('id'))->first();

        $details = [
            'subject' => $email->subject(),
            'body' => $request->input('html')
        ];

        Mail::to($email->from())->send(new InboxMail($details));

        return ['message' => "Reply sent"];
    }

    /**
     * Send the forward
     *
     * @param \Illuminate\Http\Request $request
     * 
     * @return message
     */
    public function sendforward(Request $request)
    {
        $email = InboxEmail::where('id', $request->input('id'))->first();

        $details = [
            'subject' => $email->subject(),
            'body' => $request->input('html')
        ];

        Mail::to($request->input('to'))->send(new InboxMail($details));

        return ['message' => "Email forward sent"];
    }

    /**
     * Make an email unread
     *
     * @param number                   $id
     * 
     * @return message
     */
    public function unread($id)
    {
        try {
            $email = InboxEmail::where('id', $id)->withTrashed()->first();
            $email->restore();

            if ($email->read == 1) {
                $email->read = 0;
                $email->save();
                return ['message' => "Email unread"];
            } else {
                $email->read = 1;
                $email->save();
                return ['message' => "Email read"];
            }

            
        } catch (\Throwable $th) {
            return ['message' => $th];
        }
    }

    /**
     * Toggle star an email
     *
     * @param number                   $id
     * 
     * @return message
     */
    public function star($id)
    {
        try {
            $email = InboxEmail::where('id', $id)->first();

            if ($email->starred == 1) {
                $email->starred = 0;
                $email->save();
                return ['message' => "Email unstarred"];
            } else {
                $email->starred = 1;
                $email->save();
                return ['message' => "Email starred"];
            }

            
        } catch (\Throwable $th) {
            return ['message' => $th];
        }
    }

    /**
     * Toggle important an email
     *
     * @param number                   $id
     * 
     * @return message
     */
    public function bookmark($id)
    {
        try {
            $email = InboxEmail::where('id', $id)->first();

            if ($email->bookmarked == 1) {
                $email->bookmarked = 0;
                $email->save();
                return ['message' => "Email removed from bookmark list"];
            } else {
                $email->bookmarked = 1;
                $email->save();
                return ['message' => "Email bookmarked"];
            }

            
        } catch (\Throwable $th) {
            return ['message' => $th];
        }
    }

    /**
     * Show starred emails.
     *
     * @return Illuminate\Http\Resources\Json\JsonResource
     */
    public function starred()
    {
        $emails = InboxEmail::where('starred', 1)->orderBy('created_at', 'desc')->paginate(15);

        return EmailResource::collection($emails);
    }

    /**
     * Show sent emails.
     *
     * @return Illuminate\Http\Resources\Json\JsonResource
     */
    public function sent()
    {
        $emails = InboxEmail::where('sent', 1)->orderBy('created_at', 'desc')->paginate(15);

        return EmailResource::collection($emails);
    }

    /**
     * Show important emails.
     *
     * @return Illuminate\Http\Resources\Json\JsonResource
     */
    public function important()
    {
        $emails = InboxEmail::where('bookmarked', 1)->orderBy('created_at', 'desc')->paginate(15);

        return EmailResource::collection($emails);
    }

    /**
     * Delete an email
     *
     * @param number                   $id
     * 
     * @return message
     */
    public function delete($id)
    {
        $email = InboxEmail::where('id', $id)->first();
        $email->delete();

        return ['message' => "Email deleted"];
    }

    /**
     * Delete multiple emails
     *
     * @param \Illuminate\Http\Request $request
     * 
     * @return message
     */
    public function bulkDelete(Request $request)
    {
        $ids = $request->ids;
        InboxEmail::whereIn('id', $ids)->delete();
        return response()->json(['success' => "Emails Deleted successfully."]);

    }

    /**
     * Show deleted emails.
     *
     * @return Illuminate\Http\Resources\Json\JsonResource
     */
    public function trash()
    {
        $emails = InboxEmail::onlyTrashed()->orderBy('created_at', 'desc')->paginate(15);

        return EmailResource::collection($emails);
    }

    /**
     * Unread multiple emails
     *
     * @param \Illuminate\Http\Request $request
     * 
     * @return message
     */
    public function bulkUnread(Request $request)
    {
        $ids = $request->ids;
        InboxEmail::whereIn('id', $ids)->withTrashed()->update(['read' => 0, 'deleted_at' => null]);
        return response()->json(['success' => "Emails updated successfully."]);
    }

    /**
     * Star multiple emails
     *
     * @param \Illuminate\Http\Request $request
     * 
     * @return message
     */
    public function bulkStar(Request $request)
    {
        $ids = $request->ids;
        InboxEmail::whereIn('id', $ids)->update(['starred' => 1]);
        return response()->json(['success' => "Emails updated successfully."]);
    }

    /**
     * Make multiple emails important
     *
     * @param \Illuminate\Http\Request $request
     * 
     * @return message
     */
    public function bulkbookmark(Request $request)
    {
        $ids = $request->ids;
        InboxEmail::whereIn('id', $ids)->update(['bookmarked' => 1]);
        return response()->json(['success' => "Emails updated successfully."]);
    }
}
