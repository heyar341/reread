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
                            <img src="{{ $book['thumbnail'] }}"
                                 class="ml-2 mb-1 d-block"
                                 style="display: inline-block;max-height: 144px">
                        </div>
                        {{--書籍情報の右側--}}
                        <div class="col-sm-9 mt-3">
                            <h4>{{ $book['title'] }}</h4>
                            <small>{{ $book['authors'] }}、</small>
                            <small>出版年：{{ $book['publishedDate'] }}、</small>
                            <small>{{ $book['pageCount'] }}ページ</small>
                            <p class="mt-2 mr-2">{{ mb_substr($book['description'],0,100) }}･･･</p>
                        </div>
                    </div>
                </div>
            </div>

            {{------投稿編集エリア--}}
            <div class="col-12">
                <form action="/post" class="mx-auto" style="max-width: 640px;" method="post">
                    @csrf
                    {{--書籍の情報--}}
                    <input type="hidden" name="bookCode" value="{{ $book['bookCode'] }}">
                    <input type="hidden" name="thumbnail" value="{{ $book['thumbnail'] }}">
                    <input type="hidden" name="title" value="{{ $book['title'] }}">
                    <input type="hidden" name="infoLink" value="{{ $book['infoLink'] }}">
                    <input type="hidden" name="authors" value="{{ $book['authors'] }}">
                    <input type="hidden" name="publishedDate" value="{{ $book['publishedDate'] }}">
                    <input type="hidden" name="pageCount" value="{{ $book['pageCount'] }}">
                    <input type="hidden" name="description" value="{{ $book['description'] }}">
                    {{--投稿編集--}}
                    <div class="post-comment mb-4">
                        <h5>投稿者コメント：</h5>
                        <textarea style="width: 100%" name="thumbnail_comment" placeholder="投稿一覧ページに表示されます。"></textarea>
                    </div>
                    <div class="post-form">
                        <h4>投稿本文：</h4>
                        <textarea style="height: 400px" id="tinytextarea" name="main_content"
                                  placeholder="投稿本文をご記入ください。"></textarea>

                        <div class="form-end mt-4 d-flex align-items-center">
                            <span>投稿の状態：</span>
                            <select name="post_state">
                                <option value="1">公開</option>
                                <option value="2">非公開</option>
                                <option value="3">下書き</option>
                            </select>
                            <span class="ml-1 mr-2">で</span>
                            <button class="btn btn-primary">投稿する</button>
                        </div>
                    </div>
                </form>
            </div>
            <div>
            </div>
        </div>
    </div>

@endsection
