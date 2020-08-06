@extends('layouts.standard')

@section('content')
{{--    <div class="container">--}}
{{--    </div>--}}
    <div class="container-home container" id="">
        <div class="row mx-auto" style="max-width: 525px">
            <div class="col-12 d-flex p-3 mt-3 text-white rounded shadow-sm" style="background-color: rgba(0,182,16,0.27)">

                <div class="row align-items-center" style="width: 100%">
                    <div class="col-sm-3 col-12">
                        <img class="mr-3 rounded-circle"
                             src="{{config('app.profile_image_url')}}{{ $user->profile->prof_image }}"
                             width="65" height="65">
                    </div>
                    <div class="col-sm-5 col-6">
                        <div class="lh-100">
                            <h3 class="ml-2 mb-0 text-black lh-100">{{ $user->username }}</h3>
                        </div>
                    </div>
                    @auth
                        @if(auth()->user()->id != $user->id)
                            <div class="col-sm-4 col-6">
                                <follow-button user-id="{{ $user->id }}" follows="{{ $follows }}"></follow-button>
                            </div>
                        @endif
                    @endauth

                    <div>@if($user->profile->prof_url != 'Not Edited')<span class="px-2">サイトURL:</span><a href="#"
                                                                                                          style="color: #ffffff">{{ $user->profile->prof_url }}</a>@endif
                    </div>
            </div>
            </div>

            <div class="col-12 border bg-white" style="min-height: 100px">
                <h6 class="ml-1">自己紹介：</h6>
                <p class="ml-2">@if($user->profile->intro_self != 'Not Edited'){{ $user->profile->intro_self }}@endif</p>
            </div>
        </div>
        {{--            投稿表示の領域--}}
        <div>
            <hr>
        </div>
        <div class="row d-flex">
            @foreach($posts as $post)
                <div class="col-xl-4 col-lg-6 rounded mb-3">
                    <div class="card mb-3 mx-auto" style="max-width: 540px;min-height: 250px">
                        <div class="row">
                            <div class="col-12 mt-2">
                                <div class="mx-2" style="min-height: 2.6rem"><h5>
                                        <em>{{ mb_substr($post->book->title,0,36) }}@if(mb_strlen($post->book->title)>36)
                                                ･･･@endif</em></h5>
                                </div>
                                <hr>
                            </div>
                            {{--投稿表示の画像部分--}}
                            <div class="col-12 mt-2" style="height: 180px">
                                <a href="/post/{{$post->id}}">
                                    <img src="{{ $post->book->bookThumbnail }}" class="mx-auto w-80 d-block"
                                         style="display: inline-block;max-height: 180px">
                                </a>
                            </div>
                            {{--投稿表示のコメント部分--}}
                            <div class="col-12 mt-2">
                                <hr>
                                <div class="mx-2" style="min-height: 140px">
                                    <span>投稿者コメント：</span>
                                    <p>{{ $post->thumbnail_comment }}</p>
                                </div>
                            </div>
                            {{--投稿の情報--}}
                            <div class="col-12">
                                <div class="d-flex border-top align-items-center">
                                    <div class="col-4 d-flex">
                                        <div class="mx-auto"><small class="rounded px-1"
                                                                    style="background-color: #b91d19;color: white">お気に入り</small>
                                        </div>
                                    </div>
                                    <div class="col-4 d-flex">
                                        <div class="mx-auto"><small class="text-muted">閲覧数</small></div>
                                    </div>
                                    <div class="col-4 d-flex">
                                        <div class="mx-auto"><small
                                                class="text-muted">投稿日時</small></div>
                                    </div>
                                </div>

                                <div class="d-flex border-bottom align-items-center">
                                    <div class="col-4 d-flex">
                                        <div class="mx-auto"><small class="text-muted"
                                                {{--isliked->count()だとクエリーが発行されるので、Eloquentのオブジェクト数を数えるようにした--}}
                                            >{{ count($post->is_liked) }}</small></div>
                                    </div>
                                    <div class="col-4 d-flex">
                                        <div class="mx-auto"><small class="text-muted">{{ $post->viewed_count }}</small>
                                        </div>
                                    </div>
                                    <div class="col-4 d-flex">
                                        <div class="mx-auto"><small
                                                class="text-muted">{{ mb_substr($post->created_at,0,10) }}</small></div>
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
