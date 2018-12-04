@extends('admin.common.common')
<meta name="csrf-token" content="{{ csrf_token() }}">
@section('title')

@endsection

@section('css')
    <!-- bootstrap datepicker -->
    <link rel="stylesheet" href="{{ asset('bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{ asset('bower_components/webuploader/webuploader.css')}}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('bower_components/webuploader/admin_webuploader.css')}}" />
    <style>
        .ui-datepicker-today .ui-state-highlight{
            border: 1px solid #eee;
            color: #f60;
        }
        .ui-datepicker-current-day .ui-state-active{
            border: 1px solid #eee;
            color: #06f;
        }
        .error{color:red;}
    </style>
@endsection

@section('content')
    <form class="form-horizontal" id="form-add" action="{{ url('admin/goods')  }}" method="post" enctype="multipart/form-data">
    {{ csrf_field() }}
    <!-- /.box-header -->
        <!-- form start -->
        <input type="hidden" name="step" value="1"/>
        <input type="hidden" name="id" value="{{ $id }}"/>
        <div class="box-body">
            <div class="cl-sm-12">
                <div class="form-group wu-example" id="uploader">
                    <label class="col-sm-2 control-label">上传图片</label>
                    <div class="col-sm-10">
                        <!--头部，相册选择和格式选择-->
                        <div id="uploader">
                            <div class="queueList">
                                <div style="width:70%;" id="dndArea" class="placeholder">
                                    <div id="filePicker"></div>
                                </div>
                            </div>
                            <div class="statusBar" style="display:none;">
                                <div class="progress">
                                    <span class="text">0%</span>
                                    <span class="percentage"></span>
                                </div><div class="info"></div>
                                <div class="btns">
                                    <div id="filePicker2"></div><div class="uploadBtn">开始上传</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.box-body -->
            {{--<div class="box-footer">--}}
                {{--<label class="col-sm-2 control-label"></label>--}}
                {{--<div class="col-sm-10">--}}
                    {{--<input type="submit" class="btn btn-primary radius" value="确认提交"/>--}}
                {{--</div>--}}
            {{--</div>--}}
        </div>
    </form>
    </div>
    </div>
@endsection

@section('script')
    <script type="text/javascript" src="{{ asset('plugins/layer/layer.js')}}"></script>
    <script type="text/javascript" src="{{ asset('plugins/layer/admin_layer.js')}}"></script>
    <script type="text/javascript" src="{{ asset('plugins/layer/admin_layer.js')}}"></script>
    <!-- Web Uploader -->
    <script src="{{ asset('bower_components/webuploader/webuploader.js')}}"></script>
    <script src="{{ asset('bower_components/webuploader/admin_upload.js')}}"></script>
    <script>
        // $("input[name='promote_end_at']").timepicker({
        //     autoclose: true
        // });
        $(function(){
            /***编写Javascript表单验证区域*/
            $("#form-add").validate({
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
        // var goods_desc = CKEDITOR.instances.content.getData();//提交表单时将goods_desc的内容复制给textarea
        // $('#goods_desc').val(goods_desc);
        // CKEditor.on('instanceReady',function(data) {
        //        CKEditor.setData(data);
        //      }
        //  CKEditor.setData(data);
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    </script>
@endsection