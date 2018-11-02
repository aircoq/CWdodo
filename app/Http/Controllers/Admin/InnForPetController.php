<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Admin\InnForPet;

class InnForPetController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.inn.index');
    }

    /**
     * 列表数据
     */
    public function ajax_list(Request $request, InnForPet $innForPet)
    {
            if(Auth::guard('admin')->user()->role_id == '*') {//管理员查看包括软删除的用户
                $data = $innForPet->select('id','inn_name','inn_sn','cate_id','is_self','inn_status','is_running','inn_tel','lat','lng','province','city','district','adcode','inn_address','inn_avatar','inn_img','start_time','end_time','note','admin_id','bank_id','bank_account_name','bank_account','create_at','updated_at', 'deleted_at')->withTrashed()->get();
            }else{
                $data = $innForPet->select('id','inn_name','inn_sn','cate_id','is_self','inn_status','is_running','inn_tel','lat','lng','province','city','district','adcode','inn_address','inn_avatar','inn_img','start_time','end_time','note','admin_id','bank_id','bank_account_name','bank_account','create_at','updated_at')->get();
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




    /**
     * Show the form for creating a new resource
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
