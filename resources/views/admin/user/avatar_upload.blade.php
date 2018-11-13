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
<script type="text/javascript" src="{{ asset('plugins/layer/layer.js')}}"></script>
<script type="text/javascript" src="{{ asset('plugins/layer/admin_layer.js')}}"></script>
<script>
    /** 剪切头像js   ***/
    $(function () {
        'use strict';
        var console = window.console || { log: function () {} },
            $alert = $('.docs-alert'),
            $message = $alert.find('.message'),
            showMessage = function (message, type) {
                $message.text(message);

                if (type) {
                    $message.addClass(type);
                }

                $alert.fadeIn();

                setTimeout(function () {
                    $alert.fadeOut();
                }, 3000);
            };
        // Demo
        // -------------------------------------------------------------------------
        (function () {
            var $image = $('.img-container > img'),
                $dataX = $('#dataX'),
                $dataY = $('#dataY'),
                $dataHeight = $('#dataHeight'),
                $dataWidth = $('#dataWidth'),
                $dataRotate = $('#dataRotate'),
                options = {
                    // strict: false,
                    // responsive: false,
                    // checkImageOrigin: false

                    // modal: false,
                    // guides: false,
                    // highlight: false,
                    // background: false,

                    // autoCrop: false,
                    // autoCropArea: 0.5,
                    // dragCrop: false,
                    // movable: false,
                    // resizable: false,
                    // rotatable: false,
                    // zoomable: false,
                    // touchDragZoom: false,
                    // mouseWheelZoom: false,

                    // minCanvasWidth: 320,
                    // minCanvasHeight: 180,
                    // minCropBoxWidth: 160,
                    // minCropBoxHeight: 90,
                    // minContainerWidth: 320,
                    // minContainerHeight: 180,

                    // build: null,
                    // built: null,
                    // dragstart: null,
                    // dragmove: null,
                    // dragend: null,
                    // zoomin: null,
                    // zoomout: null,

                    aspectRatio: 1 / 1,
                    preview: '.img-preview',
                    crop: function (data) {
                        $dataX.val(Math.round(data.x));
                        $dataY.val(Math.round(data.y));
                        $dataHeight.val(Math.round(data.height));
                        $dataWidth.val(Math.round(data.width));
                        $dataRotate.val(Math.round(data.rotate));
                    }
                };

            $image.on({
                'build.cropper': function (e) {
                    console.log(e.type);
                },
                'built.cropper': function (e) {
                    console.log(e.type);
                },
                'dragstart.cropper': function (e) {
                    console.log(e.type, e.dragType);
                },
                'dragmove.cropper': function (e) {
                    console.log(e.type, e.dragType);
                },
                'dragend.cropper': function (e) {
                    console.log(e.type, e.dragType);
                },
                'zoomin.cropper': function (e) {
                    console.log(e.type);
                },
                'zoomout.cropper': function (e) {
                    console.log(e.type);
                }
            }).cropper(options);


            // Methods
            $(document.body).on('click', '[data-method]', function () {
                var data = $(this).data(),
                    $target,
                    result;

                if (data.method) {
                    data = $.extend({}, data); // Clone a new one

                    if (typeof data.target !== 'undefined') {
                        $target = $(data.target);

                        if (typeof data.option === 'undefined') {
                            try {
                                data.option = JSON.parse($target.val());
                            } catch (e) {
                                console.log(e.message);
                            }
                        }
                    }

                    result = $image.cropper(data.method, data.option);

                    if (data.method === 'getCroppedCanvas') {
//          $('#getCroppedCanvasModal').modal().find('.modal-body').html(result);
//          alert(result.toDataURL('image/jpeg'));
//          $.post('/index.php/sdasdf',result.toDataURL('image/jpeg'),function(){},'json');
                        var imgBase=result.toDataURL('image/jpeg');
                        if(imgBase!=""){
                            var data = {imgBase: imgBase};
                            $.post('../admin/avatar_upload', data, function (ret) {//头像上传请求地址
                                    if(ret.status == 'success'){
                                        layer.msg(ret.msg);
                                        // console.log(ret.value);//头像地址
                                        console.log(ret.msg);//头像地址
                                        parent.location.reload();
                                        var index = parent.layer.getFrameIndex(window.name);
                                        parent.layer.close(index);//关闭当前弹窗 刷新父级窗口
                                    }else{
                                        layer.msg(ret.msg);//上传失败
                                    }
                                },
                                'json');
                        }
                    }

                    if ($.isPlainObject(result) && $target) {
                        try {
                            $target.val(JSON.stringify(result));
                        } catch (e) {
                            console.log(e.message);
                        }
                    }

                }
            }).on('keydown', function (e) {

                switch (e.which) {
                    case 37:
                        e.preventDefault();
                        $image.cropper('move', -1, 0);
                        break;

                    case 38:
                        e.preventDefault();
                        $image.cropper('move', 0, -1);
                        break;

                    case 39:
                        e.preventDefault();
                        $image.cropper('move', 1, 0);
                        break;

                    case 40:
                        e.preventDefault();
                        $image.cropper('move', 0, 1);
                        break;
                }

            });


            // Import image
            var $inputImage = $('#inputImage'),
                URL = window.URL || window.webkitURL,
                blobURL;

            if (URL) {
                $inputImage.change(function () {
                    var files = this.files,
                        file;

                    if (files && files.length) {
                        file = files[0];

//          if (/^image\/\w+$/.test(file.type)) {
                        blobURL = URL.createObjectURL(file);
                        $image.one('built.cropper', function () {
                            URL.revokeObjectURL(blobURL); // Revoke when load complete
                        }).cropper('reset', true).cropper('replace', blobURL);
                        $inputImage.val('');
//          } else {
//            showMessage('Please choose an image file.');
//          }
                    }
                });
            } else {
                $inputImage.parent().remove();
            }


            // Options
            $('.docs-options :checkbox').on('change', function () {
                var $this = $(this);

                options[$this.val()] = $this.prop('checked');
                $image.cropper('destroy').cropper(options);
            });


            // Tooltips
            $('[data-toggle="tooltip"]').tooltip();

        }());

    });

    function timer(nexturl) {
        var timer = setInterval(function () {
            $('.tip').hide();
            clearInterval(timer);
            if (nexturl == "" || nexturl == null) {

            } else {
                window.location.href = nexturl;
            }
        }, 1000);
    }
    $.ajaxSetup({
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
    });
</script>
</body>
</html>