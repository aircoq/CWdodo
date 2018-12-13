@extends('admin.common.common')

@section('title')

@endsection

@section('css')
    <link rel="stylesheet" href="{{ asset('bower_components/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css')}}">
    <style>
        .error{color:red;}
    </style>
@endsection

@section('content')
    <div class="cl-sm-12">
        <!-- /.box-header -->
        <!-- form start -->
        <form class="form-horizontal" id="form-table1" action="{{ url('admin/appointment') }}" method="post" enctype="multipart/form-data">
            {{ csrf_field() }}
            <div class="box-body">
                <div class="form-group">
                    <label class="col-sm-2 control-label">用户</label>
                    <div class="col-sm-10">
                        <select class="form-control" style="width:70%;" name="user_id">
                            <option value="1">示例用户1</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">宠物</label>
                    <div class="col-sm-10">
                        <select class="form-control" style="width:70%;" name="pet_id">
                            @foreach ($pet as $v)
                                <option value="{{ $v['id'] }}">
                                    {{ $v['pet_name'] }}-{{ $v['pet_category']==0 ? '狗' : '猫' }}-{{ $v['male']==0 ? '母' : '公' }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">预约服务类型</label>
                    <div class="col-sm-10">
                        <select class="form-control" style="width:70%;" name="appointment_type" id="appointment_type">
                                <option value="0" selected>寄养</option>
                                <option value="1">洗澡</option>
                                <option value="2">美容</option>
                                <option value="3">SPA</option>
                        </select>
                    </div>
                </div>
                <div class="form-group" id="">
                    <label class="col-sm-2 control-label">预约时间</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" style="width:70%;display:inline;" placeholder="预约时间" name="start_at"/>
                    </div>
                </div>
                <div class="form-group foster">
                    <label class="col-sm-2 control-label">结束时间</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" style="width:70%;display:inline;" placeholder="结束时间" name="end_at"/>
                    </div>
                </div>
                <div class="form-group foster">
                    <label class="col-sm-2 control-label">期间使用食品</label>
                    <div class="col-sm-10">
                        <select class="form-control" style="width:70%;" name="food_id">
                            @foreach ($food as $v)
                                <option value="{{ $v['id'] }}">
                                    {{ $v['food_name'] }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">真实姓名</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" style="width:70%;display:inline;" placeholder="姓名" name="user_name"/>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">性别</label>
                    <div class="col-sm-10">
                        <select class="form-control" style="width:70%;" name="sex" >
                            <option id="sex0" value="0">女生</option>
                            <option id="sex1" value="1">先生</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">手机</label>
                    <div class="col-sm-10">
                        <input type="tel" class="form-control" style="width:70%;display:inline;" placeholder="手机"  name="user_phone" id="user_phone"/>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">是否接送</label>
                    <div class="col-sm-10">
                        <select class="form-control" style="width:70%;" name="is_pickup" id="is_pickup" >
                            <option id="is_pickup0" value="0">否</option>
                            <option id="is_pickup1" value="1" selected>是</option>
                        </select>
                    </div>
                </div>
                <div class="form-group pickup_address">
                    <label class="col-sm-2 control-label">当前地址</label>
                    <div class="col-sm-10">
                        <select class="form-control" style="width:10%;display:inline" id="province" name="province">
                            <option value=null>省级</option>
                        </select>
                        <select class="form-control" style="width:10%;display:inline"  id="city" name="city">
                            <option value=null>地级市</option>
                        </select>
                        <select class="form-control" style="width:10%;display:inline"  id="district" name="district">
                            <option value=null>区/县级</option>
                        </select>
                        <input type="tel" class="form-control" style="width:39%;display:inline;" placeholder="详细地址"  name="address" id="address"/>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">备注</label>
                    <div class="col-sm-10">
                        <textarea class="textarea" style="width: 70%; height: 150px; font-size: 14px;" placeholder="备注" name="mark_up"></textarea>
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
    <!-- bootstrap datetimepicker -->
    <script src="{{ asset('bower_components/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js')}}"></script>
    <script src="{{ asset('bower_components/bootstrap-datetimepicker/js/locales/bootstrap-datetimepicker.zh-CN.js')}}"></script>
    <script>
        $(function(){
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
            /***时间插件*/
            $("input[name='start_at']").datetimepicker({
                language: "zh-CN",
                autoclose: true,//选中之后自动隐藏日期选择框
                clearBtn: true,//清除按钮
                todayBtn: true,//今日按钮
                todayHighlight: true,
                format: "yyyy-mm-dd hh:ii"
            });
            $("input[name='end_at']").datetimepicker({
                language: "zh-CN",
                autoclose: true,//选中之后自动隐藏日期选择框
                clearBtn: true,//清除按钮
                todayBtn: true,//今日按钮
                todayHighlight: true,
                format: "yyyy-mm-dd hh:ii"
            });
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
        /**动态选择框时时刷新*/
        $('#appointment_type').change(function() {
            if($('#appointment_type').val() == 0){
                $('.foster').show();
            }else{
                $('.foster').hide();
            }
        });
        $('#is_pickup').change(function() {
            if($('#is_pickup').val() == 1){
                $('.pickup_address').show();
            }else{
                $('.pickup_address').hide();
            }
        });
    </script>
@endsection