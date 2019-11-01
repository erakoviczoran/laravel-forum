<div class="row justify-content-center mt-2">
    <div class="col-md-7 offset-1">
        <div class="card">
            <div class="card-header">
                {{ $reply->owner->name }} said {{ $reply->created_at->diffForHumans() }}
            </div>
            <div class="card-body">
                <div class="body">{{ $reply->body }}</div>
            </div>
        </div>
    </div>
</div>
