@extends('layouts.profile_edit')

@section('content')
    <div class="container">
        <form action="/profile/{{ $user->id }}" enctype="multipart/form-data" method="post">
            @csrf
            @method('PATCH')
            <div class="row">
                <div class="col-8 mx-auto">
                    <h1>プロフィール編集</h1>
                    <div class="form-group">
                        <label for="name" class="col-form-label">自己紹介</label>
                        {{--自己紹介--}}
                        <textarea class="form-control" name="intro_self" autocomplete="intro_self"
                                  autofocus>@if($user->profile->intro_self != 'Not Edited'){{--ユーザーが変更している場合--}}{{ old('intro_self') ?? $user->profile->intro_self }}@else{{--デフォルトの場合--}}{{ old('intro_self') ?? '' }}
                            @endif
                        </textarea>
                        @error('text')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    {{--ユーザーのサイトURL--}}
                    <div class="form-group">
                        <label for="name" class="col-form-label">ご自身のサイトなどのURL</label>
                        <input
                            type="text"
                            class="form-control @error('prof_url') is-invalid @enderror"
                            name="prof_url"
                            value=@if($user->profile->prof_url != 'Not Edited')"{{ old('prof_url') ?? $user->profile->prof_url}}"@else
                            "{{ old('prof_url') ?? '' }}"@endif autocomplete="url" autofocus>

                        @error('prof_url')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="name" class="col-form-label">プロフィール画像</label><br>
                        <img class="ml-2 mb-4 rounded-circle" src="{{config('app.profile_image_url')}}{{ $user->profile->prof_image }}"
                             width="100" height="100"><br>

                        <div class="input-selection">
                            <span><strong>プロフィール画像を：</strong></span>
                            <input type="radio" name="prof_image" value="no">変更しない
                            {{--ユーザーの画像がデフォルトでない場合のみ表示--}}
                            @if($user->profile->prof_image != "default-image/profile_image_default.png")
                                <input type="radio" name="prof_image"
                                       value="default-image/profile_image_default.png">
                                デフォルト画像に戻す
                            @endif
                        </div>
                        <h6 class="my-3"><strong>または</strong></h6>
                        <input type="file" class="form-control-file" id="image" name="prof_image"
                               accept="image/png, image/jpeg, image/webp">

                        <br>
                        @error('prof_image')
                        <span class="text-danger">
                            ↑{{ $message }}
                        </span>
                        @enderror
                    </div>
                    <div class="row pt-3">
                        <button class="btn btn-primary">プロフィールを更新する</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection
