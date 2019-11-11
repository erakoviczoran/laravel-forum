@component('profiles.activities.activity')
    @slot('heading')
        <a
            href="{{ route('threads.show', [$activity->subject->favorited->thread->channel_id, $activity->subject->favorited->thread->id]) }}#reply-{{ $activity->subject->favorited_id }}">
            {{ $profileUser->name}}
            favorited a reply.
        </a>
    @endslot

    @slot('body')
        {{ $activity->subject->favorited->body }}
    @endslot
@endcomponent
