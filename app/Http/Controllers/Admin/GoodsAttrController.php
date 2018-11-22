<?php

namespace App\Http\Controllers\Admin;

use App\Models\Admin\GoodsAttr;
use App\Models\Admin\GoodsType;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class GoodsAttrController extends Controller
{
    public function index(Request $request ,GoodsAttr $goodsAttr)
    {
        if ($request->ajax()) {
            $data = $goodsAttr->select('id','attr_name','type_id','attr_type','attr_input_type','attr_values','sort_order','note','is_linked','deleted_at')->get();
            $cnt = count($data);
            $info = [
                'draw' => $request->get('draw'),
                'recordsTotal' => $cnt,
                'recordsFiltered' => $cnt,
                'data' => $data,
            ];
            return $info;
        }
        return view('admin.goods_attr.index');
    }
    
    public function create(GoodsType $goodsType)
    {
        $data['goods_type'] = $goodsType->all();
        return view('admin.goods_attr.create',$data);
    }

    public function store(Request $request,GoodsAttr $goodsAttr)
    {
        $data = $request->only('attr_name','type_id','attr_type','attr_input_type','attr_values','sort_order','note');
        $role = [
            'attr_name' => 'required|string|between:2,8',
            'type_id' => 'required|exists:goods_type,id',
            'attr_type'=> 'in:0,1',
            'attr_input_type'=> 'in:0,1',
            'attr_values' => 'nullable|required_unless:attr_input_type,0|required_if:attr_input_type,1|string',
            'sort_order' => 'nullable|integer',
            'note' => 'nullable|string',
        ];
        $message = [
            'role_name.string' => '名称长度为2到8位字节组成',
            'role_name.between' => '名称长度为2到8位字节组成',
            'type_id.exists' => '类型不存在',
            'attr_type.in'=> '属性类型不正确',
            'attr_input_type.in'=> '录入方式不正确',
            'attr_values.required_unless' => '当前属性可选值不能填写',
            'attr_values.required_if' => '当前属性可选值不能为空',
            'sort_order.integer' => '排序值必须为整型',
            'note.string' => '描述的值必须为字符串格式'
        ];
        $validator = Validator::make($data, $role, $message);
        if ($validator->fails()) {
            return ['status' => 'fail', 'msg' => $validator->messages()->first()];
        }
        $res = $goodsAttr->create($data);
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
    public function edit(GoodsAttr $goodsAttr,GoodsType $goodsType)
    {
        $data['goods_attr'] = $goodsAttr;
        $data['goods_type'] = $goodsType->all();
//        dump(objArr($data));die();
        return view('admin.goods_attr.edit',$data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,GoodsAttr $goodsAttr)
    {
        $data = $request->only('attr_name','type_id','attr_type','attr_input_type','attr_values','sort_order','note');
        $role = [
            'attr_name' => 'required|string|between:2,8',
            'type_id' => 'required|exists:goods_type,id',
            'attr_type'=> 'in:0,1',
            'attr_input_type'=> 'in:0,1',
            'attr_values' => 'nullable|required_unless:attr_input_type,0|required_if:attr_input_type,1|string',
            'sort_order' => 'nullable|integer',
            'note' => 'nullable|string',
        ];
        $message = [
            'role_name.string' => '名称长度为2到8位字节组成',
            'role_name.between' => '名称长度为2到8位字节组成',
            'type_id.exists' => '类型不存在',
            'attr_type.in'=> '属性类型不正确',
            'attr_input_type.in'=> '录入方式不正确',
            'attr_values.required_unless' => '当前属性可选值不能填写',
            'attr_values.required_if' => '当前属性可选值不能为空',
            'sort_order.integer' => '排序值必须为整型',
            'note.string' => '描述的值必须为字符串格式'
        ];
        $validator = Validator::make($data, $role, $message);
        if ($validator->fails()) {
            return ['status' => 'fail', 'msg' => $validator->messages()->first()];
        }
        $res = $goodsAttr->update($data);
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
    public function destroy(GoodsAttr $goodsAttr)
    {
        $tf = $goodsAttr->delete();
        if ($tf) {
            // 如果添加数据成功，则返回列表页
            return ['status' => "success", 'msg' => '删除成功'];
        }else{
            return ['status' => 'fail', 'msg' => '删除失败'];
        }
    }

    /**
     * 回复软删除
     * @param Request $request
     * @param GoodsType $goodsType
     * @return array
     */
    public function re_store(Request $request,GoodsAttr $goodsAttr)
    {
        if ($request->ajax()) {
            $id = $request->only('id');
            $tf = $goodsAttr->where('id', $id['id'])->restore();
            if ($tf) {
                // 如果添加数据成功，则返回列表页
                return ['status' => "success", 'msg' => '删除成功'];
            } else {
                return ['status' => 'fail', 'msg' => '删除失败'];
            }
        }
    }
}
