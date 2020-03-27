@extends('layouts.post')

@section('content')
    <div class="container">
        <div class="row">
            {{------本の情報--}}
            <div class="col-lg-8 mx-auto">
                <div class="card mb-3" style="max-width: 800px; min-height:150px">
                    <div class="row">
                        {{--書籍情報の左側--}}
                        <div class="col-sm-3 mt-2">
                            <img src="{{ $book->bookThumbnail }}"
                                 class="ml-2 mb-1 d-block"
                                 style="display: inline-block;max-height: 144px">
                        </div>
                        {{--書籍情報の右側--}}
                        <div class="col-sm-9 mt-3">
                            <h4>@if(mb_strlen($book->title) > 45){{ mb_substr($book->title,0,45) }}
                                ･･･@else {{ $book->title }}@endif</h4>
                            <a href="{{$book->infoLink}}">この書籍の詳細情報</a><br>
                            <small>著者：{{ $book->authors }}、</small>
                            <small>出版年：{{ $book->publishedDate }}、</small>
                            <small>ページ数：{{ $book->pageCount }}</small>
                            <p class="mt-2 mr-2">{{ mb_substr($book->description,0,100) }}･･･</p>
                        </div>
                    </div>
                </div>
            </div>

            {{------投稿本文エリア--}}
            <div class="col-12">
                <hr style="max-width: 800px">
                <div class="mx-auto" style="max-width: 640px;">
                    <div class="main-content" style="min-height: 500px">{!! $post->main_content !!}</div>
                    <div class="viewed-count d-flex">
                        <div class="ml-auto mr-0">
                            <span>閲覧数：{{ $post->viewed_count }}</span>
                        </div>
                    </div>
                    {{--登録していないユーザー用--}}
                @guest

                    @endguest
                    @auth
                        {{--投稿ユーザー用--}}
                    @if($post->user_id == auth()->user()->id)
                        <div class="form-end mt-4 d-flex">
                            <div class="mx-auto">
                                <span>投稿の状態：</span>
                                <span class="py-1 px-2 border rounded border-info">
                                    @if($post->post_state==1)公開
                                    @elseif($post->post_state==2)非公開
                                    @else下書
                                    @endif
                            </span>
                            </div>
                        </div>
                        <div class="post-show-button d-flex mt-2">
                            <a href="/post/{{ $post->id }}/edit" class="mr-auto">
                                <button class="btn btn-success">投稿を編集する</button>
                            </a>
                            <form action="/post/{{ $post->id }}" class="ml-auto align-items-end" method="POST">
                                @method('DELETE')
                                @csrf
                                <button class="btn btn-danger">投稿を削除する</button>
                            </form>
                        </div>
                    @endif
                    {{--ログイン済みの閲覧ユーザー用--}}
                        <favoriteButton>{{--Vueでボタン作る--}}</favoriteButton>
                    @endauth
                </div>
            </div>
        </div>
    </div>
    </div>

@endsection
