@extends('layouts.top')

@section('content')
    <div class="container">
        {{--            投稿表示の領域--}}
        <div class="mx-auto mb-2 text-muted">
            <h2>フォローしたユーザー 一覧</h2>
        </div>
        <div>
            <hr>
        </div>
        @if(empty($follows))
            <h2 class="text-muted">フォローしたユーザーはいません。</h2>
        @else
            <div class="row mx-auto">
                @foreach($follows as $follow)
                    <div class="col-12">
                        <div class="d-flex align-items-center bg-white rounded border"
                             style="height: 80px">
                            <div>
                                <img class="ml-2 mr-3 rounded-circle" src="{{ $follow->prof_image }}"
                                     width="50" height="50">
                            </div>
                            <div>
                                <a href="/profile/{{ $follow->user_id }}">
                                    <span class="text-dark">{{ $follow->user->username}}</span>
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
@endsection
