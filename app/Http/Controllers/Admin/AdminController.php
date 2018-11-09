<?php

namespace App\Http\Controllers\Admin;

use App\Models\Admin\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
Use Redis;

# 只有超级管理员才有权限
class AdminController extends Controller
{
    /**
     * 管理员首页
     */
    public function index()
    {
        return view('admin.admin.index');
    }

    /**
     * 列表数据
     */
    public function ajax_list(Request $request, Admin $admin)
    {
        if ($request->ajax()) {
            if(Auth::guard('admin')->user()->role_id == '*') {//管理员查看包括软删除的用户
                $data = $admin->select('id','username','avatar','role_id','admin_status','agency_id','note','deleted_at')->withTrashed()->get();
            }else{
                $data = $admin->select('id','username','avatar','role_id','admin_status','agency_id','note','deleted_at')->get();
            }
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
    /**
     * 渲染新建管理员页面
     */
    public function create()
    {
        if(Auth::guard('admin')->user()->role_id == '*'){//重置屏蔽项
            return view('admin.admin.create');
        }
        echo '您暂无权限！';
    }

    /**
     * 新增管理员
     *  ['username','password','role_id','phone','nickname','email','sex',
     *  ,'avatar','last_ip','last_login']
     */
    public function store(Request $request,Admin $admin)
    {
        if ($request->ajax() && Auth::guard('admin')->user()->role_id == '*') {//重置屏蔽项目 Auth::guard('admin')->user()->role_id == '*'
            $data = $request->only('username','sex','phone','email','password','confirm_password','admin_status','role_id','avatar','note','accepted');
            $role = [
                'username' => 'required|alpha_num|between:5,12|unique:admin',
                'sex' => 'integer',
                'phone'=> 'required|unique:admin|regex:/^1[3-9]\d{9}/',
                'email' => 'required|email|unique:admin',
                'password' => 'required|between:6,20|same:confirm_password',
                'admin_status' => 'integer',
                'role_id' => 'required|exists:role,id',
                'avatar'   => 'file|image|mimes:png,gif,jpeg,jpg|max:600',
                'note' => 'nullable|string|between:0,100',
//                'accepted' => 'accepted',
            ];
            $message = [
                'username.required' => '用户名不能为空',
                'username.alpha_num' => '用户长度为5到12位的英文、数字组成',
                'username.between' => '用户长度为5到12位的英文、数字组成',
                'username.unique' => '用户名重复',
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
                'role_id.required' => '角色名必须填写',
                'role_id.exists' => '角色不存在',
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
                $path = '/AdminAvatar/'.date('Y-m-d');
                // store默认会帮我们把上传文件保存到 storage/app/public目录下
                $data['avatar'] = $data['avatar']->store( $path,'public');
            }
            $res = $admin->create($data);
            if ($res->id) {
                // 如果添加数据成功，则返回列表页
                return ['status' => "success", 'msg' => '添加成功'];
            }else{
                return ['status' => 'fail', 'msg' => '添加失败'];
            }
        }else{
            return ['status' => 'fail', 'msg' => '非法请求'];
        }
    }

    /**
     * Display the specified resource.
     *
     */
    public function show($id)
    {
        //
    }

    /**
     * 编辑页面
     */
    public function edit(Admin $admin)
    {
        if($admin){
            $data['user'] = $admin;
            return view('admin.admin.edit',$data);
        }
    }

    /**
     * 更新功能
     */
    public function update(Request $request,Admin $admin)
    {
        $data = $request->only('id','username','sex','phone','email','password','confirm_password','admin_status','role_id','note');
        $role = [
            'username' => 'nullable|alpha_num|between:5,12|unique:admin,username,'.$admin->id,
            'sex' => 'nullable|integer',
            'phone'=> 'nullable|digits:11|unique:admin,phone,'.$admin->id,
            'email' => 'nullable|email|unique:admin,email,'.$admin->id,
            'password' => 'nullable|between:6,20|same:confirm_password',
            'admin_status' => 'nullable|integer',
            'role_id' => 'nullable|exists:role,id',
            'note' => 'nullable|string|between:0,100',
        ];
        $message = [
            'username.alpha_num' => '用户长度为5到12位的英文、数字组成',
            'username.between' => '用户长度为5到12位的英文、数字组成',
            'username.unique' => '用户名重复',
            'sex.integer' => '性别格式不合法',
            'phone.digits' => '手机号码不正确',
            'phone.unique' => '此号码已存在，请勿重复申请',
            'email.unique' => 'email已存在，请勿重复申请',
            'email.email' => 'email格式不正确',
            'password.between' => '密码长度必须为6到20位',
            'password.same' => '密码不一致',
            'admin_status.integer' => '请正确填写状态',
            'role_id.exists' => '角色不存在',
            'note.string' => '备注不正确',
            'note.between' => '备注最大100个字节',
        ];
        $validator = Validator::make($data, $role, $message);
        if ($validator->fails()) {
            return ['status' => 'fail', 'msg' => $validator->messages()->first()];
        }
        # 修改系统管理员的权限 1.超级管理员修改任何人的 2.普通管理员修改自己的信息
        if(Auth::guard('admin')->user()->role_id == '*'){//1.当前是超级管理员可以修改任何人
            if($admin->role_id == '*' && Auth::guard('admin')->user()->id == $admin->id){//如果修改的是超级管理员信息：只能修改自己
                $data['role_id'] = '*';
                $data['admin_status'] = '1';
            }
        }else{//2.当前是普通管理员：只能修改自己
            $user_id = Auth::guard('admin')->user()->id;//获取当前用户admin_id
            if($admin->id != $user_id){//修改自己的信息
                return ['status' => 'fail', 'msg' => '危险！您暂无权限修改此项'];
            }
            unset($data['role_id']);//无权限修改项
            unset($data['admin_status']);//无权限修改项
        }
        $data['password'] = empty($data['password']) ? null : bcrypt($data['password']);
        $data = empty($data) ? null :  array_filter($data);//去除空值表示不更新
        $tf = $admin->update($data);
        if ($tf){
            return ['status' => 'success', 'msg' => '更新成功！'];
        }
        return ['status' => 'fail', 'msg' => '更新失败'];
    }

    /**
     * 软删除（超级管理员才能禁用管理员）
     */
    public function destroy(Admin $admin)
    {
        # 只有超级管理员才可以操作
        if(Auth::guard('admin')->user()->role_id == '*') {//1.当前是超级管理员可以禁用任何人
            if ($admin->role_id == '*') {//超级管理员不能被删除
                return ['status' => 'fail', 'msg' => '超级管理员不能被删除！'];
            }
            $res = $admin->delete();
            if ($res) {
                return ['status' => 'success'];
            } else {
                return ['status' => 'fail', 'msg' => '删除失败！'];
            }
        }
        return ['status' => 'fail', 'msg' => '您暂无操作权限'];
    }
    /**
     * 恢复软删除（超级管理员权限）
     */
    public function re_store(Request $request,Admin $admin)
    {
        if ($request->ajax()) {
            # 只有超级管理员才可以操作
            if (Auth::guard('admin')->user()->role_id == '*') {//当前是超级管理员可以
                $id = $request->only('id');
                $res = $admin->where('id', $id)->restore();
                if ($res) {
                    return ['status' => 'success'];
                } else {
                    return ['status' => 'fail', 'msg' => '恢复失败！'];
                }
            }
            return ['status' => 'fail', 'msg' => '您暂无操作权限'];
        }
    }
    /**
     * 上传并剪辑头像的方法(超级会员可以修改任何人的头像，非超级会员只能修改自己的头像)
     */
    public function avatar_upload(Request $request,Admin $admin)
    {
        # 禁用错误报告
        error_reporting(0);
        if ($request->isMethod('post')) {
            header('Content-type:text/html;charset=utf-8');
            $base64_image_content = $_POST['imgBase'];
            # base64转图片并上传，更新数据库
            if (preg_match('/^(data:\s*image\/(\w+);base64,)/', $base64_image_content, $result)) {
                $type = $result[2];
                $img_path = 'uploads/avatar/'.date('Ymd').'/';//存储的文件夹地址
                if (!file_exists($img_path)){
                    mkdir ($img_path,0700,true);
                }
                $img=date('Ymd') .uniqid(). ".{$type}";
                $new_file = $img_path . $img;
                //将图片保存到指定的位置，更新数据库
                if (file_put_contents($new_file, base64_decode(str_replace($result[1], '', $base64_image_content)))) {
                    try{
                        //如果是超级管理员则可以更改任何人的头像，普通管理员只能修改自己的
                        $admin_role = Auth::guard('admin')->user()->role_id;
                        if($admin_role == '*'){
                            $id = Redis::get('edit_admin_id_avatar');//传入的用户id
                        }else{
                            $id = Auth::guard('admin')->user()->id;//当前用户id
                        }
                        $avatar_old = $admin->where('id',$id)->select('avatar')->first();
                        if(!empty( $avatar_old['avatar'])){
                            unlink('./'.$avatar_old['avatar']);
                        }
                        $tf = $admin->where('id',$id)->update(['avatar'=>$new_file]);//更新到数据库
                        if(!$tf){
                            if(file_exists('./'.$new_file)){//数据库更新失败，删除图片
                                unlink('./'.$new_file);
                            }
                            return ['status' => 'fail', 'msg' => '更新数据库失败'];
                        }
                    }catch(\Illuminate\Database\QueryException $ex){
                        return ['status' => 'fail', 'msg' => '数据有误，更新数据库失败'];
                    }
                    return ['status' => 'success','msg' => '上传成功','value'=>"$new_file"];//返回前端图片地址
                }else{
                    return ['status' => 'fail', 'msg' => '保存失败'];
                }
            }else{
                return ['status' => 'fail', 'msg' => '保存失败'];
            }

        }else{
            # 获取传入的用户id并验证
            $data['edit_id'] = $request->only('id')['id'];//要被编辑的用户
            $check_id = $admin->select('id')->where('id',$data['edit_id'])->first();
            if(empty($check_id['id'])){
                return redirect()->back()->withErrors(['id非法']);
            }
            # 无权限的返回去 不是超级管理员只能编辑自己的
            $admin_role = Auth::guard('admin')->user()->role_id;
            if($admin_role != '*' ){//不是超级管理员
                $id_now = Auth::guard('admin')->user()->id;//当前用户id
                if($id_now != $data['edit_id']){//不是在编辑自己
                    return '<br/><div style="text-align:center;" ><font color="red">错误：不能修改他人头像</font></div>';
                }
            }
            Redis::set('edit_admin_id_avatar', $data['edit_id']);//存储当前redis,post的时候使用
            return view('admin.admin.avatar_upload',$data);
        }
    }
}
