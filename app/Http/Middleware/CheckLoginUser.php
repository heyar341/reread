<?php

namespace App\Http\Middleware;

use Carbon\Carbon;
use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class CheckLoginUser
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $user_info = auth()->user()->id ?? 'guest';
        Log::info($user_info . ' accessed ' . url()->current() . ' at ' . Carbon::now() . ' IP: ' . $request->ip()/**$_SERVER["HTTP_X_FORWARDED_FOR"]*/);
        //ルートパラメーターからuserを取得
        $user = $request->route()->parameter('user');
        //他のユーザーページにアクセスしようとしたら、ホームページに飛ばす。
        if ($user->id != auth()->user()->id) {
            return redirect('/')->with('error', '他のユーザーのページです。');
        }

        return $next($request);
    }
}
