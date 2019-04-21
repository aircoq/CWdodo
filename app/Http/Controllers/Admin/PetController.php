<?php

namespace App\Http\Controllers\Admin;

use App\Models\Admin\Pet;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class PetController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data =  DB::table('pet')->select('id','user_id','pet_thumb','male','pet_name','pet_category','varieties','height','weight','color','status','star','birthday','born_where','room_id','pet_desc','created_at','updated_at')->get();
            $cnt = count($data);
            $info = [
                'draw' => $request->get('draw'),
                'recordsTotal' => $cnt,
                'recordsFiltered' => $cnt,
                'data' => $data,
            ];
            return $info;
        }
        return view('admin.pet.index');
    }

    public function create()
    {
        return view('admin.pet.create');
    }


    public function store(Request $request ,Pet $pet)
    {
        $data = $request->only('session_key','user_id','pet_name','male','pet_category','varieties','height','weight','color','status','star','birthday','born_where','room_id','pet_thumb','pet_desc');
        $role = [
            'session_key' => 'required_without:user_id|string',
            'user_id' => 'required_without:session_key|exists:user,id',
            'pet_name' => 'required|string|between:2,12',
            'male' => 'required|in:0,1,2',
            'pet_category' => 'required|in:0,1,2',
            'varieties' => 'nullable|string|between:0,15',
            'height' => 'nullable|integer|between:0,120',
            'weight' => 'required|integer|between:0,120',
            'color' => 'nullable|string|between:0,15',
            'status' => 'nullable|in:-1,0,1',
            'star' => 'nullable|integer|between:0,10',
            'birthday' => 'required|date',
            'born_where' => 'nullable|string|between:0,15',
            'room_id' => 'nullable|exists:inn_room,id',
            'pet_thumb'   => 'required|file|image|mimes:png,gif,jpeg,jpg|max:600|dimensions:width=800,height=800',
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
            'pet_thumb.required'      => '图片不能为空！',
            'pet_thumb.file'      => '图片上传失败！',
            'pet_thumb.image'     => '必须是图片格式！',
            'pet_thumb.mimes'     => '图片格式不正确！',
            'pet_thumb.max'       => '图片最大500K',
            'pet_thumb.dimensions' => '图片宽高各为800',
            'pet_desc.string' => '描述不正确',
            'pet_desc.between' => '描述最大100个字节',
        ];
        $validator = Validator::make( $data, $role, $message );
        if( $validator->fails() ){
            return ['status' => "0", 'msg' => $validator->messages()->first()];
        }
        $tf = uploadPic('pet_thumb','uploads/backend/pet/'.date('Ymd'));
        if($tf){
            $data['pet_thumb'] = $tf;
        }else{
            return ['status' => "0", 'msg' => '网络故障，图片上传失败'];
        }
        if(empty($data['user_id'])){
            $user_now = Redis::get($data['session_key']);
            $user_now = json_decode($user_now,true);
            $data['user_id'] = $user_now['id'];
        }
        $res = $pet->create($data);
        if ($res) {
            return ['status' => "1", 'msg' => '添加成功'];
        }else{
            return ['status' => '0', 'msg' => '添加失败'];
        }
    }

    public function show(Pet $pet,Request $request)
    {
        $pet = $pet->where('id',$request['pet_id'])->first();
        if(empty($pet)){
            return ['status' => '0', 'msg' => '网络故障，稍后再试'];
        }else{
            return json_encode(['status' => "1", 'msg' => '查询成功',"data" => $pet], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        }

    }

    public function edit(Pet $pet)
    {
        $data['pet'] = $pet;
        return view('admin.pet.edit',$data);
    }

    public function update(Request $request, Pet $pet)
    {
        $data = $request->only('user_id','pet_name','male','pet_category','varieties','height','weight','color','status','star','birthday','born_where','room_id','pet_thumb','pet_desc');
        $role = [
            'session_key' => 'required_without:user_id|string',
            'user_id' => 'required_without:session_key|exists:user,id',
            'pet_name' => 'required|string|between:2,12',
            'male' => 'required|in:0,1,2',
            'pet_category' => 'required|in:0,1,2',
            'varieties' => 'nullable|string|between:0,15',
            'height' => 'nullable|integer|between:0,120',
            'weight' => 'required|integer|between:0,120',
            'color' => 'nullable|string|between:0,15',
            'status' => 'nullable|in:-1,0,1',
            'star' => 'nullable|integer|between:0,10',
            'birthday' => 'required|date',
            'born_where' => 'nullable|string|between:0,15',
            'room_id' => 'nullable|exists:inn_room,id',
            'pet_thumb'   => 'required|file|image|mimes:png,gif,jpeg,jpg|max:600|dimensions:width=800,height=800',
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
            'pet_thumb.file'      => '图片上传失败！',
            'pet_thumb.image'     => '必须是图片格式！',
            'pet_thumb.mimes'     => '图片格式不正确！',
            'pet_thumb.max'       => '图片最大500K',
            'pet_thumb.dimensions' => '图片宽高各为800',
            'pet_desc.string' => '描述不正确',
            'pet_desc.between' => '描述最大100个字节',
        ];
        $validator = Validator::make( $data, $role, $message );
        if( $validator->fails() ){
            return ['status' => "fail", 'msg' => $validator->messages()->first()];
        }
        if(!empty($data['pet_thumb'])){
            $tf = uploadPic('pet_thumb','uploads/backend/pet/'.date('Ymd'));
            if($tf){
                $data['pet_thumb'] = $tf;
            }else{
                return ['status' => "fail", 'msg' => '网络故障，图片上传失败'];
            }
        }
        if(empty($data['user_id'])){
            $user_now = Redis::get($data['session_key']);
            $user_now = json_decode($user_now,true);
            $data['user_id'] = $user_now['id'];
        }
        $res = $pet->update($data);
        if ($res) {
            return ['status' => "success", 'msg' => '更新成功'];
        }else{
            return ['status' => 'fail', 'msg' => '更新失败'];
        }
    }
    public function wechatUpdate(Request $request, Pet $pet)
    {
        $data = $request->only('pet_id','session_key','pet_name','male','pet_category','varieties','height','weight','color','status','star','birthday','born_where','room_id','pet_thumb','pet_desc');
        $role = [
            'pet_id' => 'required|integer',
            'session_key' => 'required|string',
            'pet_name' => 'required|string|between:2,12',
            'male' => 'required|in:0,1,2',
            'pet_category' => 'required|in:0,1,2',
            'varieties' => 'required|string|between:0,15',
            'height' => 'nullable|integer|between:0,120',
            'weight' => 'required|integer|between:0,120',
            'color' => 'nullable|string|between:0,15',
            'status' => 'nullable|in:-1,0,1',
            'star' => 'nullable|integer|between:0,10',
            'birthday' => 'required|date',
            'born_where' => 'nullable|string|between:0,15',
            'room_id' => 'nullable|exists:inn_room,id',
//            'pet_thumb'   => 'string',
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
//            'pet_thumb.file'      => '图片上传失败！',
//            'pet_thumb.image'     => '必须是图片格式！',
//            'pet_thumb.mimes'     => '图片格式不正确！',
//            'pet_thumb.max'       => '图片最大500K',
//            'pet_thumb.dimensions' => '图片宽高各为800',
            'pet_desc.string' => '描述不正确',
            'pet_desc.between' => '描述最大100个字节',
        ];
        $validator = Validator::make( $data, $role, $message );
        if( $validator->fails() ){
            return ['status' => "0", 'msg' => $validator->messages()->first()];
        }
//        if(!empty($data['pet_thumb'])){
//            $tf = uploadPic('pet_thumb','uploads/backend/pet/'.date('Ymd'));
//            if($tf){
//                $data['pet_thumb'] = $tf;
//            }else{
//                return ['status' => "0", 'msg' => '网络故障，图片上传失败'];
//            }
//        }
        # 验证用户权限
        $user_now = json_decode(Redis::get($data['session_key']),true);//获取API用户信息
        $tf = $pet->where('user_id',$user_now['id'])->where('id',$data['pet_id'])->first();
        if(empty($tf)){
            return ['status' => '0', 'msg' => '请输入正确的宠物关系'];
        }
//        if(empty($data['pet_thumb'])){
//            unset($data['pet_thumb']);
//        }
        $res = $pet->update($data);
        if ($res) {
            return ['status' => "1", 'msg' => '更新成功'];
        }else{
            return ['status' => '0', 'msg' => '更新失败'];
        }
    }
    public function destroy(Pet $pet)
    {
        $res = $pet->delete();
        if ($res) {
            // 如果添加数据成功，则返回列表页
            return ['status' => "success", 'msg' => '删除成功'];
        }else{
            return ['status' => 'fail', 'msg' => '删除失败'];
        }
    }
    public function wechatDestroy(Request $request ,Pet $pet)
    {
        # 验证用户权限
        $user_now = json_decode(Redis::get($request['session_key']),true);//获取API用户信息
        $tf = $pet->where('user_id',$user_now['id'])->where('id',$request['pet_id'])->first();
        if(empty($tf)){
            return ['status' => '0', 'msg' => '请输入正确的宠物关系'];
        }
        $res = $pet->delete();
        if ($res) {
            // 如果添加数据成功，则返回列表页
            return ['status' => "1", 'msg' => '删除成功'];
        }else{
            return ['status' => '0', 'msg' => '删除失败'];
        }
    }

    public function updatePetImg(Request $request, Pet $pet)
    {
        $data = $request->only('pet_id','session_key','pet_thumb');
        $role = [
            'pet_id' => 'required|integer',
            'session_key' => 'required|string',
            'pet_thumb'   => 'required|string',
        ];
        $message = [
            'pet_id.required' => '请选择要更新的宠物',
            'pet_thumb.required' => '图片地址不能为空',
        ];
        $validator = Validator::make( $data, $role, $message );
        if( $validator->fails() ){
            return ['status' => "0", 'msg' => $validator->messages()->first()];
        }

        # 验证用户权限
        $user_now = json_decode(Redis::get($data['session_key']),true);//获取API用户信息
        $tf = $pet->where('user_id',$user_now['id'])->where('id',$data['pet_id'])->first();
        if(empty($tf)){
            return ['status' => '0', 'msg' => '请输入正确的宠物关系'];
        }

        $res = $pet->where('id',$data['pet_id'])->update($data);
        if ($res) {
            return ['status' => "1", 'msg' => '上传成功'];
        }else{
            return ['status' => '0', 'msg' => '上传失败'];
        }
    }

}
