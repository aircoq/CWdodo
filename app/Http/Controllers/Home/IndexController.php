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
                // return ['status' => 'fail', 'msg' => $validator->messages()->first()];
                return redirect()->back()->withErrors($validator->messages()->first());//如果出错返回上一页
            }
            // 记住登录
            $remember = $request->input('online');
            // 验证登录
            // 手机号码登录
            $res1 = Auth::guard('users')->attempt( [ 'password'=>$data['password'], 'phone'=>$data['username'] ], $remember );
            // 邮箱登录
            $res2 = Auth::guard('users')->attempt( [ 'password'=>$data['password'], 'email'=>$data['username'] ],$remember );
            if( $res1 || $res2 ){
                // 登录成功!
                return redirect()->to('home/index');
            }else{
                // 登录失败！
                return redirect()->back()->withErrors(['登录失败!']);
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
