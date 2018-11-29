<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Models\Admin\InnForPet;
use Illuminate\Support\Facades\Auth;

class InnForPetController extends Controller
{
    public function index(Request $request, InnForPet $innForPet)
    {
        if ($request->ajax()) {
            if (Auth::guard('admin')->user()->role_id == '*') {//管理员查看包括软删除的用户
                $data = $innForPet->select('id', 'inn_name', 'inn_sn', 'cate_id', 'is_self', 'inn_status', 'is_running', 'inn_tel', 'lat', 'lng', 'province', 'city', 'district', 'adcode', 'inn_address', 'inn_avatar', 'inn_img', 'start_time', 'end_time', 'note', 'admin_id', 'bank_id', 'bank_account_name', 'bank_account', 'created_at', 'updated_at', 'deleted_at')->withTrashed()->get();
            } else {
                $data = $innForPet->select('id', 'inn_name', 'inn_sn', 'cate_id', 'is_self', 'inn_status', 'is_running', 'inn_tel', 'lat', 'lng', 'province', 'city', 'district', 'adcode', 'inn_address', 'inn_avatar', 'inn_img', 'start_time', 'end_time', 'note', 'admin_id', 'bank_id', 'bank_account_name', 'bank_account', 'created_at', 'updated_at')->get();
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

    public function store(Request $request,InnForPet $innForPet)
    {
        $data = $request->only('inn_name','inn_sn','is_self','inn_status','is_running','inn_tel','inn_address','inn_img','start_time','end_time','note','admin_id','city','adcode');
        $role = [
            'inn_name' => 'required|string|between:1,12|unique:inn_for_pet',
            'inn_sn' => 'required|alpha_num|between:5,12|unique:inn_for_pet',
            'is_self' => 'required|in:0,1',
            'inn_status' => 'required|in:-2,-1,0,1',
            'is_running' => 'required|in:0,1',
            'inn_tel' => 'required|digits:11|unique:inn_for_pet',
            'inn_address' => 'required|string|between:3,30',
            'start_time' => 'required|string|between:4,5',
            'end_time' => 'required|string|between:4,5|after:start_time',
            'note' => 'nullable|string|between:0,100',
            'admin_id' => 'exists:admin,id',
            'city' => 'required|string|between:2,10',
            'adcode' => 'required|digits:6'
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
        ];
        $validator = Validator::make( $data, $role, $message );
        if( $validator->fails() ){
//            $request->flash();//保存当前数据到一次性session中
            return ['status' => "fail", 'msg' => $validator->messages()->first()];
        }
        //获取当前地址的高德信息
        $get_adr_info = getGaoMapInfo($data['inn_address'],$data['city']);

        if($get_adr_info){
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
        $res = $innForPet->create($data);
        if ($res->id) {
            // 如果添加数据成功，则返回列表页
            return ['status' => "success", 'msg' => '添加成功'];
        }else{
            return ['status' => 'fail', 'msg' => '添加失败'];
        }
    }

    public function show($id)
    {
        //
    }

    public function edit(InnForPet $innForPet)
    {
        $data['inn'] =$innForPet;
        return view('admin.inn.edit',$data);
    }

    public function update(InnForPet $innForPet,Request $request)
    {
        $data = $request->only('inn_name','inn_sn','is_self','inn_status','is_running','inn_tel','inn_address','inn_img','start_time','end_time','note','admin_id','city','adcode');
        $role = [
            'inn_name' => 'nullable|string|between:1,12|unique:inn_for_pet,inn_name,'.$innForPet->id,
            'inn_sn' => 'nullable|alpha_num|between:5,12|unique:inn_for_pet,inn_sn,'.$innForPet->id,
            'is_self' => 'nullable|in:0,1',
            'inn_status' => 'nullable|in:-2,-1,0,1',
            'is_running' => 'nullable|in:0,1',
            'inn_tel' => 'nullable|digits:11|unique:inn_for_pet,inn_tel,'.$innForPet->id,
            'inn_address' => 'nullable|string|between:3,22',
            'start_time' => 'nullable|string|between:4,5',
            'end_time' => 'nullable|string|between:4,5|after:start_time',
            'note' => 'nullable|string|between:0,100',
            'admin_id' => 'nullable|exists:admin,id',
            'city' => 'nullable|string|between:2,10',
            'adcode' => 'nullable|digits:6'
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
        ];
        $validator = Validator::make( $data, $role, $message );
        if( $validator->fails() ){
//            $request->flash();//保存当前数据到一次性session中
            return ['status' => "fail", 'msg' => $validator->messages()->first()];
        }
        if(!empty($data['adcode'])){
            //获取当前地址的高德信息
            $get_adr_info = getGaoMapInfo($data['inn_address'],$data['city']);
            if($get_adr_info){
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
        $res = $innForPet->update($data);
        if ($res) { // 如果添加数据成功，则返回列表页
            return ['status' => "success", 'msg' => '修改成功'];
        }else{
            return ['status' => 'fail', 'msg' => '修改失败'];
        }
    }

    public function destroy(InnForPet $innForPet)
    {
        # 只有超级管理员才可以操作
        if(Auth::guard('admin')->user()->role_id == '*') {//1.当前是超级管理员可以禁用任何人
            $res = $innForPet->delete();
            if ($res) {
                return ['status' => 'success'];
            } else {
                return ['status' => 'fail', 'msg' => '删除失败！'];
            }
        }
        return ['status' => 'fail', 'msg' => '您无权限操作'];
    }

    public function re_store(Request $request,InnForPet $innForPet)
    {
        if ($request->ajax()) {
            # 只有超级管理员才可以操作
            if (Auth::guard('admin')->user()->role_id == '*') {//当前是超级管理员可以
                $id = $request->only('id');
                $res = $innForPet->where('id', $id)->restore();
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
