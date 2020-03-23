@extends('layouts.top')

@section('content')
    <div class="container">
        <div class="mx-auto" style="max-width: 525px">
            <div class="d-flex align-items-center p-3 mt-3 text-white bg-primary rounded shadow-sm">
                <img class="mr-3 rounded-circle" src="{{ $user->profile->prof_image }}"
                     width="65" height="65">
                <div class="lh-100">
                    <h3 class="ml-2 mb-0 text-black lh-100">{{ $user->username }}</h3>
                    <div>@if($user->profile->prof_url != 'Not Edited')<span class="px-2">サイトURL:</span><a href="#" style="color: #ffffff">{{ $user->profile->prof_url }}</a>@endif</div>
                </div>
            </div>

            <div class="border bg-white" style="min-height: 100px">
                <h6 class="ml-1">自己紹介：</h6>
                <p class="ml-2">@if($user->profile->intro_self != 'Not Edited'){{ $user->profile->intro_self }}@endif</p>
            </div>

            <div class="p-3 bg-white rounded shadow-sm">
                <h5 class="border-bottom border-gray pb-2 mb-0"><strong>メニュー</strong></h5>
                <a href="/profile/{{ $user->id }}/edit">
                    <div class="pt-3">
                        <div class="media-body py-2 mb-0 small lh-125 border-bottom border-gray">
                            <div class="d-flex justify-content-between align-items-center w-100">
                                <h5 class="text-gray-dark">プロフィール編集</h5>
                            </div>
                        </div>
                    </div>
                </a>

                <div class="media text-muted pt-3">
                    <div class="media-body py-2 mb-0 small lh-125 border-bottom border-gray">
                        <div class="d-flex justify-content-between align-items-center w-100">
                            <a href="/follow/{{ $user->id }}/show"><h5 class="text-gray-dark">フォローしたユーザー</h5></a>
                        </div>
                    </div>
                </div>

                <div class="media text-muted pt-3">
                    <div class="media-body py-2 mb-0 small lh-125 border-bottom border-gray">
                        <div class="d-flex justify-content-between align-items-center w-100">
                            <a href="follow/{{ $user->id }}/show"><h5 class="text-gray-dark">フォロワー</h5></a>
                        </div>
                    </div>
                </div>

                <div class="media text-muted pt-3">
                    <div class="media-body py-2 mb-0 small lh-125 border-bottom border-gray">
                        <div class="d-flex justify-content-between align-items-center w-100">
                            <a href="profile/edit"><h5 class="text-gray-dark">投稿済み一覧</h5></a>
                        </div>
                    </div>
                </div>

                <div class="media text-muted pt-3">
                    <div class="media-body py-2 mb-0 small lh-125 border-bottom border-gray">
                        <div class="d-flex justify-content-between align-items-center w-100">
                            <a href="profile/edit"><h5 class="text-gray-dark">アカウントの削除</h5></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
