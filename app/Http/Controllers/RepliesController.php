<?php

namespace App\Http\Controllers;

use App\Channel;
use App\Inspections\Spam;
use App\Reply;
use App\Thread;
use Exception;

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
        try {
            $this->validateReply();

            $reply = $thread->addReply([
                'user_id' => auth()->id(),
                'body' => request('body'),
            ]);

        } catch (Exception $e) {
            return response('Sorry, your reply could not be saved at this time.', 422);
        }

        return $reply->load('user');
    }

    public function update(Reply $reply)
    {
        $this->authorize('update', $reply);

        try {
            $this->validateReply();

            $reply->update(request(['body']));
        } catch (Exception $e) {
            return response('Sorry, your reply could not be saved at this time.', 422);
        }
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

    private function validateReply()
    {
        $this->validate(request(), ['body' => 'required']);
        resolve(Spam::class)->detect(request('body'));
    }
}
