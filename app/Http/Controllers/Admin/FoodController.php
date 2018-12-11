<?php

namespace App\Http\Controllers\Admin;

use App\Models\Admin\Food;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class FoodController extends Controller
{
    public function index()
    {
        return view('admin.food.index');
    }

    public function create()
    {
        return view('admin.food.create');
    }

    public function store(Request $request,Food $food)
    {
        $data = $request->only('food_name','food_category','food_age','price', 'sort_order','mark_up');
        $role = [
            'food_name' => 'required|string|between:1,15',
            'food_category' => 'required|in:0,1,2',
            'food_age' => 'required|in:0,1,2,3',
            'price' => 'required|numeric|min:0',
            'sort_order' => 'nullable|integer',
            'mark_up' => 'nullable|string|between:0,200'
        ];
        $message = [
            'food_name.required' => '名称不能为空',
            'food_name.string' => '名称长度为1到15位字节组成',
            'food_name.between' => '名称长度为1到15位字节组成',
            'appointment_type.in' => '选择服务类型不正确',
            'price.numeric' => '每天单价有误',
            'price.min' => '每天单价不能小于0',
            'mark_up.string' => '备注不正确',
            'mark_up.between' => '备注最大200个字节',
        ];
        $validator = Validator::make( $data, $role, $message );
        if( $validator->fails() ){
            return ['status' => "fail", 'msg' => $validator->messages()->first()];
        }
        $res = $food->create($data);
        if ($res) {
            return ['status' => "success", 'msg' => '预约成功'];
        }else{
            return ['status' => 'fail', 'msg' => '预约失败'];
        }
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}
