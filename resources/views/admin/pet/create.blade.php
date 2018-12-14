@extends('admin.common.common')

@section('title')

@endsection

@section('css')
    <style>
        .error{color:red;}
    </style>
@endsection

@section('content')
    <div class="cl-sm-12">
        <!-- /.box-header -->
        <!-- form start -->
        <form class="form-horizontal" id="form-table1" action="{{ url('admin/pet') }}" method="post" enctype="multipart/form-data">
            {{ csrf_field() }}
            <div class="box-body">
                <div class="form-group">
                    <label class="col-sm-2 control-label">宠物相片</label>
                    <div class="col-sm-10">
                        <input type="file" accept="image/png, image/jpeg, image/gif, image/jpg" class="filepath" onchange="changepic(this)" name="pet_thump"/><font style="color: red">只能上传高宽各为800，不超过500K的图片</font><br>
                        <img src=""/>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">用户</label>
                    <div class="col-sm-10">
                        <select class="form-control" style="width:70%;" name="user_id">
                            <option value="1">示例用户1</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">宠物名字</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" style="width:70%;display:inline;" placeholder="宠物名字" name="pet_name" id="pet_name"/>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">宠物类型</label>
                    <div class="col-sm-10">
                        <select class="form-control" style="width:70%;" name="pet_category" >
                            <option id="age0" value="0">狗</option>
                            <option id="age1" value="1">猫</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">宠物生日</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" style="width:70%;display:inline;" placeholder="宠物生日" name="birthday"/>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">雄性</font></font></label>
                    <div class="col-sm-10">
                        <div class="col-sm-4 radio">
                            <label>
                                <input type="radio" name="male" value="0">否
                            </label>
                        </div>
                        <div class="col-sm-6 radio">
                            <label>
                                <input type="radio" name="male" value="1">是
                            </label>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">宠物品种</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" style="width:70%;display:inline;" placeholder="宠物名字" name="varieties" id="varieties"/>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">宠物身高</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" style="width:70%;display:inline;" placeholder="宠物身高" name="height"/>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">宠物体重</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" style="width:70%;display:inline;" placeholder="宠物体重" name="weight"/>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">色系</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" style="width:70%;display:inline;" placeholder="色系" name="color"/>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">状态</font></font></label>
                    <div class="col-sm-10">
                        <div class="col-sm-2 radio">
                            <label>
                                <input type="radio" name="status" value="-1">病态
                            </label>
                        </div>
                        <div class="col-sm-2 radio">
                            <label>
                                <input type="radio" name="status" value="0">正常
                            </label>
                        </div>
                        <div class="col-sm-2 radio">
                            <label>
                                <input type="radio" name="status" value="1">优秀
                            </label>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">宠物爱心</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" style="width:70%;display:inline;" placeholder="宠物爱心（满星为10）" name="star"/>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">宠物产地</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" style="width:70%;display:inline;" placeholder="宠物产地" name="born_where"/>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">备注</label>
                    <div class="col-sm-10">
                        <textarea class="textarea" style="width: 70%; height: 150px; font-size: 14px;" placeholder="备注" name="pet_desc"></textarea>
                    </div>
                </div>
            </div>
            <!-- /.box-body -->
            <div class="box-footer">
                <label class="col-sm-2 control-label"></label>
                <div class="col-sm-10">
                    <input type="submit" class="btn btn-primary radius" value="确认提交"/>
                </div>
            </div>
        </form>
    </div>
    </div>
@endsection

@section('script')
    <script type="text/javascript" src="{{ asset('plugins/validation/jquery.validate.js')}}"></script>
    <script type="text/javascript" src="{{ asset('plugins/validation/validate-methods.js')}}"></script>
    <script type="text/javascript" src="{{ asset('plugins/validation/messages_zh.js')}}"></script>
    <script type="text/javascript" src="{{ asset('plugins/layer/layer.js')}}"></script>
    <script type="text/javascript" src="{{ asset('plugins/layer/admin_layer.js')}}"></script>
    <script type="text/javascript" src="{{ asset('plugins/layer/admin_layer.js')}}"></script>
    <script type="text/javascript" src="{{ asset('plugins/jQueryUI/jquery.form.js')}}"></script>
    <script>
        $(function(){
            /***编写Javascript表单验证区域*/
            $("#form-table1").validate({
                rules:{//规则
                    type_name:{
                        required:true,
                        rangelength:[1,12]
                    },
                    mark_up:{
                        maxlength:200,
                    },
                },
                messages: {//自定义提示信息
                },
                onkeyup:false,
                focusCleanup:false,
                errorElement: "span",
                errorPlacement: function(error, element) {//错误信息位置设置方法
                    error.appendTo( element.parent());//这里的element是录入数据的对象
                },
                submitHandler:function(form){
                    $(form).ajaxSubmit(function(msg){
                        if( msg.status != 'success' ){
                            layer.alert(msg.msg, {
                                icon: 5,
                                skin: 'layer-ext-moon'
                            });
                        }else{ // 成功
                            layer.msg(msg.msg, {
                                icon: 1,
                                skin: 'layer-ext-moon'
                            },function(){
                                parent.location.reload();
                                var index = parent.layer.getFrameIndex( window.name );
                                parent.layer.close(index);
                            });
                        }
                    });
                }
            });
        });
        /** 上传图片时生成图片预览 */
        function changepic(obj) {
            var newsrc=getObjectURL(obj.files[0]);
            console.log(obj.id);
            $(obj).siblings('font').remove();
            $(obj).siblings('img').attr({"src":newsrc,height:200,width:200});
        }
        //建立一个可存取到file的url
        function getObjectURL(file) {
            var url = null ;
            // 针对不同浏览器获得url的方法
            if (window.createObjectURL!=undefined) { // basic
                url = window.createObjectURL(file) ;
            } else if (window.URL!=undefined) { // mozilla(firefox)
                url = window.URL.createObjectURL(file) ;
            } else if (window.webkitURL!=undefined) { // webkit or chrome
                url = window.webkitURL.createObjectURL(file) ;
            }
            return url ;
        }
    </script>
@endsection