@extends('admin.common.common')

@section('title')

@endsection

@section('css')
    <link rel="stylesheet" href="{{asset('plugins/timepicker/bootstrap-timepicker.min.css')}}">
    <style>
        .error{color:red;}
    </style>
@endsection

@section('content')
    <div class="cl-sm-12">
        <!-- /.box-header -->
        <!-- form start -->
        <form class="form-horizontal" id="form-inn-add" action="{{ url('admin/inn')  }}" method="post" enctype="multipart/form-data">
            {{ csrf_field() }}
            <input type="hidden" name="adcode" id="adcode"/>
            <br/>
            <div class="form-group">
                <label class="col-sm-2 control-label">门店logo</label>
                <div class="col-sm-10">
                    <input type="file" accept="image/png, image/jpeg, image/gif, image/jpg" class="filepath" onchange="changepic(this)" name="inn_avatar"/><font style="color: red">只能上传高宽各为300，不超过100K的图片</font><br>
                    <img src=""/>
                </div>
            </div>
            <div class="box-body">
                <div class="form-group">
                    <label class="col-sm-2 control-label">门店名称</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" style="width:70%;display:inline;" placeholder="门店名称" name="inn_name" id="inn_name"/>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">门店编号</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" style="width:70%;display:inline;" placeholder="所在市首字母大写+四位门店编号，例：SZ0185"  name="inn_sn" id="inn_sn"/>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">是否直营</label>
                    <div class="col-sm-10">
                        <select class="form-control" style="width:70%;" name="is_self" >
                            <option value="0">否</option>
                            <option value="1" selected>是</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">门店电话</label>
                    <div class="col-sm-10">
                        <input type="tel" class="form-control" style="width:70%;display:inline;" placeholder="门店电话"  name="inn_tel" id="inn_tel"/>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">门店详细地址</label>
                    <div class="col-sm-10">
                        <select class="form-control" style="width:10%;display:inline" id="province" name="province">
                            <option value=null><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">省级</font></font></option>
                        </select>

                        <select class="form-control" style="width:10%;display:inline"  id="city" name="city">
                            <option value=null><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">地级市</font></font></option>
                        </select>
                        <select class="form-control" style="width:10%;display:inline"  id="district" name="district">
                            <option value=null><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">区/县级</font></font></option>
                        </select>
                        <input type="tel" class="form-control" style="width:39%;display:inline;" placeholder="门店详细地址"  name="inn_address" id="inn_address"/>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">营业时间</label>
                    <div class="col-sm-10">
                        从
                        <input type="text" class="form-control start_time" style="width:30%;display:inline;" placeholder="营业开始时间" name="start_time" id="start_time"/>
                        营业到
                        <input type="text" class="form-control end_time" style="width:30%;display:inline;" placeholder="营业结束时间" name="end_time" id="end_time"/>
                        结束
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">门店状态</font></font></label>
                    <div class="col-sm-10">
                        <select class="form-control" style="width:70%;" name="inn_status">
                            <option value="-2"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">拒绝</font></font></option>
                            <option value="-1"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">已停止</font></font></option>
                            <option value="0" selected><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">未审核</font></font></option>
                            <option value="1"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">已通过</font></font></option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">是否营业中</label>
                    <div class="col-sm-10">
                        <select class="form-control" style="width:70%;" name="is_running" >
                            <option value="0">否</option>
                            <option value="1" selected>是</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">所有者</label>
                    <div class="col-sm-10">
                        <input type="tel" class="form-control" style="width:70%;display:inline;" placeholder="所有者id"  name="admin_id" id="admin_id"/>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">门店详情1</label>
                    <div class="col-sm-10">
                        <input type="file" accept="image/png, image/jpeg, image/gif, image/jpg" class="filepath" onchange="changepic(this)" name="inn_img1"/><font style="color: red">只能上传高宽各为800，不超过550K的图片</font><br>
                        <img src=""/>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">门店详情2</label>
                    <div class="col-sm-10">
                        <input type="file" accept="image/png, image/jpeg, image/gif, image/jpg" class="filepath" onchange="changepic(this)" name="inn_img2"/><font style="color: red">只能上传高宽各为800，不超过550K的图片</font><br>
                        <img src="" />
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">门店详情3</label>
                    <div class="col-sm-10">
                        <input type="file" accept="image/png, image/jpeg, image/gif, image/jpg" class="filepath" onchange="changepic(this)" name="inn_img3"/><font style="color: red">只能上传高宽各为800，不超过550K的图片</font><br>
                        <img src="" />
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">备注</label>
                    <div class="col-sm-10">
                        <textarea class="textarea" style="width: 70%; height: 100px; font-size: 14px;" placeholder="备注" name="note"></textarea>
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
    <script type="text/javascript" src="{{ asset('plugins/jQueryUI/jquery.form.js')}}"></script>
    <script type="text/javascript" src="{{ asset('plugins/timepicker/bootstrap-timepicker.min.js')}}"></script>
    <script>
        /** 上传图片时生成图片预览 */
        function changepic(obj) {
            var newsrc=getObjectURL(obj.files[0]);
            console.log(obj.id);
            $(obj).siblings('font').remove();
            $(obj).siblings('img').attr({"src":newsrc,height:200,width:200});
        }
        function getObjectURL(file) {//建立一个可存取到图片的url
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
        $(function(){
            /***时间插件*/
            $('.start_time').timepicker({
                defaultTime:'9:00',
                showMeridian:false,
            });
            $('.end_time').timepicker({
                defaultTime:'21:00',
                showMeridian:false,
            });
            /***编写省市县三级联动*/
            var i, j, k;
            var province = document.getElementById('province');
            var city = document.getElementById('city');
            var districtDiv = document.getElementById('district');
            var adCodeVal = $('#adcode');
            var url = "{{ asset('local-data/gao-province-city-district.json')}}";//本地数据
            var xhr = new XMLHttpRequest();
            xhr.open('GET', url, true);
            xhr.onreadystatechange = function () {
                if (xhr.readyState === 4) {
                    if (xhr.status === 200) {//请求成功
                        var jsonObj = JSON.parse(xhr.responseText);
                        var provinceList = jsonObj.districts[0].districts;
                        var flag = document.createDocumentFragment();
                        for (i=0; i<provinceList.length; i++) {
                            var option = document.createElement('option');
                            option.innerHTML = provinceList[i].name;
                            flag.appendChild(option);
                        }
                        province.appendChild(flag);
                        province.addEventListener('change', function (e) {
                            if (this.selectedIndex === 0) {
                                city.innerHTML = '<option value=null>地级市</option>';
                                districtDiv.innerHTML = '<option value=null>区/县级</option>';
                            } else {
                                var cityList = provinceList[e.target.selectedIndex-1].districts;
                                city.innerHTML = '<option value=null>地级市</option>';
                                for (j=0; j<cityList.length; j++) {
                                    var option = document.createElement('option');
                                    option.innerHTML = cityList[j].name;
                                    flag.appendChild(option);

                                }
                                city.appendChild(flag);
                            }

                        })
                        city.addEventListener('change', function (e) {
                            if (this.selectedIndex === 0) {
                                districtDiv.innerHTML = '<option value=null>区/县级</option>';
                            } else {
                                var district = provinceList[province.selectedIndex-1].districts[e.target.selectedIndex-1].districts;
                                districtDiv.innerHTML = '<option value=null>区/县级</option>';
                                for (k=0; k<district.length; k++) {
                                    var option = document.createElement('option');
                                    option.innerHTML = district[k].name;
                                    flag.appendChild(option);
                                    adCodeVal.val(district[k].adcode);//记录adcode
                                }
                                districtDiv.appendChild(flag);
                            }
                        })
                    }
                }
            }
            xhr.send();
            /***编写Javascript表单验证区域*/
            $("#form-inn-add").validate({
                rules:{//规则
                    inn_name:{
                        required:true,
                        rangelength:[1,12]
                    },
                    inn_sn:{
                        required:true,
                        rangelength:[5,12],
                    },
                    is_self:{
                        required:true,
                    },
                    inn_status:{
                        required:true,
                    },
                    is_running:{
                        required:true,
                    },
                    password:{
                        required:true,
                        rangelength:[5,20]
                    },
                    inn_tel:{
                        required:true,
                        rangelength:[11,11],
                        digits:true
                    },
                    inn_address:{
                        required:true,
                        rangelength:[3,30],
                    },
                    start_time:{
                        required:true,
                    },
                    end_time:{
                        required:true,
                    },
                    district:{
                        isDistrict:true
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
                            layer.msg('添加成功！', {
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
            //自定义jquery.validate验证规则
            $.validator.addMethod("isDistrict",function(value,element,params){//params错误提示
                var check_rules = /^[\u4e00-\u9fa5]{2,15}/;
                return this.optional(element)||(check_rules.test(value));
            },"请填写地址");

        });
    </script>
@endsection