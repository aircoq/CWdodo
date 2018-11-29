<?php
/**方法命名规则：小写首个单次+大写首个字母，如：sampleMethod*/

/**
 * @param $address
 * @param null $city
 * @return bool|mixed
 */
function getGaoMapInfo($address,$city=null){
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

/**
 * 结合cropper插件上传剪切头像
 * @param $img_path
 * 存放图片文件夹的路径（格式：uploads / backend or frontend / 模型下+方法 / date('Ymd') /）；例如： $img_path = 'uploads/frontend/user_avatar/'.date('Ymd').'/';
 * @param null $img_name 重命名的文件名
 * @return bool|string 成功返回地址，失败返回false
 */
function uploadBase64Img($img_path='uploads/default/',$img_name = null){
    error_reporting(0);//禁用错误报告
    $img_name = empty($img_name) ? date('Ymd').uniqid() : $img_name;
    if (Request::isMethod('post')) {
        header('Content-type:text/html;charset=utf-8');
        $base64_image_content = $_POST['imgBase'];//获取图片编码
        //将base64编码转换为图片保存
        if (preg_match('/^(data:\s*image\/(\w+);base64,)/', $base64_image_content, $result)) {
            $type = $result[2];
            //检查是否有该文件夹，如果没有就创建，给予权限
            if (!file_exists($img_path)) {
                mkdir($img_path, 0700,true);//递归生成文件夹
            }
            $img = $img_name. ".{$type}";//重写文件名
            $new_file = $img_path . $img;
            //将图片保存到指定的位置
            if (file_put_contents($new_file, base64_decode(str_replace($result[1], '', $base64_image_content)))) {
                return $new_file;//返回图片地址
            }else{
                return false;
            }
        }else{
            return false;
        }
    }
}

/**
 * 上传图片
 * @param $file
 * @param string $new_path
 * @param null $new_name
 * @return bool|string
 */
function uploadPic($file, $new_path='uploads/default/',$new_name= null )
{

    if (Request::hasFile($file)){//是否存在上传文件
        $file = Request::file($file);// #获取文件
        if ($file->isValid()){//检查图片是否合法
            if(in_array( strtolower($file->extension()),['jpeg','bmp','jpg','gif','gpeg','png'])){
                $format = '.'.$file->extension();
                $new_name = empty($new_name) ? date('Ymd').uniqid() : $new_name;
                $new_file = $new_name.$format;
                if (!Request::hasFile($new_path)){//接收的文件夹是否存在
                    mkdir ($new_path,0777,true);
                }
                if($file->move($new_path,$new_file)){//移动文件,并修改名字
                    return $new_path.'/'.$new_file;
                }else{
                    return false;
                }
            }else{
                return false;
            }

        }else{
            return false;
        }
    }else{
        return false;
    }
}








/**
 * 在数据库中获取的数据 Collection 转数组
 * 就是这么吊！
 * @param $obj
 * @return mixed
 */
function objArr ($obj){
    return json_decode(json_encode($obj),true);
}
