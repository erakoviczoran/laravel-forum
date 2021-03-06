@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Create a New Thread</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('threads') }}">
                        @csrf
                        <div class="row">
                            <div class="col-12">
                                <label class="w-100">
                                    Choose a Channel:
                                    <div>
                                        <select name="channel_id" class="form-control w-100" required>
                                            <option value="">Choose one:</option>
                                            @foreach($channels as $channel)
                                            <option value="{{ $channel->id }}"
                                                {{ old('channel_id') == $channel->id ? 'selected' : '' }}>
                                                {{ $channel->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <label class="w-100">
                                    Title:
                                    <input name="title" type="text" class="form-control" placeholder="Title..."
                                        value="{{ old('title') }}" required />
                                </label>
                            </div>
                            <div class="col-12">
                                <label class="w-100">
                                    Body:
                                    <textarea name="body" class="form-control" rows="8"
                                        placeholder="Body..." required>{{ old('body') }}</textarea>
                                </label>
                            </div>
                        </div>

                        <input type="submit" class="btn btn-primary" value="Publish">

                        @if (count($errors))
                        <ul class="alert alert-danger mt-2">
                            @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        @endif
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
