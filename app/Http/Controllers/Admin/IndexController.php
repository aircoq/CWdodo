<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Admin\AdminRoleRelated;
use Illuminate\Support\Facades\Validator;

class IndexController extends Controller
{
    /**
     * 后台首页
     */
    public function index()
    {
//        dump(objArr( session('menus')));die();
        return view('admin.index.index');
    }

    /**
     * 后台登录页面
     */
    public function login(Request $request)
    {
        if ($request->isMethod('post')) {
            $data = $request->only('verify','username','password','online');
            $role = [
                //'verify' => 'required|captcha',
                'username' => 'required',
                'password' => 'required',
            ];
            $message = [
                //'verify.required'  => '验证码不能为空！',
                //'verify.captcha'  => '验证码错误！',
                'username.required' => '帐号不能为空！',
                'password.required' => '密码不能为空！',
            ];

            $validator = Validator::make($data, $role, $message);
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator);//如果出错返回上一页
            }
            # 记住登录（只有帐号和手机可以进行登录）
            $remember = $request->only('online');
            $res1 = Auth::guard('admin')->attempt(['password' => $data['password'], 'username' => $data['username'], 'admin_status' => '1','deleted_at' => null],$remember);
            $res2 = Auth::guard('admin')->attempt(['password' => $data['password'], 'phone' => $data['username'], 'admin_status' => '1','deleted_at' => null], $remember);

            # 登录
            if ($res1 || $res2) {// 登录成功
                # 获取当前用户权限菜单保存到cookie中
                $admin_id = Auth::guard('admin')->user()->id;
                $menus = AdminRoleRelated::select('auth.*')
                    ->LeftJoin('role_auth_related', 'role_auth_related.role_id', 'admin_role_related.role_id')
                    ->LeftJoin('auth', 'auth.id', 'role_auth_related.auth_id')
                    ->where('admin_role_related.admin_id',$admin_id)
                    ->where('auth.is_menu','1')
                    ->groupBy('auth.id')
                    ->orderBy('auth.sort_order','DESC')
                    ->get()
                    ->groupBy('first_pid');
                session(['menus' => $menus]);
                return ['status' => "success", 'msg' => '登陆成功！'];//跳转由js实现
            } else {// 登录失败
                return ['status' => "fail", 'msg' => '登陆失败！账号或密码错误！'];
            }
        }
        return view('admin.index.login');
    }
    /**
     * 退出登录
     */
    public function logout()
    {
        Auth::guard('admin')->logout();
        return redirect()->to('admin/login')->withErrors(['退出登录成功！']);
    }

    /**
     * 404页面
     */
    public function err404()
    {
        return view('admin.index.404');
    }
}
