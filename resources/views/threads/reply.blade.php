<reply :attributes="{{ $reply }}" inline-template v-cloak>
    <div id="reply-{{ $reply->id }}" class="py-2">
        <div class="card">
            <div class="card-header bg-white">
                <div class="level">
                    <div class="card-title flex">
                        <a href="/profiles/{{ $reply->owner->name }}">
                            {{ $reply->owner->name }}
                        </a>
                        said {{ $reply->created_at->diffForHumans() }}
                    </div>

                    @if (Auth::check())
                        <div>
                            <favorite :reply="{{ $reply }}"></favorite>
                        </div>
                    @endif
                </div>
            </div>
            <div class="card-body">
                <div v-if="editing">
                    <div class="form-group">
                        <textarea class="form-control" v-model="body"></textarea>
                    </div>
                    <button class="btn btn-sm btn-primary" @click="update">Update</button>
                    <button class="btn btn-sm btn-link" @click="editing = false">Cancel</button>
                </div>

                <div v-else v-text="body"></div>
            </div>

            @can ('update', $reply)
                <div class="card-footer bg-white level">
                    <button class="btn btn-success btn-sm mr-2" @click="editing = true">Edit</button>
                    <button class="btn btn-sm btn-danger mr-2" @click="destroy">Delete</button>
                </div>
            @endcan
        </div>
    </div>
</reply>
