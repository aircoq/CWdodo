<?php

namespace App\Http\Controllers\Admin;

use App\Models\Admin\GoodsType;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class GoodsTypeController extends Controller
{
    public function index()
    {
        return view('admin.goods_type.index');
    }

    public function ajaxList(Request $request ,GoodsType $goodsType)
    {
        if ($request->ajax()) {
            $data = $goodsType->select('id','type_name','mark_up','deleted_at')->withTrashed()->get();
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

    public function create()
    {
        return view('admin.goods_type.create');
    }

    public function store(Request $request,GoodsType $goodsType)
    {
        $data = $request->only('type_name','mark_up');
        $role = [
            'type_name' => 'required|string|between:2,8|unique:goods_type',
            'mark_up' => 'nullable|string',

        ];
        $message = [
            'role_name.string' => '名称长度为2到8位字节组成',
            'role_name.between' => '名称长度为2到8位字节组成',
            'role_name.unique' => '角色名重复',
            'note.string' => '描述的值必须为字符串格式'
        ];
        $validator = Validator::make($data, $role, $message);
        if ($validator->fails()) {
            return ['status' => 'fail', 'msg' => $validator->messages()->first()];
        }
        $res = $goodsType->create($data);
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
    public function edit(GoodsType $goodsType)
    {
        $data['goods_type'] = $goodsType;
        return view('admin.goods_type.edit',$data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,GoodsType $goodsType)
    {
        $data = $request->only('type_name','mark_up');
        $role = [
            'type_name' => 'required|string|between:2,8|unique:goods_type,type_name,'.$goodsType->id,
            'mark_up' => 'nullable|string',

        ];
        $message = [
            'role_name.string' => '名称长度为2到8位字节组成',
            'role_name.between' => '名称长度为2到8位字节组成',
            'role_name.unique' => '角色名重复',
            'note.string' => '描述的值必须为字符串格式'
        ];
        $validator = Validator::make($data, $role, $message);
        if ($validator->fails()) {
            return ['status' => 'fail', 'msg' => $validator->messages()->first()];
        }
        $res = $goodsType->update($data);
        if ($res) {
            // 如果添加数据成功，则返回列表页
            return ['status' => "success", 'msg' => '更新成功'];
        }else{
            return ['status' => 'fail', 'msg' => '更新失败'];
        }
    }

    /**
     *
     */
    public function destroy(GoodsType $goodsType)
    {
        $tf = $goodsType->delete();
        if ($tf) {
            // 如果添加数据成功，则返回列表页
            return ['status' => "success", 'msg' => '删除成功'];
        }else{
            return ['status' => 'fail', 'msg' => '删除失败'];
        }
    }

    public function re_store(Request $request,GoodsType $goodsType)
    {
        if ($request->ajax()) {
            $id = $request->only('id');
            $tf = $goodsType->where('id', $id['id'])->restore();
            if ($tf) {
                // 如果添加数据成功，则返回列表页
                return ['status' => "success", 'msg' => '删除成功'];
            } else {
                return ['status' => 'fail', 'msg' => '删除失败'];
            }
        }
    }


}
