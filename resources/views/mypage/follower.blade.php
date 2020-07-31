@extends('layouts.top')

@section('content')
    <div class="container">
        {{--            投稿表示の領域--}}
        <div class="mx-auto mb-2 text-muted">
            <h2>フォロワー 一覧</h2>
        </div>
        <div>
            <hr>
        </div>
        @if(empty($followers))
            <h2 class="text-muted">フォローワーはいません。</h2>
        @else
            @foreach($followers as $follower)
                <div class="row col-12 justify-content-center">
                    <div class="d-flex align-items-center bg-white rounded border"
                         style="height: 80px; min-width: 300px">
                        <div>
                            <img class="ml-2 mr-3 rounded-circle" src="{{config('app.profile_image_url')}}{{ $follower->profile->prof_image }}"
                                 width="50" height="50">
                        </div>
                        <div>
                            <a href="/profile/{{ $follower->id }}">
                                <span class="text-dark">{{ $follower->username }}</span>
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
    </div>
    @endif
    </div>
@endsection
