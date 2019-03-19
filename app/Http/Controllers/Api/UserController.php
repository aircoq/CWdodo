<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\Admin\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Redis;

class UserController extends BaseController
{
    use ThrottlesLogins;

    public function test(Request $request){
        $token_key = '123abcdef';
        $user_now =[
            "id" => 1,
            "openid" => null,
            "session_key" => null,
            "phone" => null,
            "email" => "email@qq.com",
            "api_token" => null,
            "remember_token" => null,
            "user_status" => "1",
            "integral" => null,
            "frozen_integral" => null,
            "user_money" => null,
            "frozen_money" => null,
            "credit_line" => null,
            "cost_total" => null,
            "nickname" => "你好2020",
            "user_level" => 0,
            "avatar" => "uploads/frontend/user_avatar/20181127/201811275bfcf0ab3e1cb.jpeg",
            "sex" => "2",
            "birthday" => null,
            "city" => "深圳",
            "height" => null,
            "weight" => null,
            "has_medal" => null,
            "flag" => null,
            "address_id" => null,
            "qr_code" => null,
            "parent_id" => null,
            "zone_cate_id" => null,
            "friends_list" => null,
            "fans_list" => null,
            "desc" => null,
            "note" => null,
            "question_answer" => null,
            "last_ip" => "0",
            "last_login" => null,
            "created_at" => "2018-11-20 10:24:11",
            "updated_at" => "2018-11-27 15:22:19",
            "deleted_at" => null,
        ];
        $user_now = json_encode($user_now, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        Redis::set($token_key,$user_now);
        $data = Redis::get($token_key);
        dump($data);
    }
    # 注册或更新用户
    public function login(Request $request,User $user) {
        // 拿code换取session_key与openid
        $code = $request['code'];
        $url = 'https://api.weixin.qq.com/sns/jscode2session?appid='.'APPID'.'&secret='.'APPSECRET'.'&js_code='.$code.'&grant_type=authorization_code';
//        $data =  json_decode(file_get_contents($url), true);//{"session_key": "odMd5E1qJI5KJH7OTBVZYg==","expires_in": 7200,"openid": "oqMjq0BqLl6mRarbByCf9rOAc3k0"}
        $data = $this-> curlGet($url);
        // 判断新老用户
        $chk_new = $user->where( 'openid',$data['openid'])->first();
        if (empty($chk_new)) {//新用户
            $user_now = $user->create($data);//注册用户
        } else {//存在此用户
            $user_now = $chk_new;
//            $user_now = $user->where('openid',$data['openid'])->update($data);//更新用户session_key
        }
        // 创建用户信息的key
        $token_key = md5(mt_rand() . $user_now['openid']);
        $user_now = json_encode($user_now, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        Redis::set($token_key,$user_now);//保存到服务端作登陆认证
        return ['session_key' => $token_key ];//保存到客户端作登陆认证
    }
    # CURL
    public function curlGet($url){
        $info=curl_init();
        curl_setopt($info,CURLOPT_RETURNTRANSFER,true);
        curl_setopt($info,CURLOPT_HEADER,0);
        curl_setopt($info,CURLOPT_NOBODY,0);
        curl_setopt($info,CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($info,CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($info,CURLOPT_URL,$url);
        $output= curl_exec($info);
        curl_close($info);
        return $output;
    }
    public function bandPhone(Request $request,User $user)
    {
        $data = $request->only('session_key','phone');
        $role = [
            'session_key' => 'required|string',
            'phone'=> 'required|digits:11|unique:user',
        ];
        $message = [
            'session_key.required' => '用户数据有误',
            'session_key.string' => '用户数据格式有误',
            'phone.required' => '手机号码不能为空',
            'phone.unique' => '此号码已存在，请勿重复申请',
            'phone.digits' => '手机号码不正确',
        ];
        $validator = Validator::make( $data, $role, $message );
        if( $validator->fails() ){
            return ['status' => "0", 'msg' => $validator->messages()->first()];
        }
        #获取当前用户信息
        $user_now = Redis::get($data['session_key']);
        $user_now = json_decode($user_now,true);
        $tf = $user->where('id',$user_now['id'])->update(['phone'=>$data['phone']]);
        if($tf){
            $new_user_info = $user->where('id',$user_now['id'])->first();
            Redis::set($data['session_key'],$new_user_info);
            return ['status' => "1", 'msg' => '绑定成功'];
        }else{
            return ['status' => "0", 'msg' => '绑定失败'];
        }
    }
}

