@extends('errors::minimal')

@section('title', __('Forbidden'))
@section('code', '403')
{{--@section('message', __($exception->getMessage() ?: 'Forbidden'))--}}
@section('message')
<div class="content">
    <h1>ログインしたユーザー専用のページです。</h1>
    <h1>登録済みの方はログインページよりログインをお願いします。</h1>
</div>
@endsection
