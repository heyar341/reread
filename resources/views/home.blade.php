@extends('layouts.top')

@section('content')
    <div class="container" id="">
        {{--            投稿表示の領域--}}

        <div class="row d-flex">
            @foreach($posts as $post)
                <div class="col-xl-4 col-lg-6 rounded mb-3">
                    <div class="card mb-3" style="max-width: 540px;min-height: 250px">
                        <div class="row">
                            <div class="col-12 mt-2">
                                <div class="mx-2" style="min-height: 2.6rem"><h5>
                                        <em>{{ mb_substr($post->book->title,0,36) }}@if(mb_strlen($post->book->title)>36)
                                                ･･･@endif</em></h5>
                                </div>
                                <hr>
                            </div>
                            {{--投稿表示の左側--}}
                            <div class="col-12 mt-2" style="height: 180px">
                                <a href="/post/{{$post->id}}">
                                    <img src="{{ $post->book->bookThumbnail }}" class="mx-auto w-80 d-block"
                                         style="display: inline-block;max-height: 180px">
                                </a>
                            </div>
                            {{--投稿表示の右側--}}
                            <div class="col-12 mt-2">
                                <hr>
                                <div class="mx-2" style="min-height: 140px">
                                    <span>投稿者コメント：</span>
                                    <p>{{ $post->thumbnail_comment }}</p>
                                </div>
                            </div>
                            {{--投稿表示のユーザー情報--}}
                            <div class="col-12">
                                <div class="d-flex border-top border-bottom align-items-center">
                                    <div class="col-5"><small class="rounded px-2" {{--isliked->count()だとクエリーが発行されるので、Eloquentのオブジェクト数を数えるようにした--}}
                                                              style="background-color: #b91d19;color: white">お気に入り数：{{ count($post->isLiked) }}</small>
                                    </div>
                                    <div class="col-3"><small class="text-muted">閲覧数：{{ $post->viewed_count }}</small>
                                    </div>
                                    <div class="col-4"><small
                                            class="text-muted">{{ mb_substr($post->created_at,6,10) }}</small></div>
                                </div>

                                <div class="col-12">
                                    <div class="d-flex pb-2 align-items-center">
                                        {{--ユーザー画像--}}
                                        <div class="ml-2 mt-2 pr-3">
                                            <img src="{{ $post->user->profile->prof_image }}"
                                                 class="w-100 rounded-circle" style="max-width: 40px">
                                        </div>
                                        {{--ユーザー名--}}
                                        <div class="font-weight-bold">
                                            <a href="/profile/{{ $post->user->id }}">
                                                <span class="text-dark">{{ $post->user->username }}</span>
                                            </a>
                                        </div>
                                        <div>
                                            <small
                                                class="ml-3 text-muted">フォロワー：{{ count($post->user->profile->followers) }}
                                                人</small>
                                        </div>
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
