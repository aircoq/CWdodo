<?php

namespace App\Http\Controllers\Admin;


use App\Models\Admin\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request,User $user)
    {
        if ($request->ajax()) {
            if (Auth::guard('admin')->user()->role_class == '*') {//管理员查看包括软删除的用户
                $data = $user->select('id', 'nickname', 'phone', 'email', 'sex', 'user_status', 'integral', 'frozen_integral', 'user_money', 'frozen_money', 'credit_line', 'cost_total', 'user_level', 'avatar', 'birthday', 'city', 'height', 'weight', 'has_medal', 'flag', 'address_id', 'qr_code', 'parent_id', 'zone_cate_id', 'fans_list', 'friends_list', 'last_ip', 'last_login', 'remember_token', 'desc', 'note', 'question_answer', 'created_at', 'updated_at', 'deleted_at')->withTrashed()->get();
                $cnt = count($data);
                $info = [
                    'draw' => $request->get('draw'),
                    'recordsTotal' => $cnt,
                    'recordsFiltered' => $cnt,
                    'data' => $data,
                ];
                return $info;
            }
        }
        return view('admin.user.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.user.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request,User $user)
    {
        $data = $request->only('nickname','phone','email','password','confirm_password','user_status','note','accepted');
        $role = [
            'nickname' => 'required|alpha_num|between:5,12|unique:user',
            'phone'=> 'required|unique:user|regex:/^1[3-9]\d{9}/',
            'email' => 'required|email|unique:user',
            'password' => 'required|between:6,20|same:confirm_password',
            'user_status' => 'integer',
            'note' => 'nullable|string|between:0,100',
//                'accepted' => 'accepted',
        ];
        $message = [
            'nickname.required' => '用户名不能为空',
            'nickname.alpha_num' => '用户长度为5到12位的英文、数字组成',
            'nickname.between' => '用户长度为5到12位的英文、数字组成',
            'nickname.unique' => '用户名重复',
            'phone.required' => '手机号码不能为空',
            'phone.unique' => '此号码已存在，请勿重复申请',
            'phone.regex' => '手机号码不正确',
            'email.required' => 'email不能为空',
            'email.unique' => 'email已存在，请勿重复申请',
            'email.email' => 'email格式不正确',
            'password.required' => '密码不能为空',
            'password.between' => '密码长度必须为6到20位',
            'password.same' => '密码不一致',
            'note.string' => '备注不正确',
            'note.between' => '备注最大100个字节',
//                'accepted.accepted' => '请仔细阅读服务条款'
        ];
        $validator = Validator::make( $data, $role, $message );
        if( $validator->fails() ){
//            dump( $validator->messages()->first(),$data ); exit();// 获取一条错误信息
            $request->flash();//保存当前数据到一次性session中
            //返回上一页做提示！
            return ['status' => "fail", 'msg' => $validator->messages()->first()];
        }
        // 数据调整
        $data['password'] = bcrypt($data['password']);
        $res = $user->create($data);
        if ($res->id) {
            // 如果添加数据成功，则返回列表页
            return ['status' => "success", 'msg' => '添加成功'];
        }else{
            return ['status' => 'fail', 'msg' => '添加失败'];
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

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        $data['user'] = $user;
        return view('admin.user.edit',$data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $data = $request->only('nickname','sex','phone','email','password','confirm_password','user_status','birthday','city','avatar','height','weight','note','accepted');
        $role = [
            'nickname' => 'required|alpha_num|between:5,12|unique:user,nickname,'.$user->id,
            'sex' => 'nullable|in:0,1,2',
            'phone'=> 'required|digits:11|unique:user,phone,'.$user->id,
            'email' => 'nullable|email|unique:user,email,'.$user->id,
            'password' => 'nullable|between:6,20|same:confirm_password',
            'user_status' => 'nullable|integer',
            'birthday' => 'nullable|date',
            'city' => 'nullable|string',
            'height' => 'nullable|integer',
            'avatar'   => 'file|image|mimes:png,gif,jpeg,jpg|max:600',
            'note' => 'nullable|string|between:0,100',
//                'accepted' => 'accepted',
        ];
        $message = [
            'nickname.required' => '用户名不能为空',
            'nickname.alpha_num' => '用户长度为5到12位的英文、数字组成',
            'nickname.between' => '用户长度为5到12位的英文、数字组成',
            'nickname.unique' => '用户名重复',
            'sex.integer' => '性别格式不合法',
            'phone.required' => '手机号码不能为空',
            'phone.unique' => '此号码已存在，请勿重复申请',
            'phone.regex' => '手机号码不正确',
            'email.required' => 'email不能为空',
            'email.unique' => 'email已存在，请勿重复申请',
            'email.email' => 'email格式不正确',
            'password.required' => '密码不能为空',
            'password.between' => '密码长度必须为6到20位',
            'password.same' => '密码不一致',
            'admin_status.integer' => '请正确填写状态',
            'avatar.file'      => '头像上传失败！',
            'avatar.image'     => '头像必须是图片格式！',
            'avatar.mimes'     => '头像的文件格式不正确！',
            'avatar.max'       => '头像的文件最大500K',
            'note.string' => '备注不正确',
            'note.between' => '备注最大100个字节',
//                'accepted.accepted' => '请仔细阅读服务条款'
        ];
        $validator = Validator::make( $data, $role, $message );
        if( $validator->fails() ){
//            dump( $validator->messages()->first(),$data ); exit();// 获取一条错误信息
            $request->flash();//保存当前数据到一次性session中
            //返回上一页做提示！
            return ['status' => "fail", 'msg' => $validator->messages()->first()];
        }
        // 数据调整
        $data['password'] = bcrypt($data['password']);
        //保存头像
        if( $request->hasFile('avatar') ){
            $path = '/vatar/'.date('Y-m-d');
            // store默认会帮我们把上传文件保存到 storage/app/public目录下
            $data['avatar'] = $data['avatar']->store( $path,'public');
        }
        $res = $user->update($data);
        if ($res) {
            // 如果添加数据成功，则返回列表页
            return ['status' => "success", 'msg' => '添加成功'];
        }else{
            return ['status' => 'fail', 'msg' => '添加失败'];
        }
    }

    /**
     *软删除
     */
    public function destroy(User $user)
    {
        $res = $user->delete();
        if ($res) {
            return ['status' => 'success'];
        } else {
            return ['status' => 'fail', 'msg' => '删除失败！'];
        }
    }
    /**
     * 恢复软删除（超级管理员权限）
     */
    public function re_store(Request $request,User $user)
    {
        if ($request->ajax()) {
                $id = $request->only('id');
                $res = $user->where('id', $id)->restore();
                if ($res) {
                    return ['status' => 'success'];
                } else {
                    return ['status' => 'fail', 'msg' => '恢复失败！'];
                }
        }
    }
}
