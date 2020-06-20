<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
class CheckLoginUser
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        //ルートパラメーターからuserを取得
        $user = $request->route()->parameter('user');
        //他のユーザーページにアクセスしようとしたら、ホームページに飛ばす。
        if($user->id != auth()->user()->id){
            return redirect('/')->with('error','他のユーザーのページです。');
        }

        return $next($request);
    }
}
