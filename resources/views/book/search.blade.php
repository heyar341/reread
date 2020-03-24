@extends('layouts.top')

@section('content')
    <div class="container">
        <div class="row">
            <div class="book-search mx-auto">
                <form action="search" method="post">
                    @csrf
                    <input class="py-1" type="text" name="book" placeholder="書籍名を入力" style="width: 400px">
                    <button class="btn btn-primary">本を検索</button>
                </form>
            </div>
        </div>
    </div>
@endsection
