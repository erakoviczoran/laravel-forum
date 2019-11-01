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
                                    Title:
                                    <input name="title" type="text" class="form-control" placeholder="Title..." />
                                </label>
                            </div>
                            <div class="col-12">
                                <label class="w-100">
                                    Body:
                                    <textarea name="body" class="form-control" rows="8" placeholder="Body..."></textarea>
                                </label>
                            </div>
                        </div>

                        <input type="submit" class="btn btn-primary" value="Publish">
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
