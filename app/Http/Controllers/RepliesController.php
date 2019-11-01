<?php

namespace App\Http\Controllers;

use App\Channel;
use App\Thread;

class RepliesController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function store(Channel $channel, Thread $thread)
    {
        $this->validate(request(), [
            'body' => 'required',
            'user_id' => 'required|exists:users,id',
        ]);

        $thread->addReply([
            'user_id' => auth()->id(),
            'body' => request('body'),
        ]);

        return back();
    }
}
