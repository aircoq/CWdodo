<?php

namespace App\Http\Middleware;

use Closure;

class checkWechatApp
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
        if(!Redis::exists($request['session_key'])){
            return '登陆过期请重新登陆';
        }
        $user_now = Redis::get($request['session_key']);
        $user_now = json_decode($user_now,true);
        if(empty($user_now['phone'])){
            return '请先绑定手机号';
        }
        return $next($request);
    }
}
