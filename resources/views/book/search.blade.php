@extends('layouts.standard')

@section('content')
    <div class="container">
        <div class="row">
            <div class="book-search mx-auto">
                <h2 class="mt-5 mb-3">要約を投稿したい書籍の題名をご入力ください</h2>
            </div>
        </div>
        <form action="search" method="post">
            @csrf
            <div class="form-group">
                <input class="form-control py-1 @error('bookName') is-invalid @enderror" type="text"
                       name="bookName"
                       placeholder="書籍名を入力">
                @error('bookName')
                <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                @enderror
            </div>
            <button class="form-control btn btn-primary">書籍を検索</button>
        </form>

        <div class="row mt-5">
            <div class="col-md-10 mx-auto">
                <img class="mx-auto" src="{{config('app.profile_image_url')}}default-image/book_edit_instruct.png"
                     style="max-width: 100%;height: auto">
            </div>
        </div>
    </div>
@endsection
