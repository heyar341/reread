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
            <form action="/post/preview" class="mx-auto" style="max-width: 640px;" method="post">
                @csrf
                <div class="post-comment mb-4">
                    <h6>投稿者コメント</h6>
                    <input type="text">
                </div>
                <div class="post-form">
                    <h4>投稿本文</h4>
                    <textarea style="height: 450px" id="tinytextarea"></textarea>
                    <button class="btn btn-primary mt-3">プレビューで確認</button>
                </div>
            </form>
        </div>
        <div>
        </div>
    </div>
</div>

@endsection
