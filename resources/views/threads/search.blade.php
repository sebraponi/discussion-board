@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <my-search></my-search>
            </div>

            <div class="col-md-4 py-2">

                @if (count($trending))
                    <div class="card">
                        <div class="card-header bg-white">
                            Trending Threads
                        </div>

                        <div class="card-body">
                            <ul class="list-group">
                                @foreach ($trending as $thread)
                                    <li class="list-group-item">
                                        <a href="{{ url($thread->path) }}">
                                            {{ $thread->title }}
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                @endif
            </div>
        </div>



    </div>


@endsection
