@extends('layouts.top')

@section('content')
    <div class="container" id="">
        {{--            投稿表示の領域--}}

        <div class="row d-flex">
            @foreach($posts as $post)
                <div class="col-xl-4 col-lg-6">
                    <div class="card mb-3" style="max-width: 540px;min-height: 250px">
                        <div class="row">
                            <div class="col-12 mt-2">
                                <div style="min-height: 2.6rem"><h5>
                                        <em>{{ mb_substr($post->book->title,0,38) }}@if(mb_strlen($post->book->title)>38)
                                                ･･･@endif</em></h5></div>
                                <hr>
                            </div>
                            {{--投稿表示の左側--}}
                            <div class="col-xl-4 mt-2" style="height: 180px">
                                <a href="/post/{{$post->id}}">
                                    <img src="{{ $post->book->bookThumbnail }}" class="w-80 d-block ml-2"
                                         style="display: inline-block;max-height: 180px">
                                </a>
                            </div>
                            {{--投稿表示の右側--}}

                            <div class="col-xl-8 mt-2" style="min-height: 180px">
                                <span>投稿者コメント：</span>
                                <p>{{ $post->thumbnail_comment }}</p>
                            </div>
                            {{--投稿表示のユーザー情報--}}
                            <div class="col-12">
                                <hr>
                                <div class="d-flex">
                                    <div class="col-4"><small class="rounded"
                                                              style="background-color: #b91d19;color: white">お気に入り数：</small>
                                    </div>
                                    <div class="col-4"><small class="text-muted">閲覧数：{{ $post->viewed_count }}</small>
                                    </div>
                                    <div class="col-4"><small class="text-muted">{{ $post->created_at }}</small></div>
                                </div>
                                <hr>
                                <div class="d-flex pb-2 align-items-center">
                                    {{--       ユーザー画像             --}}
                                    <div class="ml-3 pr-3">
                                        <img src="{{ $post->user->profile->prof_image }}"
                                             class="w-100 rounded-circle" style="max-width: 50px">
                                    </div>
                                    {{--      ユーザー名              --}}
                                    <div class="font-weight-bold">
                                        <a href="/profile/{{ $post->user->id }}">
                                            <span class="text-dark">{{ $post->user->username }}</span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

    </div>
    <div class="row">
        <div class="col-12 d-flex justify-content-center">
            {{ $posts->links() }}
        </div>
    </div>
@endsection
