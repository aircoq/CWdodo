<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\Admin\User;
use Illuminate\Foundation\Auth\ThrottlesLogins;

class UserController extends BaseController
{
    use ThrottlesLogins;

    public function test(){
        return ['你好',1,3,5];
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
        $request->session()->put($token_key,$user_now);
        return ['session_key' => $token_key ];//保存到微信端作登陆认证
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
        $user_now = $request->session()->get($data['session_key']);
        $tf = $user->where('id',$user_now['id'])->update(['phone'=>$data['phone']]);
        if($tf){
            return ['status' => "1", 'msg' => '绑定成功'];
        }else{
            return ['status' => "0", 'msg' => '绑定失败'];
        }
    }
}

