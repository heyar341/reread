@extends('layouts.standard')

@section('content')
    <div class="container">
        <div class="row d-flex">
            @foreach($books as $book)
                <div class="col-lg-6">
                    <div class="card mb-3" style="max-width: 540px; min-height:250px;">
                        <div class="row" style="min-height: 190px">
                            {{--書籍情報の左側--}}
                            <div class="col-sm-4 mt-2">
                                <img src="{{ $book['volumeInfo']['imageLinks']['thumbnail'] }}"
                                     class="w-80 d-block ml-2" style="display: inline-block;max-height: 180px">
                            </div>
                            {{--書籍情報の右側--}}
                            <div class="col-sm-8 mt-2">
                                <h5>{{ mb_substr($book['volumeInfo']['title'],0,30) }}
                                    @if(mb_strlen($book['volumeInfo']['title']) > 30)･･･@endif
                                </h5>
                                <a href="{{ $book['volumeInfo']['infoLink'] }}">この書籍の詳細情報</a><br>
                                <small>著者：{{ implode(',',$book['volumeInfo']['authors']) }}、</small>
                                <small>出版年：{{ mb_substr($book['volumeInfo']['publishedDate'],0,4) }}、</small>
                                <small>ページ数：{{ $book['volumeInfo']['pageCount'] }}</small>
                                <p>{{ mb_substr($book['volumeInfo']['description'],0,50) }}
                                    @if(mb_strlen($book['volumeInfo']['description'] > 50))･･･@endif
                                </p>
                            </div>
                        </div>
                        {{--書籍情報を投稿作成画面に渡す--}}
                        <div class="d-flex mb-2">
                            <form class="mx-auto" action="/post/create" method="post">
                                @csrf
                                {{--book[id]は主キーとして使えないので、bookCodeとして保存--}}
                                <input type="hidden" name="bookCode" value="{{ $book['id'] }}">
                                <input type="hidden" name="thumbnail"
                                       value="{{ $book['volumeInfo']['imageLinks']['thumbnail'] }}"
                                >
                                <input type="hidden" name="title" value="{{ $book['volumeInfo']['title'] }}">
                                <input type="hidden" name="infoLink" value="{{ $book['volumeInfo']['infoLink'] }}">
                                <input type="hidden" name="authors"
                                       value="{{ implode(',',$book['volumeInfo']['authors']) }}">
                                <input type="hidden" name="publishedDate"
                                       value="{{ $book['volumeInfo']['publishedDate'] }}">
                                <input type="hidden" name="pageCount"
                                       value="{{ $book['volumeInfo']['pageCount'] }}">
                                <input type="hidden" name="description"
                                       value="{{ mb_substr($book['volumeInfo']['description'],0,100) }}">
                                <div>
                                    <button class="btn text-white" style="background-color: #2C7CFF;">要約を投稿する
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="book-search">
            <div class="row col-12">
                <h3 class="mt-5 mb-3">見つからない場合、より詳しく書籍の題名をご入力ください</h3>
            </div>
            <form action="search" method="post">
                @csrf
                <div class="form-group">
                    <input class="form-control py-1 @error('bookName') is-invalid @enderror" type="text" name="bookName"
                           value="{{$book_name_base}}"
                           placeholder="書籍名を入力">
                    @error('bookName')
                    <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                    @enderror
                    </span>
                </div>
                <button class="form-control btn btn-primary">本を検索</button>
            </form>
        </div>
    </div>
@endsection
