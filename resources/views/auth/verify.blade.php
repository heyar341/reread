@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">メールアドレスの有効化</div>

                <div class="card-body">
                    @if (session('resent'))
                        <div class="alert alert-success" role="alert">
                            ご登録いただいたメールアドレスにリンクを送信しました。
                            リンクをクリックしてメールアドレスを有効化してください。
                        </div>
                    @endif

                    メールが届かない方は
                    <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
                        @csrf
                        <button type="submit" class="btn btn-link p-0 m-0 align-baseline">こちらをクリックしてください</button>.
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
