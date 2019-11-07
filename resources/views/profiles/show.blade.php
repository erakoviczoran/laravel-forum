@extends('layouts.app')

@section('content')
<div class="container">
    <div class="page-header">
        <h1>
            {{ $profileUser->name }}
            <small>Since {{ $profileUser->created_at->diffForHumans() }}</small>
        </h1>

        @forelse($threads as $thread)
        <div class="card">
            <div class="card-header d-flex">
                <div class="flex-grow-1">
                    <a href="{{ route('profiles.user', $thread->user) }}">{{ $thread->user->name }}</a> posted:

                    <a href="{{ route('threads.show', [$thread->channel, $thread]) }}">{{ $thread->title }}</a>
                </div>
                <div class="flex-shrink-0">
                    {{ $thread->created_at->diffForHumans() }}
                </div>
            </div>

            <div class="card-body">
                <div class="body">{{ $thread->body }}</div>
            </div>
        </div>
        @empty
        <p>There are no related threads.</p>
        @endforelse

        {{ $threads->links() }}
    </div>
</div>
@endsection
