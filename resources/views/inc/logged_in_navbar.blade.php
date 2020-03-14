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

        <ul class="navbar-nav ml-auto mr-5">
            <li class="nav-item">
                <a class="nav-link nav-link-favorite text-white btn px-3 mr-2" style="max-width: 142px" href="#">お気に入り一覧</a>
            </li>
            <li class="nav-item ">
                <a class="nav-link nav-link-post btn text-white px-3 mr-3" style="max-width: 142px" href="#">投稿する</a>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle text-white" href="#" id="dropdown04" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">マイページ</a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdown04">
                    <a class="dropdown-item" href="{{--/{{auth()->user->profile}} --}}">プロフィール</a>
                    <a class="dropdown-item" href="{{--投稿ページのURL--}}">公開済みの投稿</a>
                    <a class="dropdown-item" href="{{--投稿ページのURL--}}">編集中の投稿</a>
                    <a class="dropdown-item" href="{{--投稿ページのURL--}}">非公開の投稿</a>


                    <a class="dropdown-item" href="{{ route('logout') }}">ログアウト</a>
                </div>
            </li>
        </ul>
    </div>
</nav>
