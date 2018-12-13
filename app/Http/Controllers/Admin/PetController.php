<?php

namespace App\Http\Controllers\Admin;

use App\Models\Admin\Pet;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class PetController extends Controller
{
    public function index()
    {
        return view('admin.pet.index');
    }

    public function create()
    {
        return view('admin.pet.create');
    }

    public function store(Request $request ,Pet $pet)
    {
        $data = $request->only('user_id','pet_name','male','pet_category','varieties','height','weight','color','status','star','birthday','born_where','room_id','pet_thump','pet_desc');
        $role = [
            'user_id' => 'required|exists:user,id',
            'pet_name' => 'required|string|between:2,12',
            'male' => 'required|in:0,1,2',
            'pet_category' => 'required|in:0,1,2',
            'varieties' => 'nullable|string|between:0,15',
            'height' => 'nullable|integer|between:0,120',
            'weight' => 'nullable|integer|between:0,120',
            'color' => 'required|string|between:0,15',
            'status' => 'required|in:-1,0,1',
            'star' => 'required|integer|between:0,10',
            'birthday' => 'required|date',
            'born_where' => 'nullable|string|between:0,15',
            'room_id' => 'nullable|exists:inn_room,id',
            'pet_thump'   => 'required|file|image|mimes:png,gif,jpeg,jpg|max:600|dimensions:width=800,height=800',
            'pet_desc' => 'nullable|string|between:0,100',
        ];
        $message = [
            'pet_name.required' => '用户名不能为空',
            'pet_name.between' => '用户长度为2到12位字节组成',
            'male.in' => '性别格式不合法',
            'pet_category.in' => '宠物分类不合法',
            'varieties.between' => '宠物品种不能超过15个字节',
            'height.between' => '宠物身高最大为120cm',
            'weight.between' => '宠物体重最大为120kg',
            'color.between' => '色系不能超过15个字节',
            'status.in' => '状态不合法',
            'star.between' => '满星位10颗星',
            'birthday.date' => '生日格式不正确',
            'born_where.between' => '产物产地不能超过15个字节',
            'room_id.exists' => '房间不存在',
            'pet_thump.required'      => '图片不能为空！',
            'pet_thump.file'      => '图片上传失败！',
            'pet_thump.image'     => '必须是图片格式！',
            'pet_thump.mimes'     => '图片格式不正确！',
            'pet_thump.max'       => '图片最大500K',
            'pet_thump.dimensions' => '图片宽高各为800',
            'pet_desc.string' => '描述不正确',
            'pet_desc.between' => '描述最大100个字节',
        ];
        $validator = Validator::make( $data, $role, $message );
        if( $validator->fails() ){
            return ['status' => "fail", 'msg' => $validator->messages()->first()];
        }
        $tf = uploadPic('pet_thump','uploads/backend/pet/'.date('Ymd'));
        if($tf){
            $goods_img[] = $tf;
        }else{
            return ['status' => "fail", 'msg' => '网络故障，图片上传失败'];
        }
        $res = $pet->create($data);
        if ($res) {
            return ['status' => "success", 'msg' => '添加成功'];
        }else{
            return ['status' => 'fail', 'msg' => '添加失败'];
        }
    }

    public function show($id)
    {
        //
    }

    public function edit(Pet $pet)
    {
        $data['pet'] = $pet;
        return view('admin.pet.edit',$data);
    }

    public function update(Request $request, Pet $pet)
    {
        $data = $request->only('user_id','pet_name','male','pet_category','varieties','height','weight','color','status','star','birthday','born_where','room_id','pet_thump','pet_desc');
        $role = [
            'user_id' => 'required|exists:user,id',
            'pet_name' => 'required|string|between:2,12',
            'male' => 'required|in:0,1,2',
            'pet_category' => 'required|in:0,1,2',
            'varieties' => 'nullable|string|between:0,15',
            'height' => 'nullable|integer|between:0,120',
            'weight' => 'nullable|integer|between:0,120',
            'color' => 'required|string|between:0,15',
            'status' => 'required|in:-1,0,1',
            'star' => 'required|integer|between:0,10',
            'birthday' => 'required|date',
            'born_where' => 'nullable|string|between:0,15',
            'room_id' => 'nullable|exists:inn_room,id',
            'pet_thump'   => 'required|file|image|mimes:png,gif,jpeg,jpg|max:600|dimensions:width=800,height=800',
            'pet_desc' => 'nullable|string|between:0,100',
        ];
        $message = [
            'pet_name.required' => '用户名不能为空',
            'pet_name.between' => '用户长度为2到12位字节组成',
            'male.in' => '性别格式不合法',
            'pet_category.in' => '宠物分类不合法',
            'varieties.between' => '宠物品种不能超过15个字节',
            'height.between' => '宠物身高最大为120cm',
            'weight.between' => '宠物体重最大为120kg',
            'color.between' => '色系不能超过15个字节',
            'status.in' => '状态不合法',
            'star.between' => '满星位10颗星',
            'birthday.date' => '生日格式不正确',
            'born_where.between' => '产物产地不能超过15个字节',
            'room_id.exists' => '房间不存在',
            'pet_thump.required'      => '图片不能为空！',
            'pet_thump.file'      => '图片上传失败！',
            'pet_thump.image'     => '必须是图片格式！',
            'pet_thump.mimes'     => '图片格式不正确！',
            'pet_thump.max'       => '图片最大500K',
            'pet_thump.dimensions' => '图片宽高各为800',
            'pet_desc.string' => '描述不正确',
            'pet_desc.between' => '描述最大100个字节',
        ];
        $validator = Validator::make( $data, $role, $message );
        if( $validator->fails() ){
            return ['status' => "fail", 'msg' => $validator->messages()->first()];
        }
        $tf = uploadPic('pet_thump','uploads/backend/pet/'.date('Ymd'));
        if($tf){
            $goods_img[] = $tf;
        }else{
            return ['status' => "fail", 'msg' => '网络故障，图片上传失败'];
        }
        $res = $pet->update($data);
        if ($res) {
            return ['status' => "success", 'msg' => '更新成功'];
        }else{
            return ['status' => 'fail', 'msg' => '更新失败'];
        }
    }

    public function destroy($id)
    {
        //
    }
}
