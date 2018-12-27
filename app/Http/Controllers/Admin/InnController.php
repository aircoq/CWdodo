<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Models\Admin\Inn;
use Illuminate\Support\Facades\Auth;

class InnController extends Controller
{
    public function index(Request $request, Inn $inn)
    {
        if ($request->ajax()) {
            if (Auth::guard('admin')->user()->role_class == '*') {//管理员查看包括软删除的用户
                $data = $inn->select('id', 'inn_name', 'inn_sn', 'cate_id', 'is_self', 'inn_status', 'is_running', 'inn_tel', 'lat', 'lng', 'province', 'city', 'district', 'adcode', 'inn_address', 'inn_logo', 'inn_img', 'start_time', 'end_time', 'note', 'admin_id', 'bank_id', 'bank_account_name', 'bank_account', 'created_at', 'updated_at', 'deleted_at')->withTrashed()->get();
            } else {
                $data = $inn->select('id', 'inn_name', 'inn_sn', 'cate_id', 'is_self', 'inn_status', 'is_running', 'inn_tel', 'lat', 'lng', 'province', 'city', 'district', 'adcode', 'inn_address', 'inn_logo', 'inn_img', 'start_time', 'end_time', 'note', 'admin_id', 'bank_id', 'bank_account_name', 'bank_account', 'created_at', 'updated_at')->get();
            }
            $cnt = count($data);
            $info = [
                'draw' => $request->get('draw'),
                'recordsTotal' => $cnt,
                'recordsFiltered' => $cnt,
                'data' => $data,
            ];
            return $info;
        }
        return view('admin.inn.index');
    }

    public function create()
    {
        return view('admin.inn.create');
    }

    public function store(Request $request,Inn $inn)
    {
        $data = $request->only('inn_name','inn_sn','is_self','inn_status','is_running','inn_tel','inn_address','start_time','end_time','note','admin_id','city','adcode','inn_logo','inn_img1','inn_img2','inn_img3');
        $role = [
            'inn_name' => 'required|string|between:1,12|unique:inn',
            'inn_sn' => 'required|alpha_num|between:5,12|unique:inn',
            'is_self' => 'required|in:0,1',
            'inn_status' => 'required|in:-2,-1,0,1',
            'is_running' => 'required|in:0,1',
            'inn_tel' => 'required|digits:11|unique:inn',
            'inn_address' => 'required|string|between:3,30',
            'start_time' => 'required|string|between:4,5',
            'end_time' => 'required|string|between:4,5|after:start_time',
            'note' => 'nullable|string|between:0,100',
            'admin_id' => 'exists:admin,id',
            'city' => 'required|string|between:2,10',
            'adcode' => 'required|digits:6',
            'inn_logo' => 'required|file|image|mimes:png,gif,jpeg,jpg|max:150|dimensions:width=300,height=300',
            'inn_img1' => 'nullable|required_with:inn_img2|file|image|mimes:png,gif,jpeg,jpg|max:550|dimensions:width=800,height=800',
            'inn_img2' => 'nullable|required_with:inn_img3|file|image|mimes:png,gif,jpeg,jpg|max:550|dimensions:width=800,height=800',
            'inn_img3' => 'nullable|file|image|mimes:png,gif,jpeg,jpg|max:550|dimensions:width=800,height=800',
        ];
        $message = [
            'inn_name.string' => '门店名称为1到12位的字符串组成',
            'inn_name.between' => '门店名称为1到12位的字符串组成',
            'inn_name.unique' => '用户名重复',
            'is_self.in' => '是否自营写入参数有误',
            'inn_status.in' => '状态值有误',
            'is_running' => '是否营业参数有误',
            'inn_tel.digits' => '电话号码不正确',
            'inn_tel.unique' => '此号码已存在，请勿重复申请',
            'inn_address.string' => '门店地址为10到52位的字符串组成',
            'inn_address.between' => '门店地址为10到52位的字符串组成',
            'start_time.string' => '开始时间格式不正确',
            'start_time.between' => '开始时间长度不正确',
            'end_time.string' => '开始时间格式不正确',
            'end_time.between' => '开始时间长度不正确',
            'end_time.after' => '结束时间必须大于开始时间',
            'password.same' => '密码不一致',
            'note.string' => '备注不正确',
            'note.between' => '备注最大100个字节',
            'admin_id.exists' => '所有人不存在',
            'city.required' => '所属市不能为空',
            'city.string' => '请填写正确的地址',
            'city.between' => '请填写正确的地址',
            'adcode.digits' => '请填写正确的地址',
            'inn_logo.mimes' => 'LOGO格式为png,gif,jpeg,jpg',
            'inn_logo.max' => 'LOGO不超过550kb',
            'inn_logo.dimensions' => 'LOGO宽高各为300',
            'inn_img1.required_with' => '该情况图片1不能为空',
            'inn_img1.mimes' => '图片1格式为png,gif,jpeg,jpg',
            'inn_img1.max' => '图片1不超过5500kb',
            'inn_img1.dimensions' => '图片1宽高各为800',
            'inn_img2.required_with' => '该情况图片2不能为空',
            'inn_img2.mimes' => '图片2格式为png,gif,jpeg,jpg',
            'inn_img2.max' => '图片2不超过5500kb',
            'inn_img2.dimensions' => '图片2宽高各为800',
            'inn_img3.mimes' => '图片3格式为png,gif,jpeg,jpg',
            'inn_img3.max' => '图片3不超过5500kb',
            'inn_img3.dimensions' => '图片3宽高各为800',
        ];
        $validator = Validator::make( $data, $role, $message );
        if( $validator->fails() ){
            return ['status' => "fail", 'msg' => $validator->messages()->first()];
        }
        //获取当前地址的高德信息
        $get_adr_info = getGaoMapInfo($data['inn_address'],$data['city']);
        if($get_adr_info['count'] != 0){//可以查到该地址
            $lat_lng = explode(',',$get_adr_info['geocodes'][0]['location']);
            $data['lat'] = $lat_lng['0'];
            $data['lng'] = $lat_lng['1'];
            $data['province'] = $get_adr_info['geocodes'][0]['province'];
            $data['city'] = $get_adr_info['geocodes'][0]['city'];
            $data['district'] = $get_adr_info['geocodes'][0]['district'];
            $data['adcode'] = $get_adr_info['geocodes'][0]['adcode'];
        }else{
            return ['status' => "fail", 'msg' => '不能识别该地址，请重新输入地址'];
        }
        $tf1 = uploadPic('inn_logo','uploads/backend/inn/logo/'.date('Ymd'));
        if($tf1){
            $data['inn_logo'] = $tf1;
        }else{
            return ['status' => "fail", 'msg' => 'LOGO添加失败'];
        }
        if(!empty($data['inn_img1'])){
            $tf2 = uploadPic('inn_img1','uploads/backend/inn/img/'.date('Ymd'));
            if($tf2){
                $inn_img[] = $tf2;
            }else{
                return ['status' => "fail", 'msg' => '图片1添加失败'];
            }
        }
        if(!empty($data['inn_img2'])){
            $tf3 = uploadPic('inn_img2','uploads/backend/inn/img/'.date('Ymd'));
            if($tf3){
                $inn_img[] = $tf3;
            }else{
                return ['status' => "fail", 'msg' => '图片2添加失败'];
            }
        }
        if(!empty($data['inn_img3'])){
            $tf4 = uploadPic('inn_img3','uploads/backend/inn/img/'.date('Ymd'));
            if($tf4){
                $inn_img[] = $tf4;
            }else{
                return ['status' => "fail", 'msg' => '图片3添加失败'];
            }
        }
        if(!empty($inn_img)){
            $data['inn_img'] = json_encode($inn_img, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        }
        $res = $inn->create($data);
        if ($res->id) {
            // 如果添加数据成功，则返回列表页
            return ['status' => "success", 'msg' => '添加成功'];
        }else{
            @unlink($tf1);
            @unlink($tf2);
            @unlink($tf3);
            @unlink($tf4);
            return ['status' => 'fail', 'msg' => '添加失败'];
        }
    }

    public function show($id)
    {
        //
    }

    public function edit(Inn $inn)
    {
        $data['inn'] =$inn;
        return view('admin.inn.edit',$data);
    }

    public function update(Inn $inn,Request $request)
    {
        $data = $request->only('inn_name','inn_sn','is_self','inn_status','is_running','inn_tel','inn_address','inn_img','start_time','end_time','note','admin_id','city','adcode','inn_logo','inn_img1','inn_img2','inn_img3');
        $role = [
            'inn_name' => 'nullable|string|between:1,12|unique:inn,inn_name,'.$inn->id,
            'inn_sn' => 'nullable|alpha_num|between:5,12|unique:inn,inn_sn,'.$inn->id,
            'is_self' => 'nullable|in:0,1',
            'inn_status' => 'nullable|in:-2,-1,0,1',
            'is_running' => 'nullable|in:0,1',
            'inn_tel' => 'nullable|digits:11|unique:inn,inn_tel,'.$inn->id,
            'inn_address' => 'nullable|string|between:3,22',
            'start_time' => 'nullable|string|between:4,5',
            'end_time' => 'nullable|string|between:4,5|after:start_time',
            'note' => 'nullable|string|between:0,100',
            'admin_id' => 'nullable|exists:admin,id',
            'city' => 'nullable|string|between:2,10',
            'adcode' => 'nullable|digits:6',
            'inn_logo' => 'required|file|image|mimes:png,gif,jpeg,jpg|max:150|dimensions:width=300,height=300',
            'inn_img1' => 'nullable|required_with:inn_img2|file|image|mimes:png,gif,jpeg,jpg|max:550|dimensions:width=800,height=800',
            'inn_img2' => 'nullable|required_with:inn_img3|file|image|mimes:png,gif,jpeg,jpg|max:550|dimensions:width=800,height=800',
            'inn_img3' => 'nullable|file|image|mimes:png,gif,jpeg,jpg|max:550|dimensions:width=800,height=800',
        ];
        $message = [
            'inn_name.string' => '门店名称为1到12位的字符串组成',
            'inn_name.between' => '门店名称为1到12位的字符串组成',
            'inn_name.unique' => '用户名重复',
            'is_self.in' => '是否自营写入参数有误',
            'inn_status.in' => '状态值有误',
            'is_running' => '是否营业参数有误',
            'inn_tel.digits' => '电话号码不正确',
            'inn_tel.unique' => '此号码已存在，请勿重复申请',
            'inn_address.string' => '门店地址为10到52位的字符串组成',
            'inn_address.between' => '门店地址为10到52位的字符串组成',
            'start_time.string' => '开始时间格式不正确',
            'start_time.between' => '开始时间长度不正确',
            'end_time.string' => '开始时间格式不正确',
            'end_time.between' => '开始时间长度不正确',
            'end_time.after' => '结束时间必须大于开始时间',
            'password.same' => '密码不一致',
            'note.string' => '备注不正确',
            'note.between' => '备注最大100个字节',
            'admin_id.exists' => '所有人不存在',
            'city.string' => '请填写正确的地址',
            'city.between' => '请填写正确的地址',
            'adcode.digits' => '请填写正确的地址',
            'inn_logo.mimes' => 'LOGO格式为png,gif,jpeg,jpg',
            'inn_logo.max' => 'LOGO不超过550kb',
            'inn_logo.dimensions' => 'LOGO宽高各为300',
            'inn_img1.required_with' => '该情况图片1不能为空',
            'inn_img1.mimes' => '图片1格式为png,gif,jpeg,jpg',
            'inn_img1.max' => '图片1不超过5500kb',
            'inn_img1.dimensions' => '图片1宽高各为800',
            'inn_img2.required_with' => '该情况图片2不能为空',
            'inn_img2.mimes' => '图片2格式为png,gif,jpeg,jpg',
            'inn_img2.max' => '图片2不超过5500kb',
            'inn_img2.dimensions' => '图片2宽高各为800',
            'inn_img3.mimes' => '图片3格式为png,gif,jpeg,jpg',
            'inn_img3.max' => '图片3不超过5500kb',
            'inn_img3.dimensions' => '图片3宽高各为800',
        ];
        $validator = Validator::make( $data, $role, $message );
        if( $validator->fails() ){
//            $request->flash();//保存当前数据到一次性session中
            return ['status' => "fail", 'msg' => $validator->messages()->first()];
        }
        if(!empty($data['adcode'])){
            //获取当前地址的高德信息
            $get_adr_info = getGaoMapInfo($data['inn_address'],$data['city']);
            if($get_adr_info['count'] != 0){
                $lat_lng = explode(',',$get_adr_info['geocodes'][0]['location']);
                $data['lat'] = $lat_lng['0'];
                $data['lng'] = $lat_lng['1'];
                $data['province'] = $get_adr_info['geocodes'][0]['province'];
                $data['city'] = $get_adr_info['geocodes'][0]['city'];
                $data['district'] = $get_adr_info['geocodes'][0]['district'];
                $data['adcode'] = $get_adr_info['geocodes'][0]['adcode'];
            }else{
                return ['status' => "fail", 'msg' => '请求失败，请重新输入地址'];
            }
        }else{
            unset($data['city']);
            unset($data['adcode']);
        }
        $tf1 = uploadPic('inn_logo','uploads/backend/inn/logo/'.date('Ymd'));
        if($tf1){
            $data['inn_logo'] = $tf1;
        }else{
            return ['status' => "fail", 'msg' => 'LOGO添加失败'];
        }
        if(!empty($data['inn_img1'])){
            $tf2 = uploadPic('inn_img1','uploads/backend/inn/img/'.date('Ymd'));
            if($tf2){
                $inn_img[] = $tf2;
            }else{
                return ['status' => "fail", 'msg' => '图片1添加失败'];
            }
        }
        if(!empty($data['inn_img2'])){
            $tf3 = uploadPic('inn_img2','uploads/backend/inn/img/'.date('Ymd'));
            if($tf3){
                $inn_img[] = $tf3;
            }else{
                return ['status' => "fail", 'msg' => '图片2添加失败'];
            }
        }
        if(!empty($data['inn_img3'])){
            $tf4 = uploadPic('inn_img3','uploads/backend/inn/img/'.date('Ymd'));
            if($tf4){
                $inn_img[] = $tf4;
            }else{
                return ['status' => "fail", 'msg' => '图片3添加失败'];
            }
        }
        if(!empty($inn_img)){
            $data['inn_img'] = json_encode($inn_img, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        }
        $res = $inn->update($data);
        if ($res) { // 如果添加数据成功，则返回列表页
            return ['status' => "success", 'msg' => '修改成功'];
        }else{
            return ['status' => 'fail', 'msg' => '修改失败'];
        }
    }

    public function destroy(Inn $inn)
    {
        # 只有超级管理员才可以操作
        if(Auth::guard('admin')->user()->role_class == '*') {//1.当前是超级管理员可以禁用任何人
            $res = $inn->delete();
            if ($res) {
                return ['status' => 'success'];
            } else {
                return ['status' => 'fail', 'msg' => '删除失败！'];
            }
        }
        return ['status' => 'fail', 'msg' => '您无权限操作'];
    }

    public function re_store(Request $request,Inn $inn)
    {
        if ($request->ajax()) {
            # 只有超级管理员才可以操作
            if (Auth::guard('admin')->user()->role_class == '*') {//当前是超级管理员可以
                $id = $request->only('id');
                $res = $inn->where('id', $id)->restore();
                if ($res) {
                    return ['status' => 'success'];
                } else {
                    return ['status' => 'fail', 'msg' => '恢复失败！1'];
                }
            }
            return ['status' => 'fail', 'msg' => '您暂无操作权限'];
        }
    }
}
