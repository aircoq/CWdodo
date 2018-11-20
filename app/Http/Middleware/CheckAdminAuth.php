<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

class CheckAdminAuth
{
    /**
     * 把这个放在中间件CheckAdmin里
     */
    public function handle($request, Closure $next)
    {
        # 放在CheckAdmin可省略以下逻辑
        if(!Auth::guard('admin')->check()){
            return redirect('admin/login');
        }
        if(Auth::guard('admin')->user()->role_class !== '*'){//如果不是超级管理员则需要验证权限
            # 获取当前路由的别名，如果没有返回 null
            $route = Route::currentRouteName();
            # 判断是否拥有权限
            if ( ! Auth::guard('admin')->user()->hasAuth($route)) { //当前用户没有这个权限
                return response()->view('admin.index.404',["msg" => "权限不足" ]);
            }
        }
        return $next($request);
    }
}
