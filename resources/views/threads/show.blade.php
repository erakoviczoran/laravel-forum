@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex">
                    <div class="flex-grow-1">
                        <a href="{{ route('profiles.user', $thread->user->id) }}">{{ $thread->user->name }}</a> posted:
                        {{ $thread->title }}
                    </div>

                    @can('update', $thread)
                    <form method="POST" action="{{ route('threads.delete', [$thread->channel->id, $thread->id]) }}"
                        class="flex-shrink-0">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-outline-secondary">Delete</button>
                    </form>
                    @endcan
                </div>

                <div class="card-body">
                    <div class="body">{{ $thread->body }}</div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <p>This Thread was published {{ $thread->created_at->diffForHumans() }} by
                        <a href="#">{{ $thread->user->name }}</a>, and currently has
                        {{ $thread->replies_count . ' ' . Str::plural('comment', $thread->replies_count) . '.' }}
                    </p>
                </div>
            </div>
        </div>
    </div>

    @foreach ($replies as $reply)
    @include('threads.replies')
    @endforeach

    {{ $replies->links() }}


    @if (auth()->check())
    <div class="row mt-3">
        <div class="col-md-7 offset-1">
            <form action="{{ route('threads.replies', [$thread->channel->id, $thread->id]) }}" method="POST">
                @csrf
                <textarea class="form-control" name="body" id="" rows="5"></textarea>
                <input type="submit" class="btn btn-primary mt-2" value="Post">
            </form>
        </div>
    </div>
    @else
    <div class="row justify-content-center mt-2">
        <p class="col-md-8">Please <a href="{{ route('home') }}">sign in</a> to participate in this discussion.</p>
    </div>
    @endif
</div>
@endsection
