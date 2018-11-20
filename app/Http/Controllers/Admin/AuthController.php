<?php

namespace App\Http\Controllers\Admin;

use App\Models\Admin\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.auth.index');
    }

    /**
     * 列表数据
     */
    public function ajax_list(Request $request, Auth $auth)
    {
        if ($request->ajax()) {
            $data = $auth->select('id','auth_name','auth_controller','auth_action','auth_pid','route_name','is_menu','is_enable','sort_order','auth_desc','created_at','updated_at', 'deleted_at')->withTrashed()->get();
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
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Auth $auth)
    {
        $data['auth'] = $auth->where('is_menu','1')->get();
        return view('admin.auth.create',$data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request,Auth $auth)
    {
        $data = $request->only('auth_name','auth_controller','auth_action','auth_pid','is_menu','is_enable','sort_order','auth_desc');
        $role = [
            'auth_name' => 'nullable|alpha_num|between:2,8|unique:auth',
            'auth_controller' => 'nullable|required_if:is_enable,1|required_with:auth_action|alpha_dash',
            'auth_action'=> 'nullable|alpha_dash',
            'auth_pid' => 'required|integer',
            'is_menu' => 'required|in:0,1',
            'is_enable' => 'required|in:0,1',
            'sort_order' => 'nullable|integer',
            'auth_desc' => 'nullable|string',

        ];
        $message = [
            'auth_name.alpha_num' => '名称长度为2到8位字节组成',
            'auth_name.between' => '名称长度为2到8位字节组成',
            'auth_name.unique' => '权限名重复',
            'auth_controller.required_if' => '当前情况控制器为必填',
            'auth_controller.required_with' => '当前情况控制器为必填',
            'auth_controller.alpha_dash' => '控制器为普通字符串',
            'auth_action.alpha_dash' => '方法为普通字符串',
            'is_menu.in' => '菜单显示的值有误',
            'is_enable.in' => '是否可用的值有误',
            'sort_order.integer' => '排序字段必须为整数',
            'auth_desc.string' => '描述的值必须为字符串格式'
        ];
        $validator = Validator::make($data, $role, $message);
        if ($validator->fails()) {
            return ['status' => 'fail', 'msg' => $validator->messages()->first()];
        }
        # 层级关系为：父级的层级+1
        if($data['auth_pid'] === 0){//顶级菜单
            $data['path'] = 1;
        }else{
            $p_path = $auth->where('id',$data['auth_pid'])->first();
            $data['path'] = $p_path['path']+1;
        }
        if(!empty($data['auth_controller'])){
            $data['action'] = empty($data['auth_action']) ? 'index' : $data['auth_action'];
            $data['route_name'] = $data['auth_controller'].'.'.$data['action'];
        }
        $res = $auth->create($data);
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
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(auth $auth)
    {
        $data['auth'] = $auth;//当前记录
        $all_auth = new Auth();
//        $data['all_auth'] = $all_auth->where('is_menu','1')->where('id','!=',$auth->id)->get();//除去本身外的所有记录
        $data['all_auth'] = $all_auth->where('is_menu','1')->get();//除去本身外的所有记录
        return view('admin.auth.edit',$data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,auth $auth)
    {
        $data = $request->only('auth_name','auth_controller','auth_action','auth_pid','is_menu','is_enable','sort_order','auth_desc');
        $role = [
            'auth_name' => 'nullable|alpha_num|between:2,8|unique:auth,auth_name,'.$auth->id,
            'auth_controller' => 'nullable|required_if:is_enable,1|required_with:auth_action|alpha_dash',
            'auth_action'=> 'nullable|alpha_dash',
            'auth_pid' => 'required|integer|not_in:'.$auth->id,
            'is_menu' => 'required|in:0,1',
            'is_enable' => 'required|in:0,1',
            'sort_order' => 'nullable|integer',
            'auth_desc' => 'nullable|string',

        ];
        $message = [
            'auth_name.alpha_num' => '名称长度为2到8位字节组成',
            'auth_name.between' => '名称长度为2到8位字节组成',
            'auth_name.unique' => '权限名重复',
            'auth_controller.required_if' => '当前情况控制器为必填',
            'auth_controller.required_with' => '当前情况控制器为必填',
            'auth_controller.alpha_dash' => '控制器为普通字符串',
            'auth_action.alpha_dash' => '方法为普通字符串',
            'auth_pid.integer' => '父级菜单非法',
            'auth_pid.not_in' => '父级菜单不能为其本身',
            'is_menu.in' => '菜单显示的值有误',
            'is_enable.in' => '是否可用的值有误',
            'sort_order.integer' => '排序字段必须为整数',
            'auth_desc.string' => '描述的值必须为字符串格式'
        ];
        $validator = Validator::make($data, $role, $message);
        if ($validator->fails()) {
            return ['status' => 'fail', 'msg' => $validator->messages()->first()];
        }
        # 层级关系为：父级的层级+1
        if($data['auth_pid'] === 0){//顶级菜单
            $data['path'] = 1;
        }else{
            $p_path = $auth->where('id',$data['auth_pid'])->first();
            $data['path'] = $p_path['path']+1;
        }
        # 定义route_name字段
        if(!empty($data['auth_controller'])){
            $data['action'] = empty($data['auth_action']) ? 'index' : $data['auth_action'];
            $data['route_name'] = $data['auth_controller'].'.'.$data['action'];
        }
        $res = $auth->update($data);
        if ($res) {
            // 如果添加数据成功，则返回列表页
            return ['status' => "success", 'msg' => '更新成功'];
        }else{
            return ['status' => 'fail', 'msg' => '更新失败'];
        }
    }

    /**
     * 软删除
     */
    public function destroy(Auth $auth)
    {
        $auth_models = new Auth();
        if($auth_models->where('auth_pid',$auth->id)->exists()){//如果存在子集不能被删除
            return ['status' => 'fail', 'msg' => '存在子集，不能被删除'];
        }else{
            $res = $auth->delete();
            if ($res) {
                // 如果添加数据成功，则返回列表页
                return ['status' => "success", 'msg' => '删除成功'];
            }else{
                return ['status' => 'fail', 'msg' => '删除失败'];
            }
        }
    }

    /**
     * 恢复软删除（超级管理员权限）
     */
    public function re_store(Request $request,Auth $auth)
    {
        if ($request->ajax()) {
            $id = $request->only('id')['id'];
            $auth_models = new Auth();
            $auth_now = $auth_models->where('id', $id)->first();//当前模型的 auth_pid
            if($auth_now['auth_pid'] != 0){
                if(!$auth_models->where('id',$auth_now['auth_pid'])->exists()){//如果不存在父级不能被恢复
                    return ['status' => 'fail', 'msg' => '父级不存在，不能被恢复'];
                }
            }
            $res = $auth->where('id', $id)->restore();
            if ($res) {
                return ['status' => 'success','msg' => '恢复完毕！'];
            } else {
                return ['status' => 'fail', 'msg' => '恢复失败！'];
            }
        }
    }
}
