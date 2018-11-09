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