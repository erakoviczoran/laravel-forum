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
                            <h4><a href="{{ route('threads.show', [$thread->channel->id, $thread->id]) }}">{{ $thread->title }}</a></h4>
                            <div class="body">{{ $thread->body }}</div>
                        </article>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
