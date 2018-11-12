<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>AdminLTE 2 | Log in</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="{{asset('bower_components/bootstrap/dist/css/bootstrap.min.css')}}">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{asset('bower_components/font-awesome/css/font-awesome.min.css')}}">
  <!-- Ionicons -->
  <link rel="stylesheet" href="{{asset('bower_components/Ionicons/css/ionicons.min.css')}}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{asset('dist/css/AdminLTE.min.css')}}">
  <!-- iCheck -->
  <link rel="stylesheet" href="{{asset('plugins/iCheck/square/blue.css')}}">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo">
    <a href="#"><b>CQ-欢迎登陆</b></a>
  </div>
  <!-- /.login-logo -->
  <div class="login-box-body">
    <p class="login-box-msg"></p>
    <form action="{{ url('login') }}" method="post" id="form-user-log">
      {{ csrf_field() }}
      <div class="form-group has-feedback">
        <input type="text" class="form-control" placeholder="邮箱" name="username">
        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
      </div>
      <div class="form-group has-feedback">
        <input type="password" class="form-control" placeholder="密码" name="password">
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
      </div>
      <div class="row">
        <div class="col-xs-8">
          <div class="checkbox icheck">
            <label>
              <input type="checkbox" name=""> 记住登陆
            </label>
          </div>
        </div>
        <!-- /.col -->
        <div class="col-xs-4">
          <button type="submit" class="btn btn-primary btn-block btn-flat">登 陆</button>
        </div>
        <!-- /.col -->
      </div>
    </form>

    <div class="social-auth-links text-center">
      <p></p>
      <a href="#" class="btn btn-block btn-social btn-info btn-flat"><i class="fa fa-phone"></i>手机登录</a>
      <a href="#" class="btn btn-block btn-social btn-success btn-flat"><i class="fa fa-weixin"></i>微信登陆</a>
    </div>
    <!-- /.social-auth-links -->

    <a href="#">忘记密码</a><br>

  </div>
  <!-- /.login-box-body -->
</div>
<!-- /.login-box -->

<!-- jQuery 3 -->
<script src="{{asset('bower_components/jquery/dist/jquery.min.js')}}"></script>
<!-- Bootstrap 3.3.7 -->
<script src="{{asset('bower_components/bootstrap/dist/js/bootstrap.min.js')}}"></script>
<!-- iCheck -->
<script src="{{asset('plugins/iCheck/icheck.min.js')}}"></script>
<script type="text/javascript" src="{{ asset('plugins/validation/jquery.validate.js')}}"></script>
<script type="text/javascript" src="{{ asset('plugins/validation/validate-methods.js')}}"></script>
<script type="text/javascript" src="{{ asset('plugins/validation/messages_zh.js')}}"></script>
<script type="text/javascript" src="{{ asset('plugins/layer/layer.js')}}"></script>
<script type="text/javascript" src="{{ asset('plugins/jQueryUI/jquery.form.js')}}"></script>
<script>
  $(function () {
    $('input').iCheck({
      checkboxClass: 'icheckbox_square-blue',
      radioClass: 'iradio_square-blue',
      increaseArea: '20%' /* optional */
    });
      $("#form-user-log").validate({
          rules:{//规则
              username:{
                  rangelength:[5,12]
              },
              password:{
                  rangelength:[5,20]
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
                      layer.msg(msg.msg, {
                          skin: 'layer-ext-moon'
                      });
                  }else{//登陆成功
                      window.location.href="{{ url('/') }}";
                  }
              });
          }
      });
  });
</script>
</body>
</html>
