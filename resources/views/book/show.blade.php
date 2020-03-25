@extends('layouts.search_book')

@section('content')
    <div class="container">
        <div class="row d-flex">
            @foreach($books as $book)
                <div class="col-lg-6">
                    <div class="card mb-3" style="max-width: 540px; min-height:200px">
                        <div class="row">
                            {{--書籍情報の左側--}}
                            <div class="col-sm-4 mt-2">
                                <img src="{{ $book->volumeInfo->imageLinks->thumbnail }}"
                                     class="w-80 d-block"
                                     style="display: inline-block;max-height: 180px">
                            </div>
                            {{--書籍情報の右側--}}
                            <div class="col-sm-8 mt-2">
                                <h4>{{ $book->volumeInfo->title }}</h4>
                                <a href="{{$book->volumeInfo->infoLink}}">この書籍の詳細情報</a><br>
                                <small>{{ implode(',',$book->volumeInfo->authors) }}、</small>
                                <small>出版年：{{ mb_substr($book->volumeInfo->publishedDate,0,4) }}、</small>
                                <small>{{ $book->volumeInfo->pageCount}}ページ</small>
                                <p>{{ mb_substr($book->volumeInfo->description,0,50) }}･･･</p>
                            </div>
                            {{--書籍情報を投稿作成画面に渡す--}}
                            <form class="mx-auto mb-2" action="/post/create" method="post">
                                @csrf
                                {{--book->idは主キーとして使えないので、bookCodeとして保存--}}
                                <input type="hidden" name="bookCode" value="{{ $book->id }}">
                                <input type="hidden" name="thumbnail" value="{{ $book->volumeInfo->imageLinks->thumbnail }}">
                                <input type="hidden" name="title" value="{{ $book->volumeInfo->title }}">
                                <input type="hidden" name="infoLink" value="{{ $book->volumeInfo->infoLink }}">
                                <input type="hidden" name="authors" value="{{ implode(',',$book->volumeInfo->authors) }}">
                                <input type="hidden" name="publishedDate" value="{{ $book->volumeInfo->publishedDate }}">
                                <input type="hidden" name="pageCount" value="{{ $book->volumeInfo->pageCount}}">
                                <input type="hidden" name="description" value="{{ $book->volumeInfo->description }}">
                                <div>
                                <button class="btn text-white" style="background-color: #2C7CFF">要約を投稿する
                                </button>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection