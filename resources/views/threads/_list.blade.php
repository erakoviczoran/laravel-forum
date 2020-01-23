@forelse ($threads as $thread)
<div class="card mt-2">
    <div class="card-header {{ auth()->check() && $thread->hasUpdatesForLoggedUser() ? 'unread' : ''}}">
        <div class="d-flex">

            <h4 class="flex-grow-1">
                <a href="{{ route('threads.show', [$thread->channel->id, $thread->id]) }}">
                    {{ $thread->title }}
                </a>
            </h4>
            <a class="flex-shrink-0"
                href="{{ route('threads.show', [$thread->channel->id, $thread->id]) }}">{{ $thread->replies_count . ' ' . Str::plural('reply', $thread->replies_count) }}</a>
        </div>
        <div class="d-flex">
            <p class="mb-0">
                Posted By:
                <a href="{{ route('profiles.user', $thread->user->id) }}">{{ $thread->user->name }}</a>
            </p>
        </div>
    </div>
    <div class="card-body">
        <div class="body">{{ $thread->body }}</div>
    </div>
    <div class="card-footer">
        {{ $thread->visits() . ' ' . Str::plural('visit', $thread->visits()) }}
    </div>
</div>
@empty
<p>There are no relevant results at this time.</p>
@endforelse
