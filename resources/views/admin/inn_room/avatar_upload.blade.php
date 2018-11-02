<!doctype html>
<html lang="zh">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name='viewport' content='user-scalable=no,width=750'>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>修改头像</title>
    <link rel="stylesheet" href="{{asset('bower_components/bootstrap/dist/css/bootstrap.min.css')}}">
    <link href="{{asset('plugins/cropper/cropper.css')}}" rel="stylesheet">
    <link href="{{asset('plugins/cropper/admin_cropper.css')}}" rel="stylesheet">
    <!--[if IE]>
    <script src="http://libs.useso.com/js/html5shiv/3.7/html5shiv.min.js"></script>
    <![endif]-->
    <style>
        .tooltip-inner{
            display: none;}
        .btn{
            font-size: 12px;
            width:80px;
            height:20px;
            line-height: 10px;
            border-radius: 2px;
        }
        .back{
            background: rgba(102,102,102,0.38);
            width:100%;
            height: 100%;
            margin:20px auto;
        }
    </style>
</head>
<body>
<div class="htmleaf-container">
    <!-- Content -->
    <div class="container">
        <div class="row">
            <div class="col-md-9">
                <!-- <h3 class="page-header">Demo:</h3> -->
                <div class="img-container back">
                    <img id="image" alt="">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-9 docs-buttons" style="text-align: center;">
                <!-- <h3 class="page-header">Toolbar:</h3> -->
                <div class="btn-group btn-group-crop">
                    <label class="btn btn-primary btn-upload" for="inputImage" title="上传图片">
                        <input class="sr-only" id="inputImage" name="file" type="file" accept="image/*">
                        选择图片
                    </label>
                </div>
                <div class="btn-group btn-group-crop">
                    <button class="btn btn-primary" data-method="rotate" data-option="90" type="button" title="Rotate Right">
                        旋转 90º
                    </button>
                </div>
                <div class="btn-group btn-group-crop">
                    <button class="btn btn-primary" data-method="getCroppedCanvas" data-option="{ &quot;width&quot;: 180, &quot;height&quot;: 90 }" type="button">
                        上传头像
                    </button>
                </div>

                <!-- Show the cropped image in modal -->
                <div class="modal fade docs-cropped" id="getCroppedCanvasModal" aria-hidden="true" aria-labelledby="getCroppedCanvasTitle" role="dialog" tabindex="-1">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button class="close" data-dismiss="modal" type="button" aria-hidden="true">&times;</button>
                                <h4 class="modal-title" id="getCroppedCanvasTitle">Cropped</h4>
                            </div>
                            <div class="modal-body"></div>
                            <div class="modal-footer">
                                <button class="btn btn-primary" data-dismiss="modal" type="button">Close</button>
                                <a class="btn btn-primary" id="download" href="javascript:void(0);">Download</a>
                            </div>
                        </div>
                    </div>
                </div><!-- /.modal -->

            </div><!-- /.docs-buttons -->
        </div>
    </div>
    <!-- Alert -->
    <div class="tip">
    </div>
</div>
<!-- jQuery 3 -->
<script src="{{asset('bower_components/jquery/dist/jquery.min.js')}}"></script>
<!-- Bootstrap 3.3.7 -->
<script src="{{asset('bower_components/bootstrap/dist/js/bootstrap.min.js')}}"></script>
<script src="{{asset('plugins/cropper/cropper.js')}}"></script>
<script src="{{asset('plugins/cropper/admin_cropper.js')}}"></script>
<script type="text/javascript" src="{{ asset('plugins/layer/layer.js')}}"></script>
<script type="text/javascript" src="{{ asset('plugins/layer/admin_layer.js')}}"></script>
<script>
    $.ajaxSetup({
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
    });

</script>
</body>
</html>