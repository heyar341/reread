@extends('layouts.post')

@section('content')
    <div class="container">
        <div class="row">
            {{------本の情報--}}
            <div class="col-lg-8 mx-auto">
                <div class="card mb-3" style="min-height:150px">
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

            {{------投稿編集エリア--}}
            <div class="col-12">
                <form action="/post/{{ $post->id }}" class="mx-auto" style="max-width: 640px;" method="post">
                    @csrf
                    @method('PATCH')
                    <div class="post-comment mb-4">
                        <h5>投稿者コメント：</h5>
                        <textarea style="width: 100%"
                                  name="thumbnail_comment">{{ old('thumbnail_comment') ?? $post->thumbnail_comment }}</textarea>
                    </div>
                    <div class="post-form">
                        <h4>投稿本文：</h4>
                        <textarea style="height: 400px" id="tinytextarea"
                                  name="main_content">{{ old('main_content') ?? $post->main_content }}</textarea>

                        <div class="form-end mt-4 d-flex align-items-center">
                            <span>投稿の状態：</span>
                            <select name="post_state">
                                <option value="1" @if($post->post_state==1 or old('post_state')==1) selected @endif>公開
                                </option>
                                <option value="2" @if($post->post_state==2 or old('post_state')==2) selected @endif>
                                    非公開
                                </option>
                                <option value="3" @if($post->post_state==3 or old('post_state')==3) selected @endif>
                                    下書き
                                </option>
                            </select>
                            <span class="ml-1 mr-2">で</span>
                            <button class="btn btn-primary">更新する</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection

