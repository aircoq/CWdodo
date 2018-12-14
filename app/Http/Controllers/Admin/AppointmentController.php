<?php

namespace App\Http\Controllers\Admin;

use App\Models\Admin\Appointment;
use App\Models\Admin\Food;
use App\Models\Admin\Pet;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class AppointmentController extends Controller
{
    public function index(Request $request,Appointment $appointment)
    {
        if ($request->ajax()) {
            $data =  $appointment->select('id','appointment_number','appointment_type','user_id','user_name','sex', 'user_phone', 'pet_id','is_pickup','province','city','district','address','lat','lng','from_way','start_at','end_at','food_id','provider','appointment_status','mark_up','created_at','updated_at', 'deleted_at')->get();
            $cnt = count($data);
            $info = [
                'draw' => $request->get('draw'),
                'recordsTotal' => $cnt,
                'recordsFiltered' => $cnt,
                'data' => $data,
            ];
            return $info;
        }
        return view('admin.appointment.index');
    }

    public function create(Pet $pet ,Food $food)
    {
        $data['pet'] = $pet->all();
        $data['food'] = $food->all();
        return view('admin.appointment.create',$data);
    }

    public function store(Request $request,Pet $pet,Appointment $appointment)
    {
        $data = $request->only('appointment_type','user_id','user_name','sex', 'user_phone', 'pet_id','is_pickup','province','city','district','address','from_way','start_at','end_at','food_id','mark_up');
        $role = [
            'appointment_type' => 'required|in:0,1,2',
            'user_id' => 'required|exists:user,id',
            'user_name' => 'required|string|between:2,15',
            'sex' => 'required|in:0,1',
            'user_phone'=> 'required|digits:11',
            'pet_id' => 'required|integer',
            'is_pickup' => 'required|in:0,1',
            'province' => 'nullable|required_if:is_pickup,1|string|between:2,15',
            'city' => 'nullable|required_if:is_pickup,1|string|between:2,15',
            'district' => 'nullable|required_if:is_pickup,1|string|between:2,15',
            'address' => 'nullable|required_if:is_pickup,1|string|between:3,35',
            'from_way' => 'nullable|string|between:0,50',
            'start_at' => 'required|date|after:now',
            'end_at' => 'nullable|required_if:appointment_type,0|date|after:start_at',
            'food_id' => 'nullable|required_if:appointment_type,0|exists:food,id',
            'mark_up' => 'nullable|string|between:0,200',
        ];
        $message = [
            'appointment_type.in' => '选择服务类型不正确',
            'user_id.exists' => '用户不存在',
            'user_name.required' => '用户名不能为空',
            'user_name.string' => '用户长度为2到15位的英文、数字组成',
            'user_name.between' => '用户长度为2到15位的英文、数字组成',
            'sex.in' => '性别格式不合法',
            'user_phone.required' => '手机号码不能为空',
            'user_phone.unique' => '此号码已存在，请勿重复申请',
            'user_phone.digits' => '手机号码不正确',
            'pet_id.integer' => '宠物不存在',
            'is_pickup.in' => '是否接送不合法',
            'province.between' => '省级字节超限',
            'province.required_if' => '接送地址不能空',
            'city.between' => '市级字节超限',
            'city.required_if' => '接送地址不能空',
            'district.between' => '区县级字节超限',
            'district.required_if' => '接送地址不能空',
            'address.between' => '详细地址最长为35个字节',
            'address.required_if' => '接送地址不能空',
            'from_way.between' => '预约途径最长为50个字节',
            'start_at.required' => '预约服务时间不能为空',
            'start_at.date' => '预约服务时间格式不正确',
            'end_at.required_if' => '寄养结束时间不能为空',
            'end_at.date' => '预约服务时间格式不正确',
            'end_at.after' => '寄养结束时间不能小于开始时间',
            'food_id.required_if' => '宠物食品不能为空',
            'food_id.exists' => '宠物食品不存在',
            'mark_up.string' => '备注不正确',
            'mark_up.between' => '备注最大100个字节',
        ];
        $validator = Validator::make( $data, $role, $message );
        if( $validator->fails() ){
            return ['status' => "fail", 'msg' => $validator->messages()->first()];
        }
        # 核对用户与宠物的对应关系
        $tf = $pet->where('id',$data['pet_id'])->where('user_id',$data['user_id'])->first();
        if(empty($tf)){
            return ['status' => "fail", 'msg' => '请核对填写宠物信息是否正确'];
        }
        # 如果接送 生成坐标 核对填写的地址
        if($data['is_pickup'] == 1){
            $get_adr_info = getGaoMapInfo($data['address'],$data['city']);
            if($get_adr_info){
                $lat_lng = explode(',',$get_adr_info['geocodes'][0]['location']);
                $data['lat'] = $lat_lng['0'];
                $data['lng'] = $lat_lng['1'];
                $pro = $get_adr_info['geocodes'][0]['province'];
                $city = $get_adr_info['geocodes'][0]['city'];
                $district = $get_adr_info['geocodes'][0]['district'];
            }else{
                return ['status' => "fail", 'msg' => '请求失败，请重新输入地址'];
            }
            if($data['province'] != $pro || $data['city'] != $city || $data['district'] != $district){//核对填写的地址
                return ['status' => "fail", 'msg' => '地址填写有误，重新输入或联系客服'];
            }
        }
        # 生成预约编号 appointment_number
        $data['appointment_number'] =  date('Ymd').uniqid();
        # 转换时间戳
        $data['start_at'] = strtotime($data['start_at']);
        if($data['appointment_type'] != 0){ //如果是寄养
            unset($data['end_at']);
            unset($data['food_id']);
        }else{
            $data['end_at'] = strtotime($data['end_at']);
        }
        $res = $appointment->create($data);
        if ($res) { // 如果添加数据成功，则返回列表页
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
        $data = $request->only('appointment_type','user_id','user_name','sex', 'user_phone', 'pet_id','is_pickup','province','city','district','address','from_way','start_at','end_at','food_id','provider','appointment_status','mark_up');//'appointment_number','lat','lng',
    }

    public function destroy(Appointment $appointment)
    {
        $res = $appointment->delete();
        if ($res) {
            return ['status' => "success", 'msg' => '删除成功'];
        }else{
            return ['status' => 'fail', 'msg' => '删除失败'];
        }
    }
}
