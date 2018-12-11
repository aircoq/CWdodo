<?php

namespace App\Http\Controllers\Admin;

use App\Models\Admin\Appointment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AppointmentController extends Controller
{
    public function index()
    {
        return view('admin.appointment.index');
    }

    public function create()
    {
        return view('admin.appointment.create');
    }

    public function store(Request $request,Appointment $appointment)
    {
        $data = $request->only('appointment_type','user_id','user_name','sex', 'user_phone', 'pet_id','is_pickup','province','city','district','address','from_way','start_at','end_at','food_id','provider','appointment_status','mark_up');//'appointment_number','lat','lng'
        $role = [
            'appointment_type' => 'required|in:0,1,2',
            'user_id' => 'required|exists:user,id',
            'user_name' => 'required|string|between:2,15',
            'sex' => 'required|in:0,1',
            'user_phone'=> 'required|regex:/^1[3-9]\d{9}/',
            'pet_id' => 'required|exists:pet,id',
            'is_pickup' => 'required|in:0,1',
            'province' => 'required|string|between:2,15',
            'city' => 'required|string|between:2,15',
            'district' => 'required|string|between:2,15',
            'address' => 'required|string|between:3,35',
            'mark_up' => 'nullable|string|between:0,200',
        ];
        $message = [
            'appointment_type.in' => '选择服务类型不正确',
            'user_name.required' => '用户名不能为空',
            'user_name.string' => '用户长度为2到15位的英文、数字组成',
            'user_name.between' => '用户长度为2到15位的英文、数字组成',
            'sex.in' => '性别格式不合法',
            'user_phone.required' => '手机号码不能为空',
            'user_phone.unique' => '此号码已存在，请勿重复申请',
            'user_phone.regex' => '手机号码不正确',
            'pet_id.exists' => '宠物不存在',
            'is_pickup.in' => '是否接送不合法',
            'province.between' => '省级字节超限',
            'city.between' => '市级字节超限',
            'district.between' => '区县级字节超限',
            'address.between' => '详细地址最长为35个字节',
            'mark_up.string' => '备注不正确',
            'mark_up.between' => '备注最大100个字节',
        ];
        $validator = Validator::make( $data, $role, $message );
        if( $validator->fails() ){
            return ['status' => "fail", 'msg' => $validator->messages()->first()];
        }
        # 生成预约编号 appointment_number
        $data['appointment_number'] =  date('Ymd').uniqid();
        # 生成坐标 appointment_number
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
        if($data['province'] == $pro && $data['city'] == $city && $data['district'] == $district){//核对填写的地址
            $res = $appointment->create($data);
            if ($res) { // 如果添加数据成功，则返回列表页
                return ['status' => "success", 'msg' => '预约成功'];
            }else{
                return ['status' => 'fail', 'msg' => '预约失败'];
            }
        }else{
            return ['status' => "fail", 'msg' => '地址有误，重新输入或联系客服'];
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
