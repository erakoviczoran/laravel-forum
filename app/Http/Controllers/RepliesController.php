<?php

namespace App\Http\Controllers;

use App\Channel;
use App\Http\Forms\CreatePostForm;
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

    public function store(Channel $channel, Thread $thread, CreatePostForm $form)
    {
        return $form->persist($thread);
    }

    public function update(Reply $reply)
    {
        $this->authorize('update', $reply);

        $this->validate(request(), ['body' => 'required|spamfree']);

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
