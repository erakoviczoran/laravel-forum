@extends('layouts.app')

@section('content')
<div class="container">
    <div class="page-header">
        <h1>
            {{ $profileUser->name }}
            <small>Since {{ $profileUser->created_at->diffForHumans() }}</small>
        </h1>

        @forelse($activities as $date => $activity)
            <h3 class="mt-4 mb-3">{{ $date }}</h3>

            @foreach($activity as $record)
                @include("profiles.activities.{$record->type}", ['activity' => $record])
            @endforeach
        @empty
            <p>There are no related threads.</p>
        @endforelse
    </div>
</div>
@endsection
