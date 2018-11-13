<?php
/**
 * @param $addrress 输入地址
 * @return bool|mixed 输出高德地图相关信息
 */
function get_gao_map_info($address,$city=null){
    $map_url = 'https://restapi.amap.com/v3/geocode/geo?';
    $gao_key = 'a7fd905b7c27f710443e0104dd87aa3b';
    $get_url = $map_url.'key='.$gao_key.'&address='.$address.'&output=json'.'&city='.$city;
    $adr_info = json_decode(file_get_contents($get_url),true);//转数组
    if($adr_info['status'] == 1){
        return $adr_info;
    }
    return false;
}
//每年更新一次高德省市区三级联动的本地json数据

function copper_upload($request,$img_path,$img= "date('Ymd').uniqid()"){
    error_reporting(0);//禁用错误报告
    if ($request->isMethod('post')) {
        header('Content-type:text/html;charset=utf-8');
        $base64_image_content = $_POST['imgBase'];//获取图片编码
        //将base64编码转换为图片保存
        if (preg_match('/^(data:\s*image\/(\w+);base64,)/', $base64_image_content, $result)) {
            $type = $result[2];
            //检查是否有该文件夹，如果没有就创建，给予权限
            if (!file_exists($img_path)) {
                mkdir($img_path, 0700);
            }
            $img = $img. ".{$type}";//重写文件名
            $new_file = $img_path . $img;
            //将图片保存到指定的位置
            if (file_put_contents($new_file, base64_decode(str_replace($result[1], '', $base64_image_content)))) {
                return ['status' => 'success','msg' => '上传成功','value'=>"$new_file"];//返回前端图片地址
            }else{
                return ['status' => 'fail', 'msg' => '保存失败'];
            }
        }else{
            return ['status' => 'fail', 'msg' => '保存失败'];
        }

    }
}
