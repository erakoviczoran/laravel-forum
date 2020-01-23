@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                @include('threads._list')
            </div>
            @if(count($trending))
                <div class="col-md-4">
                    <div class="card mt-2">
                        <div class="card-header">
                            Trending threads
                        </div>
                        <div class="card-body p-0">
                            <ul class="list-group-flush pl-0 mb-0">
                                @foreach($trending as $thread)
                                    <li class="list-group-item">
                                        <a href="{{ $thread->path }}">{{ $thread->title }}</a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            @endif
        </div>
        <div class="row mt-2">
            <div class="col-md-8">
                {{ $threads->render() }}
            </div>
        </div>
    </div>
@endsection
