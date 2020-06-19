@extends('layouts.top')

@section('content')
    <div class="container">
        <div class="mt-5 mx-auto">
            <h2 class="mt-5">アカウントを本当に削除しますか？(この操作は取り消せません。)</h2>
            <div class="row justify-content-center">
                <form action="/delete" style="max-width: 640px;" method="post">
                    @csrf
                    {{--書籍の情報--}}
                    <input type="hidden" name="user" value="{{ $user }}">
                    <button class="btn btn-danger">アカウントを削除する</button>
                </form>
            </div>
        </div>
    </div>
@endsection
