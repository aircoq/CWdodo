<?php

namespace App\Http\Controllers\Admin;

use App\Models\Admin\Service;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class ServiceController extends Controller
{
    public function index(Request $request, Service $service)
    {
        if ($request->ajax()) {
            $data = $service->select('id','service_name','pet_category','service_thumb','is_on_sale','market_price','shop_price','sort_order','updated_at', 'deleted_at')->withTrashed()->get();
            $cnt = count($data);
            $info = [
                'draw' => $request->get('draw'),
                'recordsTotal' => $cnt,
                'recordsFiltered' => $cnt,
                'data' => $data,
            ];
            return $info;
        }
        return view('admin.service.index');
    }

    public function create()
    {
        return view('admin.service.create');
    }


    public function store(Request $request,Service $service)
    {
        $data = $request->only('service_name','pet_category','is_on_sale','market_price','shop_price','sort_order','service_thumb');
        $role = [
            'service_name' => 'required|string|between:1,15',
            'pet_category' => 'required|in:0,1,2',
            'is_on_sale' => 'required|in:0,1',
            'market_price' => 'required|numeric|min:0',
            'shop_price' => 'required|numeric|min:0',
            'sort_order' => 'nullable|integer',
            'service_thumb' => 'required|file|image|mimes:png,gif,jpeg,jpg|max:550|dimensions:width=800,height=800',
        ];
        $message = [
            'service_name.required' => '名称不能为空',
            'service_name.string' => '名称长度为1到15位字节组成',
            'service_name.between' => '名称长度为1到15位字节组成',
            'pet_category.required' => '适用宠物不能为空',
            'pet_category.in' => '适用宠物不合法',
            'market_price.numeric' => '市场价有误',
            'shop_price.numeric' => '本店售价有误',
            'is_on_sale.in' => '是否在售数据有误',
            'sort_order.integer' => '排序字段必须为整数',
            'service_thumb.required' => '图片不能为空',
            'service_thumb.mimes' => '图片1格式为png,gif,jpeg,jpg',
            'service_thumb.max' => '图片1不超过550kb',
            'service_thumb.dimensions' => '图片1宽高各为800',
        ];
        $validator = Validator::make($data, $role, $message);
        if ($validator->fails()) {
            return ['status' => 'fail', 'msg' => $validator->messages()->first()];
        }
        $tf = uploadPic('service_thumb','uploads/backend/service/'.date('Ymd'),date('Ymd').uniqid());
        if($tf){
            $data['service_thumb'] = $tf;
        }else{
            return ['status' => "fail", 'msg' => '图片添加失败'];
        }
        $tf = $service->create($data);
        if ($tf->id) {
            return ['status' => 'success','msg' => '新增成功！',"id" => $tf->id];
        } else {
            @unlink($tf);
            return ['status' => 'fail', 'msg' => '新增失败！'];
        }
    }

    public function show($id)
    {
        //
    }

    public function edit(Service $service)
    {
        $data['service'] = $service;//当前记录
        return view('admin.service.edit',$data);
    }


    public function update(Request $request,Service $service)
    {
        $data = $request->only('service_name','pet_category','is_on_sale','market_price','shop_price','sort_order','service_thumb');
        $role = [
            'service_name' => 'nullable|string|between:1,15',
            'pet_category' => 'nullable|in:0,1,2',
            'is_on_sale' => 'nullable|in:0,1',
            'market_price' => 'nullable|numeric|min:0',
            'shop_price' => 'nullable|numeric|min:0',
            'sort_order' => 'nullable|integer',
            'service_thumb' => 'nullable|file|image|mimes:png,gif,jpeg,jpg|max:550|dimensions:width=800,height=800',
        ];
        $message = [
            'service_name.required' => '名称不能为空',
            'service_name.string' => '名称长度为1到15位字节组成',
            'service_name.between' => '名称长度为1到15位字节组成',
            'pet_category.required' => '适用宠物不能为空',
            'pet_category.in' => '适用宠物不合法',
            'market_price.numeric' => '市场价有误',
            'shop_price.numeric' => '本店售价有误',
            'is_on_sale.in' => '是否在售数据有误',
            'sort_order.integer' => '排序字段必须为整数',
            'service_thumb.mimes' => '图片1格式为png,gif,jpeg,jpg',
            'service_thumb.max' => '图片1不超过550kb',
            'service_thumb.dimensions' => '图片1宽高各为800',
        ];
        $validator = Validator::make($data, $role, $message);
        if ($validator->fails()) {
            return ['status' => 'fail', 'msg' => $validator->messages()->first()];
        }
        if(! empty($data['service_thumb'])){
            $tf = uploadPic('service_thumb','uploads/backend/service/'.date('Ymd'),date('Ymd').uniqid());
            if($tf){
                $data['service_thumb'] = $tf;
            }else{
                return ['status' => "fail", 'msg' => '图片添加失败'];
            }
        }else{
            unset($data['service_thumb']);
        }
        $tf = $service->update($data);
        if ($tf) {
            return ['status' => 'success','msg' => '修改成功！'];
        } else {
            @unlink($tf);
            return ['status' => 'fail', 'msg' => '修改失败！'];
        }
    }

    /**
     * 软删除
     */
    public function destroy(Service $service)
    {
        $res = $service->delete();
        if ($res) {
            // 如果添加数据成功，则返回列表页
            return ['status' => "success", 'msg' => '删除成功'];
        }else{
            return ['status' => 'fail', 'msg' => '删除失败'];
        }
    }

    /**
     * 恢复软删除（超级管理员权限）
     */
    public function re_store(Request $request,Service $service)
    {
        if ($request->ajax()) {
            $id = $request->only('id')['id'];
            $res = $service->where('id', $id)->restore();
            if ($res) {
                return ['status' => 'success','msg' => '恢复成功！'];
            } else {
                return ['status' => 'fail', 'msg' => '恢复失败！'];
            }
        }
    }
}
