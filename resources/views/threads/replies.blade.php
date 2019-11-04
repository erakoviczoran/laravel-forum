<div class="row mt-2">
    <div class="col-md-7 offset-1">
        <div class="card">
            <div class="card-header d-flex">
                <p class="flex-grow-1">{{ $reply->owner->name }} said {{ $reply->created_at->diffForHumans() }}</p>
                <form class="flex-shrink-0" method="POST"
                    action="{{ route('replies.favorites', ['reply'=>$reply->id]) }}">
                    @csrf
                    <input type="submit" class="btn btn-outline-secondary" {{ $reply->isFavorited() ? 'disabled' : '' }}
                        value="{{ $reply->favorites()->count() . ' ' . Str::plural('Favorite', $reply->favorites()->count()) }}" />
                </form>
            </div>
            <div class="card-body">
                <div class="body">{{ $reply->body }}</div>
            </div>
        </div>
    </div>
</div>
