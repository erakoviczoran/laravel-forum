<?php

namespace App\Http\Controllers;

use App\Channel;
use App\Reply;
use App\Thread;

class RepliesController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth', ['except' => 'index']);
    }

    public function index(Channel $channel, Thread $thread)
    {
        return $thread->replies()->paginate(2);
    }

    public function store(Channel $channel, Thread $thread)
    {
        $this->validate(request(), [
            'body' => 'required',
        ]);

        $reply = $thread->addReply([
            'user_id' => auth()->id(),
            'body' => request('body'),
        ]);

        if (request()->expectsJson()) {
            return $reply->load('user');
        }

        return back()->with('flash', 'Your reply has been left.');
    }

    public function update(Reply $reply)
    {
        $this->authorize('update', $reply);

        $reply->update(request(['body']));
    }

    public function destroy(Reply $reply)
    {
        $this->authorize('update', $reply);

        $reply->delete();

        if (request()->ajax()) {
            return response(['status' => 'Reply deleted.']);
        }

        return back();
    }
}
