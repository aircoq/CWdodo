<?php
/**
 * @param $addrress 输入地址
 * @return bool|mixed 输出高德地图相关信息
 */
function get_gao_map_info($addrress){
    $map_url = 'https://restapi.amap.com/v3/geocode/geo?';
    $gao_key = 'a7fd905b7c27f710443e0104dd87aa3b';
    $get_url = $map_url.'key='.$gao_key.'&address='.$addrress;
    $adr_info = json_decode(file_get_contents($get_url),true);
    if($adr_info['status'] == 1){
        return $adr_info;
    }
    return false;
}