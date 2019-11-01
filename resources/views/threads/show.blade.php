@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <a href="#">{{ $thread->user->name }}</a> posted:
                    {{ $thread->title }}
                </div>

                <div class="card-body">
                    <div class="body">{{ $thread->body }}</div>
                </div>
            </div>
        </div>
    </div>

    @foreach ($thread->replies as $reply)
    @include('threads.reply')
    @endforeach


    @if (auth()->check())
    <div class="row justify-content-center mt-3">
        <div class="col-md-7 offset-1">
            <form action="{{ route('threads.replies', [$thread->channel->id, $thread->id]) }}" method="POST">
                @csrf
                <div>
                    <textarea class="w-100" name="body" id="" rows="5"></textarea>
                    <input type="submit" value="Post">
                </div>
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
