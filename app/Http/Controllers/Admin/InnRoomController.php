<?php

namespace App\Http\Controllers\Admin;

use App\Models\Admin\InnRoom;
use App\Models\Admin\Inn;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class InnRoomController extends Controller
{

    public function index(Request $request,InnRoom $innRoom)
    {
        if ($request->ajax()) {
                $data = $innRoom->select('id','room_number','inn_id','is_enable','room_type','bunk','pet_id','start_at','end_at','sort_order')->get();
            $cnt = count($data);
            $info = [
                'draw' => $request->get('draw'),
                'recordsTotal' => $cnt,
                'recordsFiltered' => $cnt,
                'data' => $data,
            ];
            return $info;
        }
        return view('admin.inn_room.index');
    }


    public function create(Inn $inn)
    {
        $data['inn'] = $inn->all();
        return view('admin.inn_room.create',$data);
    }


    public function store(Request $request,InnRoom $innRoom)
    {
        $data = $request->only('room_number','inn_id','is_enable','room_type','bunk','pet_id','sort_order');
        $role = [
            'room_number' => 'required|alpha_num|between:2,8',
            'inn_id' => 'required|exists:inn,id',
            'is_enable'  => 'required|in:0,1',
            'room_type' => 'required|in:-1,0,1,2',
            'bunk' => 'required|in:-1,0,1,2',
            'pet_id' => 'nullable|integer',
            'sort_order' => 'nullable|integer'

        ];
        $message = [
            'room_number.alpha_num' => '名称长度为2到8位字节组成',
            'room_number.between' => '名称长度为2到8位字节组成',
            'inn_id.required' => '所属门店不能为空',
            'inn_id.exists' => '所属门店不存在',
            'is_enable.required' => '所属门店不能为空',
            'is_enable.in' => '所属门店不正确',
            'room_type.required' => '房间类型不能为空',
            'room_type.in' => '房间类型不正确',
            'bunk.required' => '所属层不能为空',
            'bunk.in' => '所属层不能为空',
            'pet_id.integer' => '使用的宠物不合法',
            'sort_order.integer' => '排序权重不合法',
        ];
        $validator = Validator::make($data, $role, $message);
        if ($validator->fails()) {
            return ['status' => 'fail', 'msg' => $validator->messages()->first()];
        }
        # 验证房间号是否重名
        $res = $innRoom->where('inn_id',$data['inn_id'])->where('room_number',$data['room_number'])->first();
        if(!empty($res)){
            return ['status' => 'fail', 'msg' => '房间编号重名，请重新输入'];
        }
        $tf = $innRoom->create($data);
        if ($tf) { // 如果添加数据成功，则返回列表页

            return ['status' => "success", 'msg' => '新增成功'];
        }else{
            return ['status' => 'fail', 'msg' => '新增失败'];
        }
    }


    public function show($id)
    {
        //
    }


    public function edit(Inn $inn,InnRoom $innRoom)
    {
        $data['inn'] = $inn->all();
        $data['inn_room'] = $innRoom;
        return view('admin.inn_room.edit',$data);
    }


    public function update(Request $request,InnRoom $innRoom)
    {
        $data = $request->only('room_number','inn_id','is_enable','room_type','bunk','pet_id','sort_order');
        $role = [
            'room_number' => 'required|alpha_num|between:2,8',
            'inn_id' => 'required|exists:inn,id',
            'is_enable'  => 'required|in:0,1',
            'room_type' => 'required|in:-1,0,1,2',
            'bunk' => 'required|in:-1,0,1,2',
            'pet_id' => 'nullable|integer',
            'sort_order' => 'nullable|integer'

        ];
        $message = [
            'room_number.alpha_num' => '名称长度为2到8位字节组成',
            'room_number.between' => '名称长度为2到8位字节组成',
            'inn_id.required' => '所属门店不能为空',
            'inn_id.exists' => '所属门店不存在',
            'is_enable.required' => '所属门店不能为空',
            'is_enable.in' => '所属门店不正确',
            'room_type.required' => '房间类型不能为空',
            'room_type.in' => '房间类型不正确',
            'bunk.required' => '所属层不能为空',
            'bunk.in' => '所属层不能为空',
            'pet_id.integer' => '使用的宠物不合法',
            'sort_order.integer' => '排序权重不合法',
        ];
        $validator = Validator::make($data, $role, $message);
        if ($validator->fails()) {
            return ['status' => 'fail', 'msg' => $validator->messages()->first()];
        }
        # 验证房间号是否重名
        if($data['room_number'] != $innRoom->room_number){
            $res = $innRoom->where('inn_id',$data['inn_id'])->where('room_number',$data['room_number'])->first();
            if(!empty($res)){
                return ['status' => 'fail', 'msg' => '房间编号重名，请重新输入'];
            }
        }
        $tf = $innRoom->update($data);
        if ($tf) { // 如果添加数据成功，则返回列表页
            return ['status' => "success", 'msg' => '更新成功'];
        }else{
            return ['status' => 'fail', 'msg' => '更新失败'];
        }
    }

    public function destroy(InnRoom $innRoom)
    {
        if($innRoom->is_enable == 1){
            $tf = $innRoom->delete();
            if ($tf) { // 如果添加数据成功，则返回列表页
                return ['status' => "success", 'msg' => '删除成功'];
            }else{
                return ['status' => 'fail', 'msg' => '删除失败'];
            }
        }else{
            return ['status' => 'fail', 'msg' => '当前房间处于不可用，不能删除'];
        }

    }
}
