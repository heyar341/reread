@extends('layouts.top')

@section('content')
    <div class="container">
        <div class="col-12 mx-auto" style="max-width: 525px">
            <div class="d-flex align-items-center p-3 mt-3 text-white bg-primary rounded shadow-sm">
                <img class="mr-3 rounded-circle" src="{{config('app.profile_image_url')}}{{ $user->profile->prof_image }}"
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
        </div>
    </div>
@endsection
