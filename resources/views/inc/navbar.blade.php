<nav class="navbar navbar-expand-lg fixed-top navbar-dark" style="background-color: #005500">
    <a class="navbar-brand" href="#">Re:read</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExample04" aria-controls="navbarsExample04" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarsExample04">
        {{--ナビゲーションバーの左側--}}
        <ul class="navbar-nav mr-auto">
            <li class="nav-item">
                <a class="nav-link text-white border-left px-3" href="#">最新の投稿</a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white border-left px-3" href="#">人気な投稿</a>
            </li>
        </ul>

　　　　　{{--検索フォーム--}}
        <form class="form-inline my-2 my-md-0 d-flex">
            <div class="form-group">
                <input class="form-control" type="text" placeholder="書籍名で投稿を検索">
                <button class="btn btn-outline-info my-2 my-sm-0" type="submit">検索</button>
            </div>
        </form>

        {{--ナビゲーションバーの右側--}}
        <ul class="navbar-nav ml-auto mr-5">
            {{--ログインしていない場合--}}
            @guest
                <li class="nav-item">
                    <a class="nav-link-login btn btn-info mr-2 text-white " href="{{ route('login') }}">ログイン</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link-register btn btn-success text-white" href="{{ route('register') }}">ユーザー登録</a>
                </li>
            {{--ログインしている場合--}}
            @else
            <li class="nav-item">
                <a class="nav-link nav-link-favorite text-white btn px-3 mr-2" style="max-width: 142px" href="#">お気に入り一覧</a>
            </li>
            <li class="nav-item ">
                <a class="nav-link nav-link-post btn text-white px-3 mr-3" style="max-width: 142px" href="/post/create">投稿する</a>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle text-white" href="#" id="dropdown04" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">マイページ</a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdown04">
                    <a class="dropdown-item" href="{{--/{{auth()->user->profile}} --}}">プロフィール</a>
                    <a class="dropdown-item" href="/mypage/{{auth()->user()->id}}/1">公開済みの投稿</a>
                    <a class="dropdown-item" href="/mypage/{{auth()->user()->id}}/2">非公開の投稿</a>
                    <a class="dropdown-item" href="/mypage/{{auth()->user()->id}}/3">編集中の投稿</a>

                    <a class="dropdown-item" href="{{ route('logout') }}"
                    onclick="event.preventDefault();
                    document.getElementById('logout-form').submit();">
                    ログアウト
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </div>
            </li>
            @endguest
        </ul>
    </div>
</nav>
