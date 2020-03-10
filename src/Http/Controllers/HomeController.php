<?php

namespace Xoshbin\Inbox\Http\Controllers;

use Xoshbin\Inbox\Inbox;

class HomeController extends Controller
{
    /**
     * Single page application catch-all route.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('inbox::layout', [
            'inboxScriptVariables' => Inbox::scriptVariables(),
        ]);
    }
}