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
            <div class="row">
                @foreach($followers as $follower)
                    <div class="col-12 mx-auto" style="max-width: 540px">
                        <div class="mx-auto d-flex align-items-center bg-white rounded border"
                             style="height: 80px">
                            <div>
                                <img class="ml-2 mr-3 rounded-circle" src="{{ $follower->profile->prof_image }}"
                                     width="50" height="50">
                            </div>
                            <div>
                                <span>{{ $follower->username }}</span>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
@endsection
