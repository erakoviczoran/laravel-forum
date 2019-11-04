@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Forum Threads</div>

                <div class="card-body">
                    @foreach ($threads as $thread)
                    <article>
                        <div class="d-flex">
                            <h4 class="flex-grow-1">
                                <a
                                    href="{{ route('threads.show', [$thread->channel->id, $thread->id]) }}">{{ $thread->title }}</a>
                            </h4>
                            <a class="flex-shrink-0"
                                href="{{ route('threads.show', [$thread->channel->id, $thread->id]) }}">{{ $thread->replies_count . ' ' . Str::plural('reply', $thread->replies_count) }}</a>
                        </div>
                        <div class="body">{{ $thread->body }}</div>
                    </article>
                    <hr />
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
