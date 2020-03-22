@extends('layouts.post')

@section('content')
    <div class="container">
        <div class="row">
            {{------本の情報--}}
            <div class="book_info mx-auto d-flex mb-5" style="max-width: 640px">
                <div class="col-4">
                    {{--                    <img src="#book_image_path">--}}
                </div>
                <div class="col-8">
                    <p>Book_description</p>
                </div>
            </div>

            {{------投稿本文エリア--}}
            <div class="col-12">
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
