@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8">
            @include('threads._list')

        </div>
    </div>
    <div class="row mt-2">
        <div class="col-md-8">
            {{ $threads->render() }}
        </div>
    </div>
</div>
@endsection
