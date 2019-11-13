@extends('layouts.app')

@section('content')
<thread-view :initial-replies-count="{{ $thread->replies_count }}" inline-template>
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header d-flex">
                        <div class="flex-grow-1">
                            <a href="{{ route('profiles.user', $thread->user->id) }}">{{ $thread->user->name }}</a>
                            posted:
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
                            <span v-text="repliesCount"></span>
                            {{ Str::plural('comment', $thread->replies_count) . '.' }}
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <replies @added="repliesCount++" @removed="repliesCount--"></replies>
    </div>
</thread-view>
@endsection
