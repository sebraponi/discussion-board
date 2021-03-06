@forelse($threads as $thread)
    <div class="py-2">
        <div class="card">
            <div class="card-header bg-white">
                <div class="level">
                    <div class="flex">
                        <h4>
                                <a href="{{ $thread->path() }}">
                                    @if (auth()->check() && $thread->hasUpdatesFor(auth()->user()))
                                        <strong>
                                            {{ $thread->title }}
                                        </strong>
                                    @else
                                        {{ $thread->title }}
                                    @endif
                                </a>
                        </h4>

                        <h6>
                            Posted By:
                            <a href="{{ route('profile', $thread->creator) }}">{{ $thread->creator->name }}</a>
                        </h6>
                    </div>

                    <!-- <div class="card-text"> -->
                    <a href="{{ $thread->path() }}">
                        {{ $thread->replies_count }} {{ str_plural('reply', $thread->replies_count) }}
                    </a>
                    <!-- </div> -->
                </div>
            </div>

            <div class="card-body">
                <p class="card-text">{!! $thread->body !!}</p>
            </div>

            <div class="card-footer bg-white">
                {{ $thread->visits }} Visits
            </div>
        </div>
    </div>
@empty
    <p>There are no relevant results at this time.</p>
@endforelse
