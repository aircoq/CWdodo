<?php

namespace App\Http\Controllers\Admin;

use App\Models\Admin\Goods;
use App\Models\Admin\GoodsAttr;
use App\Models\Admin\GoodsBrand;
use App\Models\Admin\GoodsCategory;
use App\Models\Admin\GoodsType;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class GoodsController extends Controller
{
    public function index(Request $request, Goods $goods)
    {
        if ($request->ajax()) {
            $data = $goods->select('id','goods_name','cate_id','type_id','brand_id','inventory','goods_weight','market_price','shop_price','promote_price','promote_start_at','promote_end_at','warn_num','keywords','goods_thumb','goods_img','is_real','extension_code','is_on_sale','is_alone_sale','is_best','is_new','is_hot','is_promote','integral','sort_order','goods_desc','give_integral', 'deleted_at')->withTrashed()->get();
            $cnt = count($data);
            $info = [
                'draw' => $request->get('draw'),
                'recordsTotal' => $cnt,
                'recordsFiltered' => $cnt,
                'data' => $data,
            ];
            return $info;
        }
        return view('admin.goods.index');
    }

    public function create(GoodsCategory $goodsCategory,GoodsType $goodsType, GoodsBrand $goodsBrand,Goods $goods)
    {
        $data['goods_type'] = $goodsType->all();
        $data['goods_category'] = $goodsCategory->where('is_show','1')->get();
        $data['goods_brand'] = $goodsBrand->all();
        return view('admin.goods.create',$data);
    }


    public function store(Request $request,GoodsCategory $goodsCategory)
    {
        $data = $request->only('cate_name','p_id','show_in_nav','is_show','sort_order','cat_desc');
        $role = [
            'cate_name' => 'nullable|alpha_num|between:1,15|unique:goods_category',
            'p_id' => 'required|integer',
            'show_in_nav' => 'required|in:0,1',
            'is_show' => 'nullable|in:0,1',
            'sort_order' => 'nullable|integer',
            'cate_desc' => 'nullable|string',

        ];
        $message = [
            'cate_name.alpha_num' => '名称长度为2到8位字节组成',
            'cate_name.between' => '名称长度为2到8位字节组成',
            'cate_name.unique' => '分类名重复',
            'show_in_nav.in' => '菜单显示的值有误',
            'is_show.in' => '是否可用的值有误',
            'p_id.integer' => '排序字段必须为整数',
            'sort_order.integer' => '排序字段必须为整数',
            'cate_desc.string' => '描述的值必须为字符串格式'
        ];
        $validator = Validator::make($data, $role, $message);
        if ($validator->fails()) {
            return ['status' => 'fail', 'msg' => $validator->messages()->first()];
        }
        # 层级关系为：父级的层级+1 'first_p_id','path',
        if($data['p_id'] == 0){//当前为顶级菜单
            $data['path'] = 1;
            $data['first_p_id'] = 0;
        }else{
            $p_cate = $goodsCategory->where('id',$data['p_id'])->first();
            $data['path'] = $p_cate['path']+1;
            $data['first_p_id'] = $p_cate['first_p_id']==0 ? $p_cate['id'] : $p_cate['first_p_id'];
        }
        $res = $goodsCategory->create($data);
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

    public function edit(GoodsCategory $goodsCategory)
    {
        $data['cate'] = $goodsCategory;//当前记录
        $all_cate = new GoodsCategory();
        $data['goods_category'] = $all_cate->where('is_show','1')->where('id','!=',$goodsCategory->id)->get();//除去本身外的所有记录
        return view('admin.goods_category.edit',$data);
    }


    public function update(Request $request,GoodsCategory $goodsCategory)
    {
        $data = $request->only('cate_name','p_id','show_in_nav','is_show','sort_order','cat_desc');
        $role = [
            'cate_name' => 'nullable|alpha_num|between:1,15|unique:goods_category,cate_name,'.$goodsCategory->id,
            'p_id' => 'required|integer',
            'show_in_nav' => 'required|in:0,1',
            'is_show' => 'nullable|in:0,1',
            'sort_order' => 'nullable|integer',
            'cate_desc' => 'nullable|string',

        ];
        $message = [
            'cate_name.alpha_num' => '名称长度为2到8位字节组成',
            'cate_name.between' => '名称长度为2到8位字节组成',
            'cate_name.unique' => '分类名重复',
            'show_in_nav.in' => '菜单显示的值有误',
            'is_show.in' => '是否可用的值有误',
            'p_id.integer' => '排序字段必须为整数',
            'sort_order.integer' => '排序字段必须为整数',
            'cate_desc.string' => '描述的值必须为字符串格式'
        ];
        $validator = Validator::make($data, $role, $message);
        if ($validator->fails()) {
            return ['status' => 'fail', 'msg' => $validator->messages()->first()];
        }
        # 层级关系为：父级的层级+1 'first_p_id','path',
        if($data['p_id'] == 0){//当前为顶级菜单
            $data['path'] = 1;
            $data['first_p_id'] = 0;
        }else{
            $p_cate = $goodsCategory->where('id',$data['p_id'])->first();
            $data['path'] = $p_cate['path']+1;
            $data['first_p_id'] = $p_cate['first_p_id']==0 ? $p_cate['id'] : $p_cate['first_p_id'];
        }
        $res = $goodsCategory->update($data);
        if ($res) {
            // 如果添加数据成功，则返回列表页
            return ['status' => "success", 'msg' => '更新成功'];
        }else{
            return ['status' => 'fail', 'msg' => '更新失败'];
        }
    }

    /**
     * 软删除
     */
    public function destroy(GoodsCategory $goodsCategory)
    {
        $cate_models = new GoodsCategory();
        if($cate_models->where('p_id',$goodsCategory->id)->exists()){//如果存在子集不能被删除
            return ['status' => 'fail', 'msg' => '存在子集，不能被删除'];
        }else{
            $res = $goodsCategory->delete();
            if ($res) {
                // 如果添加数据成功，则返回列表页
                return ['status' => "success", 'msg' => '删除成功'];
            }else{
                return ['status' => 'fail', 'msg' => '删除失败'];
            }
        }
    }

    /**
     * 恢复软删除（超级管理员权限）
     */
    public function re_store(Request $request,GoodsCategory $goodsCategory)
    {
        if ($request->ajax()) {
            $id = $request->only('id')['id'];
            $cate_models = new GoodsCategory();
            $cate_now = $cate_models->where('id', $id)->first();//当前模型的 pid
            if($cate_now['p_id'] != 0){
                if(!$cate_models->where('id',$cate_now['p_id'])->exists()){//如果不存在父级不能被恢复
                    return ['status' => 'fail', 'msg' => '父级不存在，不能被恢复'];
                }
            }
            $res = $goodsCategory->where('id', $id)->restore();
            if ($res) {
                return ['status' => 'success','msg' => '恢复成功！'];
            } else {
                return ['status' => 'fail', 'msg' => '恢复失败！'];
            }
        }
    }
}
