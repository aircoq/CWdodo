<?php

namespace App\Http\Controllers\Admin;

use App\Models\Admin\Role;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Models\Admin\Auth as RoleAuth;
use App\Models\Admin\RoleAuthRelated;
use Illuminate\Support\Facades\DB;

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
            $data = $role->select('id','role_name','note','created_at', 'deleted_at')->withTrashed()->get();
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
    public function create(RoleAuth $auth )
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
    public function store(Request $request,Role $adminRole ,RoleAuthRelated $authRelated)
    {
        $data = $request->only('role_name','note','auth_id_list');
        $role = [
            'role_name' => 'required|alpha_num|between:2,8|unique:role',
            'auth_id_list' => 'required|array',
            'note' => 'nullable|string',

        ];
        $message = [
            'role_name.alpha_num' => '名称长度为2到8位字节组成',
            'role_name.between' => '名称长度为2到8位字节组成',
            'role_name.unique' => '角色名重复',
            'auth_id_list.required' => '权限不能为空',
            'auth_id_list.array' => '权限列表格式不正确',
            'note.string' => '描述的值必须为字符串格式'
        ];
        $validator = Validator::make($data, $role, $message);
        if ($validator->fails()) {
            return ['status' => 'fail', 'msg' => $validator->messages()->first()];
        }
        # auth_id_list处理 关联角色和权限
        $auth_id_list = $data['auth_id_list'];
        unset($data['auth_id_list']);
        # 开启事务处理
        DB::beginTransaction();
        try{
            $tf1 = $adminRole->create($data);
            $tf2 = true;
            foreach ($auth_id_list as $v){
                $tf = $authRelated->create( ['role_id' => $tf1->id , 'auth_id' => $v ]);
                if(!$tf){
                    $tf2 = false;
                    break;
                }
            }
            if ($tf1 && $tf2) {
                DB::commit();
            }
        }catch(\Illuminate\Database\QueryException $ex){
            DB::rollback();//事务回滚
            return ['status' => 'fail', 'msg' => '添加失败'];
        }
        return ['status' => "success", 'msg' => '添加成功'];
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
    public function edit(Role $role,RoleAuth $auth,RoleAuthRelated $authRelated)
    {
        $data['role'] = $role;
        $data['auth'] = $auth->all();
        $auth_list = $authRelated->where('role_id',$role->id)->get();
        $data['auth_list'] = [];
        foreach (objArr($auth_list) as $v){
            $data['auth_list'][] += $v['auth_id'];
        }
        return view('admin.role.edit',$data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Role $role ,RoleAuthRelated $authRelated)
    {
        $data = $request->only('role_name','note','auth_id_list');
        $rules = [
            'role_name' => 'required|alpha_num|between:2,8|unique:role,role_name,'.$role->id,
            'auth_id_list' => 'required|array',
            'note' => 'nullable|string',

        ];
        $message = [
            'role_name.alpha_num' => '名称长度为2到8位字节组成',
            'role_name.between' => '名称长度为2到8位字节组成',
            'role_name.unique' => '角色名重复',
            'auth_id_list.required' => '权限不能为空',
            'auth_id_list.array' => '角色列表格式不正确',
            'note.string' => '描述的值必须为字符串格式'
        ];
        $validator = Validator::make($data, $rules, $message);
        if ($validator->fails()) {
            return ['status' => 'fail', 'msg' => $validator->messages()->first()];
        }
        # auth_id_list处理 关联角色和权限
        $auth_id_list = $data['auth_id_list'];
        unset($data['auth_id_list']);
        # 开启事务处理
        DB::beginTransaction();
        try{
            $tf1 = $role->update($data);
            $tf2 = true;
            if(!$authRelated->where('role_id',$role->id)->get()->isEmpty()){//用户权限表记录不为空则先删除
                $tf2 = $authRelated->where('role_id',$role->id)->forceDelete();
            }
            $tf3 = true;
            foreach ($auth_id_list as $v){
                $tf = $authRelated->create( ['role_id' => $role->id , 'auth_id' => $v ]);
                if(!$tf){
                    $tf3 = false;
                    break;
                }
            }
            if ($tf1 && $tf2 && $tf3) {
                DB::commit();
            }
        }catch(\Illuminate\Database\QueryException $ex){
            DB::rollback();//事务回滚
            return ['status' => 'fail', 'msg' => '添加失败'];
        }
        return ['status' => "success", 'msg' => '添加成功'];
    }

    /**
     * 删除角色（软删除）
     */
    public function destroy(Role $role,RoleAuthRelated $authRelated)
    {
        DB::beginTransaction();
        try{
            $tf1 = $role->delete();
            $tf2 = $authRelated->where('role_id',$role->id)->delete();
            if ($tf1 && $tf2) {
                DB::commit();
            }
        }catch(\Illuminate\Database\QueryException $ex){
            DB::rollback();//事务回滚
            return ['status' => 'fail', 'msg' => '删除失败'];
        }
        return ['status' => "success", 'msg' => '删除成功'];
    }

    /**
     * 恢复软删除
     */
    public function re_store(Request $request,Role $role,RoleAuthRelated $authRelated)
    {
        if ($request->ajax()) {
            $id = $request->only('id');
            DB::beginTransaction();
            try{
                $tf1 = $role->where('id', $id['id'])->restore();
                $tf2 = $authRelated->where('role_id',$id['id'])->restore();
                if ($tf1 && $tf2) {
                    DB::commit();
                }
            }catch(\Illuminate\Database\QueryException $ex){
                DB::rollback();//事务回滚
                return ['status' => 'fail', 'msg' => '恢复失败'];
            }
            return ['status' => "success", 'msg' => '恢复成功'];
        }
    }
}
