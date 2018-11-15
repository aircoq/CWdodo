<?php

namespace App\Http\Controllers\Admin;

use App\Models\Admin\Role;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Models\Admin\Auth;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.role.index');
    }
    /**
     * 列表数据
     */
    public function ajax_list(Request $request, Role $role)
    {
        if ($request->ajax()) {
            $data = $role->select('id','role_name','role_auth_id_list','note','created_at', 'deleted_at')->withTrashed()->get();
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
        $data['auth'] = $auth->all();
        return view('admin.role.create',$data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request,Role $admin_role)
    {
        $data = $request->only('role_name','role_auth_id_list','note','created_at', 'deleted_at');
        $role = [
            'role_name' => 'nullable|alpha_num|between:2,8|unique:role',
            'role_auth_id_list' => 'nullable|array',
            'note' => 'nullable|string',

        ];
        $message = [
            'role_name.alpha_num' => '名称长度为2到8位字节组成',
            'role_name.between' => '名称长度为2到8位字节组成',
            'role_name.unique' => '角色名重复',
            'role_auth_id_list.array' => '角色列表格式不正确',
            'note.string' => '描述的值必须为字符串格式'
        ];
        $validator = Validator::make($data, $role, $message);
        if ($validator->fails()) {
            return ['status' => 'fail', 'msg' => $validator->messages()->first()];
        }
        #role_auth_id_list转json存储
        $data['role_auth_id_list'] = json_encode($data['role_auth_id_list']);
        $res = $admin_role->create($data);
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
    public function edit(Role $role,Auth $auth)
    {
        $data['role'] = $role;
        $data['auth'] = $auth->all();
        return view('admin.role.edit',$data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Role $admin_role)
    {
        $data = $request->only('role_name','role_auth_id_list','note','created_at', 'deleted_at');
        $role = [
            'role_name' => 'nullable|alpha_num|between:2,8|unique:role,role_name,'.$admin_role->id,
            'role_auth_id_list' => 'nullable|array',
            'note' => 'nullable|string',

        ];
        $message = [
            'role_name.alpha_num' => '名称长度为2到8位字节组成',
            'role_name.between' => '名称长度为2到8位字节组成',
            'role_name.unique' => '角色名重复',
            'role_auth_id_list.array' => '角色列表格式不正确',
            'note.string' => '描述的值必须为字符串格式'
        ];
        $validator = Validator::make($data, $role, $message);
        if ($validator->fails()) {
            return ['status' => 'fail', 'msg' => $validator->messages()->first()];
        }
        #role_auth_id_list转json存储
        $data['role_auth_id_list'] = json_encode($data['role_auth_id_list']);
        $res = $admin_role->update($data);
        if ($res->id) {
            // 如果添加数据成功，则返回列表页
            return ['status' => "success", 'msg' => '更新成功'];
        }else{
            return ['status' => 'fail', 'msg' => '更新失败'];
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
