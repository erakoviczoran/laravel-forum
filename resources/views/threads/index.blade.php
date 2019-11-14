@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8">
            @forelse ($threads as $thread)
            <div class="card mt-2">
                <div class="card-header {{ auth()->check() && $thread->hasUpdatesForLoggedUser() ? 'unread' : ''}} d-flex">
                    <h4 class="flex-grow-1">
                        <a href="{{ route('threads.show', [$thread->channel->id, $thread->id]) }}">
                            {{ $thread->title }}
                        </a>
                    </h4>
                    <a class="flex-shrink-0"
                        href="{{ route('threads.show', [$thread->channel->id, $thread->id]) }}">{{ $thread->replies_count . ' ' . Str::plural('reply', $thread->replies_count) }}</a>
                </div>
                <div class="card-body">
                    <div class="body">{{ $thread->body }}</div>
                </div>
            </div>
            @empty
            <p>There are no relevant results at this time.</p>
            @endforelse
        </div>
    </div>
</div>
@endsection
