<?php

namespace App\Http\Controllers\Api;

use App\Models\Admin\Appointment;
use App\Models\Admin\Pet;
use App\Models\Admin\Service;
use Dingo\Api\Http\Request;
use Illuminate\Support\Facades\Validator;
use Redis;
use Illuminate\Support\Facades\URL;

class IndexController extends BaseController
{
    # 查询狗服务
    public function Dog(Service $service)
    {
        $data = $service->select('id','service_name','pet_category','service_thumb','market_price','shop_price','service_explain','tips','appointment_info')
            ->where('pet_category','1')->where('is_on_sale','1')
            ->get();
        $data = json_encode($data, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        return $data;
    }
    # 查询猫服务
    public function Cat(Service $service)
    {
        $data = $service->select('id','service_name','pet_category','service_thumb','market_price','shop_price','service_explain','tips','appointment_info')
            ->where('pet_category','2')->where('is_on_sale','1')
            ->get();
        $data = json_encode($data, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        return $data;
    }
    # 我的订单（判断用户是否已绑定手机）
    public function MyOrder(Request $request,Pet $pet,Appointment $appointment)
    {
        $data = $request->only('session_key','phone');
        $role = [
            'session_key' => 'required|string',
        ];
        $message = [
            'session_key.required' => '用户数据有误',
            'session_key.string' => '用户数据格式有误',
        ];
        $validator = Validator::make( $data, $role, $message );
        if( $validator->fails() ){
            return ['status' => "0", 'msg' => $validator->messages()->first()];
        }
        #获取当前用户信息
        $user_now = Redis::get($data['session_key']);
        $user_now = json_decode($user_now,true);
        if(empty($user_now['phone'])){
            return ['status' => "2", 'msg' => '请先绑定手机'];
        }else{
            //查询该用户的昵称，当前的星球，该用户的宠物，我的所有订单（订单号，购买商品名称，所使用的宠物，单价，总价，订单状态，使用的优惠券名称）
            $info['user']['id'] = $user_now['id'];
            $info['user']['avatar'] = URL::previous().'/'.$user_now['avatar'];
            $info['user']['nickname'] = $user_now['nickname'];
            $info['user']['sex'] = $user_now['sex'];
            $info['my_pet'] = $pet->select('pet_thumb','male','pet_name','pet_category','varieties','weight','birthday')->where('user_id',$user_now['id'])->get();
            $info['my_order'] = $appointment
                ->select('id','service_name','appointment_number','appointment_type','user_name','sex','user_phone','is_pickup','address','appointment_status','pet_name','order_status','price','times','amount','order_img')
                ->where('user_id',$user_now['id'])->get();
            $res = json_encode(['status' => "1", 'msg' => '查询成功',"data" => $info], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
            return $res;
        }
    }

    # 添加查看编辑宠物信息


    # 发起预约服务
    public function makeAppointment(Request $request,Pet $pet,Appointment $appointment)
    {
        $data = $request->only('service_name','appointment_type','user_phone', 'pet_id','is_pickup','province','city','district','address','start_at','end_at','food_type','price','times','amount','order_img');
        $role = [
            'appointment_type' => 'required|in:0,1,2,3',
            'service_name' => 'required|string',
            'order_img' => 'required|string',
            'price' => 'required|integer',
            'times' => 'integer',
            'amount' => 'required|integer',
            'user_phone'=> 'required|digits:11',
            'pet_id' => 'required|exists:pet,id',
            'is_pickup' => 'required|in:0,1',
//            'province' => 'nullable|required_if:is_pickup,1|string|between:2,15',
//            'city' => 'nullable|required_if:is_pickup,1|string|between:2,15',
//            'district' => 'nullable|required_if:is_pickup,1|string|between:2,15',
            'address' => 'nullable|required_if:is_pickup,1|string|between:3,35',
            'start_at' => 'required|date|after:now',
            'end_at' => 'nullable|required_if:appointment_type,0|date|after:start_at',
            'food_type' => 'nullable|required_if:appointment_type,0|in:0,1',//0自带 1默认
        ];
        $message = [
            'appointment_type.in' => '选择服务类型不正确',
            'user_phone.required' => '手机号码不能为空',
            'user_phone.digits' => '手机号码不正确',
            'pet_id.integer' => '宠物不存在',
            'is_pickup.in' => '是否接送不合法',
//            'province.between' => '省级字节超限',
//            'province.required_if' => '接送地址不能空',
//            'city.between' => '市级字节超限',
//            'city.required_if' => '接送地址不能空',
//            'district.between' => '区县级字节超限',
//            'district.required_if' => '接送地址不能空',
            'address.between' => '详细地址最长为35个字节',
            'address.required_if' => '接送地址不能空',
            'start_at.required' => '预约服务时间不能为空',
            'start_at.date' => '预约服务时间格式不正确',
            'end_at.required_if' => '寄养结束时间不能为空',
            'end_at.date' => '预约服务时间格式不正确',
            'end_at.after' => '寄养结束时间不能小于开始时间',
            'food_type.required_if' => '宠物食品不能为空',
            'food_type.in' => '宠物食品类型不正确',
        ];
        $validator = Validator::make( $data, $role, $message );
        if( $validator->fails() ){
            return ['status' => "0", 'msg' => $validator->messages()->first()];
        }
        #获取当前用户信息
        $user_now = Redis::get($data['session_key']);
        $user_now = json_decode($user_now,true);
        $data['user_id'] = $user_now['id'];
        $data['user_name'] = $user_now['nickname'];
        $data['sex'] = $user_now['sex'];
        # 核对用户与宠物的对应关系
        $tf = $pet->where('id',$data['pet_id'])->where('user_id',$data['user_id'])->first();
        if(empty($tf)){
            return ['status' => "fail", 'msg' => '请核对填写宠物信息是否正确'];
        }
        $data['pet_name'] = $tf['pet_name'];
//        # 如果接送 生成坐标 核对填写的地址
//        if($data['is_pickup'] == 1){
//            $get_adr_info = getGaoMapInfo($data['address'],$data['city']);
//            if($get_adr_info['count'] != 0){
//                $lat_lng = explode(',',$get_adr_info['geocodes'][0]['location']);
//                $data['lat'] = $lat_lng['0'];
//                $data['lng'] = $lat_lng['1'];
//                $pro = $get_adr_info['geocodes'][0]['province'];
//                $city = $get_adr_info['geocodes'][0]['city'];
//                $district = $get_adr_info['geocodes'][0]['district'];
//            }else{//不接送
//                return ['status' => "fail", 'msg' => '不能识别地址，请重新输入地址'];
//            }
//            if($data['province'] != $pro || $data['city'] != $city || $data['district'] != $district){//核对填写的地址
//                return ['status' => "fail", 'msg' => '地址填写有误，重新输入或联系客服'];
//            }
//        }else{
//            unset($data['province']);
//            unset($data['city']);
//            unset($data['district']);
//            unset($data['address']);
//        }
        # 生成预约编号 appointment_number
        $data['appointment_number'] =  date('Ymd').uniqid();
        # 转换时间戳
        $data['start_at'] = strtotime($data['start_at']);
        if($data['appointment_type'] != 0){ //如果不是寄养
            unset($data['end_at']);
            unset($data['food_type']);
            $data['times'] = 1;
        }else{
            $data['end_at'] = strtotime($data['end_at']);
            $data['times'] = ceil(($data['end_at']-$data['start_at'])/86400);
        }
        $data['from_way'] = 'api';//手机端接口
        $res = $appointment->create($data);
        if ($res) { // 如果添加数据成功，则返回列表页
            event(new AppointmentCreated($res));
            return ['status' => "1", 'msg' => '预约成功'];
        }else{
            return ['status' => '0', 'msg' => '预约失败'];
        }
    }

    /**
     * 微信小程序上传地址
     * @param Request $request
     * @return array
     */
    public function uploadImg(Request $request)
    {
        $data = $request->only('img');
        $role = [
            'img' => 'required|file|image|mimes:png,gif,jpeg,jpg|max:2000',
        ];
        $message = [
            'img.required_with' => '图片不能为空',
            'img.mimes' => '图片格式为png,gif,jpeg,jpg',
            'img.max' => '图片不超过2000kb',
        ];
        $validator = Validator::make( $data, $role, $message );
        if( $validator->fails() ){
            return ['status' => "0", 'msg' => $validator->messages()->first()];
        }
        $img = uploadPic('img','uploads/weChat/'.date('Ymd'));
        if($img){
            return ['status' => "1", 'msg' => '上传成功' ,'data' => $img];
        }else{
            return ['status' => "0", 'msg' => '上传失败，稍后在试'];
        }
    }

    public function myShow(Request $request ,Pet $pet)
    {
        $data = $request->only('session_key');
        //获取用户id
        #获取当前用户信息
        $user_now = Redis::get($data['session_key']);
        $user_now = json_decode($user_now,true);
        $user_id = $user_now['id'];
        $data = $pet
            ->select('id','user_id','pet_thumb','male','pet_name','pet_category','varieties','height','weight','color','status','star','birthday','born_where','room_id','pet_desc','created_at','updated_at')
            ->where('user_id',$user_id)->get();
        return json_encode(['status' => "1", 'msg' => '查询成功',"data" => $data], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    }
}
