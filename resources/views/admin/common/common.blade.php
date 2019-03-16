<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>CQ | Admin</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link rel="stylesheet" href="{{asset('bower_components/bootstrap/dist/css/bootstrap.min.css')}}">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{asset('bower_components/font-awesome/css/font-awesome.min.css')}}">
    <!-- Ionicons -->
    <link rel="stylesheet" href="{{asset('bower_components/Ionicons/css/ionicons.min.css')}}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{asset('dist/css/AdminLTE.min.css')}}">
    <!-- AdminLTE Skins. We have chosen the skin-blue for this starter
          page. However, you can choose any other skin. Make sure you
          apply the skin class to the body tag so the changes take effect. -->
    <link rel="stylesheet" href="{{asset('dist/css/skins/skin-blue.min.css')}}">
@yield('css')
<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <!-- Google Font -->
    {{--<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">--}}
</head>
<!--
BODY TAG OPTIONS:
=================
Apply one or more of the following classes to get the
desired effect
|---------------------------------------------------------|
| SKINS         | skin-blue                               |
|               | skin-black                              |
|               | skin-purple                             |
|               | skin-yellow                             |
|               | skin-red                                |
|               | skin-green                              |
|---------------------------------------------------------|
|LAYOUT OPTIONS | fixed                                   |
|               | layout-boxed                            |
|               | layout-top-nav                          |
|               | sidebar-collapse                        |
|               | sidebar-mini                            |
|---------------------------------------------------------|
-->
<body class="hold-transition skin-blue sidebar-mini fixed">
@yield('content')

<!-- ./wrapper -->
</body>

<!-- jQuery 3 -->
<script src="{{asset('bower_components/jquery/dist/jquery.min.js')}}"></script>
<!-- Bootstrap 3.3.7 -->
<script src="{{asset('bower_components/bootstrap/dist/js/bootstrap.min.js')}}"></script>
<script src="{{asset('plugins/bootstrap-slider/bootstrap-slider.js')}}"></script>
<!-- AdminLTE App -->
<script src="{{asset('dist/js/adminlte.min.js')}}"></script>
<!-- Datatables -->
<script src="{{asset('bower_components/datatables.net/js/jquery.dataTables.js')}}"></script>
<!-- layer -->
<script type="text/javascript" src="{{ asset('plugins/layer/layer.js')}}"></script>
<script type="text/javascript" src="{{ asset('plugins/layer/admin_layer.js')}}"></script>
<!-- icheck -->
{{--<script type="text/javascript" src="{{ asset('plugins/iCheck/icheck.min.js')}}"></script>--}}

<!-- JS脚本 -->
<script>
    /** 菜单记忆功能JS */
    var url = window.location;
    $('ul.sidebar-menu a').filter(function() {
        return this.href == url;
    }).parent().siblings().removeClass('active').end().addClass('active');
    $('ul.treeview-menu a').filter(function() {
        return this.href == url;
    }).parentsUntil(".sidebar-menu > .treeview-menu").siblings().removeClass('active').end().addClass('active');
    /**新消息提醒*/
    var role_class_now = "<?php echo(Auth::guard('admin')->user()->role_class); ?>";//当前用户role_class
    if (role_class_now == '1') {//单店商户
        var func = function (){
            $.ajax({
                type:'POST',
                url:'{{ url('admin/order_notice') }}',
                dataType:'json',
                success:function(data){
                    console.log(JSON.stringify(data));
                    if(data.status_code == 1)
                    {
                        playSound();
                    }
                }
            });
        }
        var playSound = function()
        {
            var borswer = window.navigator.userAgent.toLowerCase();
            if ( borswer.indexOf( "ie" ) >= 0 )
            {
                //IE内核浏览器
                var strEmbed = '<embed name="embedPlay" src="{{ url('system_static_file/sound/ding.wav') }}" autostart="true" hidden="true" loop="false"></embed>';
                if ( $( "body" ).find( "embed" ).length <= 0 )
                    $( "body" ).append( strEmbed );
                var embed = document.embedPlay;

                //浏览器不支持 audion，则使用 embed 播放
                embed.volume = 100;
                //embed.play();
            } else
            {
                //非IE内核浏览器
                var strAudio = "<audio id='audioPlay' src='{{ url('system_static_file/sound/ding.wav') }}' hidden='true'>";
                if ( $( "body" ).find( "audio" ).length <= 0 )
                    $( "body" ).append( strAudio );
                var audio = document.getElementById( "audioPlay" );

                //浏览器支持 audion
                audio.play();
            }
        }
        setInterval("func()", 30000);
    }
</script>
@yield('script')
<!--您可以选择添加Slimscroll和FastClick插件。推荐使用这两个插件来增强用户体验 -->
</html>