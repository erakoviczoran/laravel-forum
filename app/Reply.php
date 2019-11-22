<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Reply extends Model
{
    use Favoritable, RecordsActivity;

    protected $guarded = [];

    protected $with = ['user', 'favorites'];

    protected $appends = ['favoritesCount', 'isFavorited'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function thread()
    {
        return $this->belongsTo(Thread::class);
    }

    public function wasJustPublished()
    {
        return $this->created_at->gt(Carbon::now()->subMinute());
    }

    public function mentionedUsers()
    {
        return $this->getMentionedUsers($this->body);
    }

    public function getMentionedUsers($body)
    {
        preg_match_all('/@([\w\-]+)/', $body, $matches);

        return $matches[1];
    }

    public function setBodyAttribute($body)
    {
        $users = User::whereIn('name', $this->getMentionedUsers($body))->get();

        $body = preg_replace('/@([\w\-]+)/', '<a href="#$1">$0</a>', $body);

        foreach ($users as $user) {
            $body = str_replace(('#' . $user->name), ('/profiles/' . $user->id), $body);
        }

        $this->attributes['body'] = $body;
    }
}
