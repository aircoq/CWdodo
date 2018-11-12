<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class IndexController extends Controller
{
    /**
     * 后台首页
     */
    function index()
    {
        return view('home.index.index');
    }
    /**
     * 登陆页
     */
    function login(Request $request)
    {
        if($request->isMethod('post')){
            $data = $request->only('username','password','verify','online');
            $role = [
                //'verify' => 'required|captcha',
                'username' =>'required',
                'password' => 'required',
                'online' => 'boolean',
            ];

            $message = [
                //'verify.required'  => '验证码不能为空！',
                //'verify.captcha'  => '验证码错误！',
                'username.required'  => '帐号/手机/邮箱不能为空！',
                'password.required'  => '密码不能为空！',
                'online.boolean' => '请求错误'

            ];
            $validator = Validator::make($data, $role, $message );
            if($validator->fails()) {
//                dump( $validator->messages()->first() ); exit();// 获取一条错误信息
                return ['status' => 'fail', 'msg' => $validator->messages()->first()];
            }
            # 记住登录
            $remember = $request->input('online');
            # 用户验证登录
            $res1 = Auth::guard('web')->attempt( [ 'password'=>$data['password'], 'phone'=>$data['username'] ], $remember );// 手机验证
            $res2 = Auth::guard('web')->attempt( [ 'password'=>$data['password'], 'email'=>$data['username'] ],$remember );// 邮箱验证
            if( $res1 || $res2 ){
                // 登录成功!
                return ['status' => "success", 'msg' => '登陆成功！'];
            }else{
                // 登录失败！
                return ['status' => "fail", 'msg' => '登陆失败！账号及密码无效或错误！'];
            }
        }
        return view('home.index.login');
    }
    /**
     * 登出页
     */
    function logout()
    {
        Auth::guard('users')->logout();
        return redirect()->to('home/index/login')->withErrors('退出登录成功！');
    }
}
