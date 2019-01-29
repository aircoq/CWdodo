<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\Admin\User;

class UserController extends BaseController
{

    public function test(){
        return ['你好',1,3,5];
    }


    # 注册或更新用户
    public function registOrUpdate(Request $request) {
        // 拿code换取session_key与openid
        $code = $request['code'];
        $json = 'https://api.weixin.qq.com/sns/jscode2session?appid='.'APPID'.'&secret='.'APPSECRET'.'&js_code='.$code.'&grant_type=authorization_code';
        $data =  json_decode(file_get_contents($json), true);//{"session_key": "odMd5E1qJI5KJH7OTBVZYg==","expires_in": 7200,"openid": "oqMjq0BqLl6mRarbByCf9rOAc3k0"}
        // 判断新老用户
        $user = new User();
        if ($this->checkNew($data)) {//新用户
            $user_now = $user->create($data);//注册用户
        } else {//更新
            $user_now = $user->where('openid',$data['openid'])->update($data);//更新用户session_key
        }
        // 创建随机数
        $re = [
            'thirdSession' => md5(mt_rand() . $user_now['openid'])
        ];
        echo json_encode($re);
    }
    # 检测用户是否存在
    private function checkNew($data) {
        $user = new User();
        $chk_new = $user->where( 'openid',$data['openid'])->first();
        if(empty($chk_new)){
            return true;
        }
        return false;
    }
}
