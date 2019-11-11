<reply :reply="{{ $reply }}" inline-template v-cloak>
    <div class="row mt-2">
        <div class="col-md-7 offset-1">
            <div class="card">
                <div id="reply-{{ $reply->id }}" class="card-header d-flex">
                    <p class="flex-grow-1">
                        <a href="{{ route('profiles.user', $reply->user->id) }}">{{ $reply->user->name }}</a>
                        said {{ $reply->created_at->diffForHumans() }}
                    </p>
                    @can('update', $thread)
                    <form class="flex-shrink-0" method="POST"
                        action="{{ route('replies.favorites', ['reply'=>$reply->id]) }}">
                        @csrf
                        <input type="submit" class="btn btn-outline-secondary"
                            {{ $reply->isFavorited() ? 'disabled' : '' }}
                            value="{{ $reply->favorites_count . ' ' . Str::plural('Favorite', $reply->favorites_count) }}" />
                    </form>
                    @endcan
                </div>
                <div class="card-body">
                    <div class="body">
                        <div v-if="editing">
                            <textarea class="form-control mb-2" name="body" rows="10" v-model="body"></textarea>
                            <button class="btn btn-primary" @click="update">Update</button>
                            <button class="btn btn-link" @click="editing = false">Cancel</button>
                        </div>
                        <div v-else v-text="body"></div>
                    </div>
                </div>
                @can('update', $reply)
                <div class="card-footer">
                    <div class="d-flex">
                        <button @click="editing = true" class="btn btn-outline-secondary btn-sm mr-2">Edit</button>
                        <form action="{{ route('replies.delete', $reply) }}" method="POST">
                            @csrf
                            @method("DELETE")
                            <button class="btn btn-danger btn-sm" type="submit">Delete</button>
                        </form>
                    </div>
                </div>
                @endcan
            </div>
        </div>
    </div>
</reply>
