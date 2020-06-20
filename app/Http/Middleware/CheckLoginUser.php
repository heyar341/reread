<?php

namespace App\Http\Middleware;

use Closure;

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
        if($user != auth()->user()){
            return redirect('/')->with('error','他のユーザーのページです。');
        }

        return $next($request);
    }
}
