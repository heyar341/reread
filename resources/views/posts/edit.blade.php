@extends('layouts.post')

@section('content')
    <div class="container">
        <div class="row">
            {{------本の情報--}}
            <div class="book_info mx-auto d-flex mb-5" style="max-width: 640px">
                <div class="col-4">
                    <img src="#book_image_path">
                </div>
                <div class="col-8">
                    <p>Book_description</p>
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

