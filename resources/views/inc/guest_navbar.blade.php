<nav class="navbar navbar-expand-lg fixed-top navbar-dark" style="background-color: #005500">
    <a class="navbar-brand" href="#">Re:read</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExample04" aria-controls="navbarsExample04" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarsExample04">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item">
                <a class="nav-link text-white border-left px-3" href="#">最新の投稿</a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white border-left px-3" href="#">人気な投稿</a>
            </li>
        </ul>

                <form class="form-inline my-2 my-md-0 d-flex">
                    <div class="form-group">
                        <input class="form-control" type="text" placeholder="書籍名で投稿を検索">
                        <button class="btn btn-outline-info my-2 my-sm-0" type="submit">検索</button>
                    </div>
                </form>

            {{-- 認証関連のリンク --}}
                {{-- 「ログイン」と「ユーザー登録」へのリンク --}}
            <ul class="navbar-nav ml-auto mr-5">
                <li class="nav-item">
                    <a class="nav-link-login btn btn-info mr-2 text-white " href="{{ route('login') }}">ログイン</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link-register btn btn-success text-white" href="{{ route('register') }}">ユーザー登録</a>
                </li>
            </ul>
    </div>
</nav>
