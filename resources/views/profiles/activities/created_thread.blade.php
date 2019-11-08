@component('profiles.activities.activity')
    @slot('heading')
        {{ $profileUser->name}} published
        <a href="{{ route('threads.show', [$activity->subject->channel_id, $activity->subject->id]) }}">
            {{ $activity->subject->title }}
        </a>
    @endslot

    @slot('body')
        {{ $activity->subject->body }}
    @endslot
@endcomponent
