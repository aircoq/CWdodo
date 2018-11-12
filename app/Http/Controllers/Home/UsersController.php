<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Admin\User;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{

    /**
     * 注册页面
     */
    public function create()
    {
        return view('home.users.create');
    }

    /**
     * 保存到数据库
     *  ['username','password','role_id','phone','nickname','email','sex',
     *  ,'avatar','last_ip','last_login']
     */
    public function store(Request $request,User $user)
    {
        $data = $request->only('phone','password','password_confirmation','email','nickname','sex','birthday','avatar');
        $role = [
            'phone'=> 'required|unique:users|regex:/\d{11}/',
            'password' => 'required|between:6,20|same:password_confirmation',
            'email' => 'sometimes|email|unique:users',
            'nickname' => 'required|min:3|max:8',
            'sex' => 'integer',
//            'birthday' => 'sometimes|date',
            'avatar'   => 'file|image|mimes:png,gif,jpeg,jpg|max:600',
        ];
        $message = [
            'phone.required' => '电话号码不能为空',
            'phone.unique' => '此号码已存在，请勿重复申请',
            'phone.regex' => '号码格式不正确',
            'password.required' => '密码不能为空',
            'password.between' => '密码长度必须为6到20位',
            'password.same' => '密码不一致',
            'email.unique' => 'email已存在，请勿重复申请',
            'email.email' => 'email格式不正确',
            'nickname.required' => '昵称不能为空',
            'nickname.min' => '昵称为3-8位',
            'nickname.max' => '昵称为3-8位',
            'sex.integer' => '性别格式不合法',
//            'birthday.date' => '生日格式不正确',
            'avatar.file'      => '头像上传失败！',
            'avatar.image'     => '头像必须是图片格式！',
            'avatar.mimes'     => '头像的文件格式不正确！',
            'avatar.max'       => '头像的文件最大300K',
        ];
        $validator = Validator::make( $data, $role, $message );
        if( $validator->fails() ){
            dump( $validator->messages()->first() ); exit();// 获取一条错误信息
            //用户提交过来的数据保存到一次性session中
            $request->flash();
            //返回上一页做提示！
            return redirect()->back()->withErrors($validator);
        }
        $data['password'] = bcrypt($data['password']);
//        dump($data);exit();
        //保存头像
        if( $request->hasFile('avatar') ){
            //拼接保存路径
            $path = '/UserAvatar/'.date('Y-m-d');
            // store默认会帮我们把上传文件保存到 storage/app目录下
            $data['avatar'] = $data['avatar']->store( $path,'public' );
        }
        $res = $user->create($data);
        if ($res->id) {
            // 如果添加数据成功，则返回列表页
            echo '注册成功';
//            return redirect()->back()->withErrors(['error'=>'添加失败！']);
        }else{
            echo '注册失败!';
//            return redirect()->back()->withErrors(['error'=>'添加失败！']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }
}
