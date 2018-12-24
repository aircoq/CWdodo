<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Models\Admin\User;

class IndexController extends Controller
{
    /**
     * 前台首页
     */
    function index()
    {
        return view('home.index.index');
    }
    /**
     * 用户注册
     *  ['username','password','role_id','phone','nickname','email','sex',
     *  ,'avatar','last_ip','last_login']
     */
    public function register(Request $request,User $user)
    {
        if($request->isMethod('post')){
            $data = $request->only('phone','password','password_confirmation','email','nickname','sex','birthday','avatar');
            $role = [
                'phone'=> 'required|unique:users|digits:11',
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
                'phone.digits' => '号码格式不正确',
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
                event(new UserRegistered($res));
                // 如果添加数据成功，则激发注册成功事件
                echo '注册成功';
//            return redirect()->back()->withErrors(['error'=>'添加失败！']);
            }else{
                echo '注册失败!';
//            return redirect()->back()->withErrors(['error'=>'添加失败！']);
            }
        }
        # 注册页面
        return view('home.index.register');
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
     * 登出方法
     */
    function logout()
    {
        Auth::guard('web')->logout();
        return redirect()->to('home/login')->withErrors('退出登录成功！');
    }
    /**
     * 上传并剪辑头像的方法
     */
    public function avatar_upload(Request $request,User $user)
    {
        $data = $request->only('id','file');
        $role = [
            'id' =>'required|exists:user,id',
        ];
        $message = [
            'id.exists'  => '用户id非法！',

        ];
        $validator = Validator::make($data, $role, $message );
        if($validator->fails()) {
            return ['status' => 'fail', 'msg' => $validator->messages()->first()];
//                return redirect()->back()->withErrors(['id非法']);
        }
        if($request->isMethod('get')){//展示页面
            return view('home.index.avatar_upload',$data);
        }else{//上传到服务器
            # 判断当前请求的是管理员还是用户
            if(!Auth::guard('admin')->check()){//不是系统管理员，只能自己编辑自己
                $data['id'] = Auth::guard('user')->user()->id;//当前用户id
            }
            $img_path = 'uploads/frontend/user_avatar/'.date('Ymd').'/';
            $new_img_adr = uploadBase64Img($img_path);//上传头像
            if($new_img_adr){//成功返回地址
                $avatar_old = $user->where('id',$data['id'])->select('avatar')->first();
                if(!empty($avatar_old['avatar'])){//1.删除老图片
                    if(file_exists('./'.$new_img_adr)){
                        unlink('./'.$avatar_old['avatar']);
                    }
                }
                $tf = $user->where('id',$data['id'])->update(['avatar'=>$new_img_adr]);//2.更新图片地址
                if($tf){
                    return ['status' => 'success','msg' => '上传成功','value'=>"$new_img_adr"];//返回前端图片地址
                }else{//数据库更新失败，删除图片
                    if(file_exists('./'.$new_img_adr)){
                        unlink('./'.$new_img_adr);
                    }
                    return ['status' => 'fail', 'msg' => '更新数据库失败'];
                }
            }else{
                return ['status' => 'fail', 'msg' => '保存失败'];
            }
        }
    }
}
