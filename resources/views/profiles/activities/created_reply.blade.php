@component('profiles.activities.activity')
    @slot('heading')
        {{ $profileUser->name}} replied to
        <a href="{{ route('threads.show', [$activity->subject->thread->channel_id, $activity->subject->thread_id]) }}">
            {{ $activity->subject->thread->title }}
        </a>
    @endslot

    @slot('body')
        {{ $activity->subject->thread->body }}
    @endslot
@endcomponent
