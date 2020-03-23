@extends('layouts.top')

@section('content')
    <div class="container">
        <form action="/profile/{{ $user->id }}" enctype="multipart/form-data" method="post">
            @csrf
            @method('PATCH')
            <div class="row">
                <div class="col-8">
                    <h1>プロフィール編集</h1>
                    <div class="form-group row">
                        <label for="name" class="col-md-4 col-form-label">自己紹介</label>
                        {{--自己紹介--}}
                        <textarea class="form-control" name="intro_self" required autocomplete="intro_self"
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
                    <div class="form-group row">
                        <label for="name" class="col-md-4 col-form-label">ご自身のサイトなどのURL</label>
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


                    <div class="row">
                        <label for="name" class="col-md-4 col-form-label">プロフィール画像</label>
                        <input type="file" , class="form-control-file" id="image" name="prof_image">
                    </div>

                    <div class="row pt-3">
                        <button class="btn btn-primary">プロフィールを更新する</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection
