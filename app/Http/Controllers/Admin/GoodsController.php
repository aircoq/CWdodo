<?php

namespace App\Http\Controllers\Admin;

use App\Models\Admin\Goods;
use App\Models\Admin\GoodsBrand;
use App\Models\Admin\GoodsCategory;
use App\Models\Admin\GoodsType;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

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


    public function store(Request $request,Goods $goods)
    {
        $data = $request->only('goods_name','cate_id','type_id','brand_id','inventory','goods_weight','market_price','shop_price','promote_price','promote_start_at','promote_end_at','warn_num','keywords','goods_thumb','goods_img','is_real','is_on_sale','is_alone_sale','is_best','is_new','is_hot','is_promote','integral','sort_order','goods_desc','give_integral');
        dump($data);die();
        $role = [
            'goods_name' => 'required|string|between:1,15',
            'cate_id' => 'required|exists:goods_category,id',
            'type_id' => 'required|exists:goods_type,id',
            'brand_id' => 'required|exists:goods_brand,id',
            'inventory' => 'required|integer',
            'warn_num' => 'required|integer',
            'goods_weight' => 'required|numeric|min:0',
            'market_price' => 'required|numeric|min:0',
            'shop_price' => 'required|numeric|min:0',
            'promote_price' => 'required|numeric|min:0',
            'promote_start_at' => 'required|date',
            'promote_end_at' => 'required|date',
            'goods_thumb' => 'required|file|image|mimes:png,gif,jpeg,jpg|max:100|dimensions:width=300,height=300',
            'goods_img1' => 'required|file|image|mimes:png,gif,jpeg,jpg|max:550|dimensions:width=800,height=800',
            'goods_img2' => 'nullable|file|image|mimes:png,gif,jpeg,jpg|max:550|dimensions:width=800,height=800',
            'goods_img3' => 'nullable|file|image|mimes:png,gif,jpeg,jpg|max:550|dimensions:width=800,height=800',
            'goods_img4' => 'nullable|file|image|mimes:png,gif,jpeg,jpg|max:550|dimensions:width=800,height=800',
            'goods_img5' => 'nullable|file|image|mimes:png,gif,jpeg,jpg|max:550|dimensions:width=800,height=800',
            'goods_img6' => 'nullable|file|image|mimes:png,gif,jpeg,jpg|max:550|dimensions:width=800,height=800',
            'is_real' => 'required|in:0,1',
            'is_on_sale' => 'required|in:0,1',
            'is_alone_sale' => 'required|in:0,1',
            'is_best' => 'required|in:0,1',
            'is_new' => 'required|in:0,1',
            'is_hot' => 'required|in:0,1',
            'is_promote' => 'required|in:0,1',
            'integral' => 'nullable|integer',
            'sort_order' => 'nullable|integer',
            'give_integral' => 'nullable|integer',
            'keywords' => 'nullable|string',
            'goods_desc' => 'nullable',
        ];
        $message = [
            'goods_name.required' => '名称不能为空',
            'goods_name.string' => '名称长度为1到15位字节组成',
            'goods_name.between' => '名称长度为1到15位字节组成',
            'cate_id.exists' => '商品类别不存在',
            'type_id.exists' => '商品类别不存在',
            'brand.exists' => '商品类别不存在',
            'inventory.integer' => '库存数据必须为整数',
            'warn_num.integer' => '警戒量必须为整数',
            'goods_weight.numeric' => '重量有误',
            'market_price.numeric' => '重量有误',
            'shop_price.numeric' => '重量有误',
            'promote_price.numeric' => '重量有误',
            'promote_start_at.data' => '重量有误',
            'promote_end_at.data' => '重量有误',
            'goods_thumb.mimes' => '缩略图格式为png,gif,jpeg,jpg',
            'goods_thumb.max' => '缩略图不超过100kb',
            'goods_thumb.dimensions' => '缩略图宽高各为300',
            'goods_img1.mimes' => '图片1格式为png,gif,jpeg,jpg',
            'goods_img1.max' => '图片1不超过550kb',
            'goods_img1.dimensions' => '图片1宽高各为800',
            'goods_img2.mimes' => '图片2格式为png,gif,jpeg,jpg',
            'goods_img2.max' => '图片2不超过5500kb',
            'goods_img2.dimensions' => '图片2宽高各为800',
            'goods_img3.mimes' => '图片3格式为png,gif,jpeg,jpg',
            'goods_img3.max' => '图片3不超过5500kb',
            'goods_img3.dimensions' => '图片3宽高各为800',
            'goods_img4.mimes' => '图片4格式为png,gif,jpeg,jpg',
            'goods_img4.max' => '图片4不超过5500kb',
            'goods_img4.dimensions' => '图片4宽高各为800',
            'goods_img5.mimes' => '图片5格式为png,gif,jpeg,jpg',
            'goods_img5.max' => '图片5不超过5500kb',
            'goods_img5.dimensions' => '图片5宽高各为800',
            'goods_img6.mimes' => '图片6格式为png,gif,jpeg,jpg',
            'goods_img6.max' => '图片6不超过5500kb',
            'goods_img6.dimensions' => '图片6宽高各为800',
            'is_real.in' => '是否为实物数据有误',
            'is_on_sale.in' => '是否在售数据有误',
            'is_alone_sale.in' => '能否单独售卖数据有误',
            'is_best.in' => '是否是精品数据有误',
            'is_new.in' => '是否新品数据有误',
            'is_hot.in' => '是否热销数据有误',
            'is_promote.in' => '是否特价促销数据有误',
            'integral.integer' => '所需积分必须为整数',
            'sort_order.integer' => '排序字段必须为整数',
            'goods_desc.string' => '描述的值必须为字符串格式',
            'give_integral.integer' => '赠送积分必须为整数',
        ];
        $validator = Validator::make($data, $role, $message);
        if ($validator->fails()) {
            return ['status' => 'fail', 'msg' => $validator->messages()->first()];
        }
        $tf1 = uploadPic('goods_thumb','uploads/frontend/goods/'.date('Ymd'));
        if($tf1){
            $data['goods_thumb'] = $tf1;
        }else{
            return ['status' => "fail", 'msg' => '缩略图添加失败'];
        }
        $tf2 = uploadPic('goods_img1','uploads/frontend/goods/'.date('Ymd'));
        if($tf2){
            $goods_img[] = $tf2;
        }else{
            @unlink($tf1);
            return ['status' => "fail", 'msg' => '图片1添加失败'];
        }
        if(!empty($data['goods_img2'])){
            $tf3 = uploadPic('goods_img2','uploads/frontend/goods/'.date('Ymd'));
            if($tf3){
                $goods_img[] = $tf3;
            }else{
                @unlink($tf1);
                @unlink($tf2);
                return ['status' => "fail", 'msg' => '图片2添加失败'];
            }
        }
        if(!empty($data['goods_img3'])){
            $tf4 = uploadPic('goods_img3','uploads/frontend/goods/'.date('Ymd'));
            if($tf4){
                $goods_img[] = $tf4;
            }else{
                @unlink($tf1);
                @unlink($tf2);
                @unlink($tf3);
                return ['status' => "fail", 'msg' => '图片3添加失败'];
            }
        }
        if(!empty($data['goods_img4'])){
            $tf5 = uploadPic('goods_img4','uploads/frontend/goods/'.date('Ymd'));
            if($tf5){
                $goods_img[] = $tf5;
            }else{
                @unlink($tf1);
                @unlink($tf2);
                @unlink($tf3);
                @unlink($tf4);
                return ['status' => "fail", 'msg' => '图片4添加失败'];
            }
        }
        if(!empty($data['goods_img5'])){
            $tf6 = uploadPic('goods_img5','uploads/frontend/goods/'.date('Ymd'));
            if($tf6){
                $goods_img[] = $tf6;
            }else{
                @unlink($tf1);
                @unlink($tf2);
                @unlink($tf3);
                @unlink($tf4);
                @unlink($tf5);
                return ['status' => "fail", 'msg' => '图片5添加失败'];
            }
        }
        if(!empty($data['goods_img6'])){
            $tf7 = uploadPic('goods_img6','uploads/frontend/goods/'.date('Ymd'));
            if($tf7){
                $goods_img[] = $tf7;
            }else{
                @unlink($tf1);
                @unlink($tf2);
                @unlink($tf3);
                @unlink($tf4);
                @unlink($tf5);
                @unlink($tf6);
                return ['status' => "fail", 'msg' => '图片6添加失败'];
            }
        }
        $data['goods_img'] = json_encode($goods_img, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);

        $res = $goods->create($data);
        if ($res->id) {
            // 如果添加数据成功，则返回列表页
            return ['status' => "success", 'msg' => '新增数据成功'];
        }else{
            @unlink($tf1);
            @unlink($tf2);
            @unlink($tf3);
            @unlink($tf4);
            @unlink($tf5);
            @unlink($tf6);
            @unlink($tf7);
            return ['status' => 'fail', 'msg' => '新增数据添加失败'];
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
