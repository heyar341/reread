@extends('layouts.top')

@section('content')
    <div class="container">
        <div class="row">
            <div class="book-search mx-auto">
                <h2 class="mt-5 mb-3">要約を投稿したい書籍の題名をご入力ください</h2>
                <form action="search" method="post">
                    @csrf
                    <div class="d-flex">
                        <div>
                            <input class="py-1 @error('bookName') is-invalid @enderror" type="text" name="bookName"
                                   placeholder="書籍名を入力" style="max-width: 400px">
                            @error('bookName')
                            <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                            @enderror
                        </div>
                        <div>
                            <button class="btn btn-primary">本を検索</button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-md-8 mx-auto">
                <img class="mx-auto" src="/storage/default/search_book_instruct.png" style="max-width: 100%;height: auto">
            </div>
        </div>
    </div>
@endsection
