@extends('admin.common.common')

@section('title')

@endsection

@section('css')
    <link rel="stylesheet" href="{{asset('bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css')}}">
@endsection

@section('content')
    <div class="wrapper">
        <!-- 顶部主菜单 -->
    @include('admin.common.header')
    <!-- 左侧菜单栏：包含标志和侧栏 -->
    @include('admin.common.sidebar')
    <!-- 内容容器开始（包含页面内容） -->
        <div class="content-wrapper">
            <!-- 内容页眉标题 -->
            <section class="content-header">
                <h1>
                    用户管理
                    <small>首页</small>
                </h1>
                <ol class="breadcrumb">
                    <li><a href="{{ url('admin/index') }}"><i class="fa fa-dashboard"></i>系统首页</a></li>
                    <li class="active">用户管理</li>
                </ol>
            </section>
            <!-- 主要内容 -->
            <section class="content container-fluid">
                <!--------------------------
                |   你的页面内容放在这里   |
                -------------------------->
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">系统管理员表</h3>
                        <a class="btn btn-box-tool btn-xs"  href="javascript:;" onclick="admin_add('添加','{{ url('admin/user/create')  }}','800','500')" id="a-admin-add">
                            <font style="vertical-align:inherit; color:#3c8dbc;"><font style="font-size:14px;"><i class="fa fa-fw fa-user-plus"></i>添加用户</font></font>
                        </a>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <div id="example1_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
                            <div class="row">
                                <div class="col-sm-12">
                                    <table id="dataTables" class="table table-bordered table-striped dataTable" role="grid" aria-describedby="dataTables_info" style="width:100%">
                                        <thead>
                                        <tr role="row">
                                            <th class="sorting_asc" tabindex="0">
                                                ID
                                            </th>
                                            <th class="sorting" tabindex="1">
                                                头像
                                            </th>
                                            <th class="sorting" tabindex="2">
                                                昵称
                                            </th>
                                            <th class="sorting td-manage" tabindex="3">
                                                手机
                                            </th>
                                            <th class="sorting" tabindex="4">
                                                状态
                                            </th>
                                            <th class="sorting" tabindex="5">
                                                积分
                                            </th>
                                            <th class="sorting" tabindex="6">
                                                等级
                                            </th>
                                            <th class="sorting" tabindex="7">
                                                最后登陆时间
                                            </th>
                                            <th class="sorting" tabindex="8">
                                                备注
                                            </th>
                                            <th class="sorting" tabindex="9">
                                                删除时间
                                            </th>
                                            <th class="sorting td-manage" tabindex="10">
                                                操作
                                            </th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr role="row">
                                            <td class="sorting_1">id</td>
                                            <td>username</td>
                                            <td>avatar</td>
                                            <td>status</td>
                                            <td>role_id</td>
                                            <td>agency_id</td>
                                            <td>last_login</td>
                                            <td>last_login</td>
                                            <td>note</td>
                                            <td>deleted_at</td>
                                            <td class="td-manage">do</td>
                                        </tr>
                                        </tbody>
                                        <tfoot>
                                        <tr role="row">
                                            <th class="sorting_asc">
                                                ID
                                            </th>
                                            <th class="sorting">
                                                头像
                                            </th>
                                            <th class="sorting">
                                                昵称
                                            </th>
                                            <th class="sorting td-manage">
                                                手机
                                            </th>
                                            <th class="sorting">
                                                状态
                                            </th>
                                            <th class="sorting">
                                                积分
                                            </th>
                                            <th class="sorting">
                                                等级
                                            </th>
                                            <th class="sorting">
                                                最后登陆时间
                                            </th>
                                            <th class="sorting">
                                                备注
                                            </th>
                                            <th class="sorting">
                                                删除时间
                                            </th>
                                            <th class="sorting td-manage">
                                                操作
                                            </th>
                                        </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.box-body -->
                </div>

            </section>
            <!-- /.主要内容结束 -->
        </div>
        <!-- /.内容容器结束 -->

        <!-- 页脚 -->
        @include('admin.common.footer');

        <!-- 控制台 -->
        @include('admin.common.control');
        <!-- /.control-sidebar -->
        <!-- 添加侧边栏的背景。必须放置此div在控件侧边栏之后 -->
        <div class="control-sidebar-bg"></div>
    </div>
@endsection

@section('script')
    <script type="text/javascript" src="{{ asset('bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js')}}"></script>
    <script>
        $(function (){
            /** database 插件  */
            $('#dataTables').DataTable({
                "lengthMenu":[[10,20,50,-1],[10,20,50,'全部']],
                'paging':true,//分页
                'info':true,//分页辅助
                'searching':true,//既时搜索
                'ordering':true,//启用排序
                "order": [[ 0, "desc" ]],//排序规则  默认下标为1的显示倒序
                "processing":true,//当表格在处理的时候（比如排序操作）是否显示“处理中...”
                "stateSave":true,//是否开启状态保存,这样当终端用户重新加载这个页面的时候可以使用以前的设置
                "serverSide": false,//是否开启服务端
                "columnDefs": [{//设置不需要排序的字段
                    "targets": [1,2,-1],
                    "orderable": false
                }],
                "ajax": {
                    "url": "{{ url('admin/user') }}",// 服务端uri地址，显示数据的uri
                    "type": "get",   // ajax 的http请求类型
                    'headers': { 'X-CSRF-TOKEN' : '{{ csrf_token() }}' },
                },
                'columns':[//按列显示从服务器端过来的数据
                    {'data':'id',"defaultContent": ""},
                    {'data':'',"defaultContent": ""},
                    {'data':'nickname',"defaultContent": ""},
                    {'data':'phone',"defaultContent": ""},
                    {'data':'',"defaultContent": ""},
                    {'data':'integral',"defaultContent": "0"},
                    {'data':'user_level',"defaultContent": ""},
                    {'data':'last_login',"defaultContent": ""},
                    {'data':'note',"defaultContent": ""},
                    {'data':'deleted_at',"defaultContent": ""},
                    {'data':'b',"defaultContent": ""},
                ],
                language: {//汉化显示
                    "sProcessing": "处理中...",
                    "sLengthMenu": "每页 _MENU_ 条记录",
                    "sZeroRecords": "没有匹配结果",
                    "sInfo": "显示第 _START_ 至 _END_ 项结果，共 _TOTAL_ 项",
                    "sInfoEmpty": "显示第 0 至 0 项结果，共 0 项",
                    "sInfoFiltered": "(由 _MAX_ 项结果过滤)",
                    "sInfoPostFix": "",
                    "sSearch": "搜索:",
                    "sUrl": "",
                    "sEmptyTable": "表中数据为空",
                    "sLoadingRecords": "载入中...",
                    "sInfoThousands": ",",
                    "oPaginate": {
                        "sFirst": "首页",
                        "sPrevious": "上页",
                        "sNext": "下页",
                        "sLast": "末页"
                    },
                    "oAria": {
                        "sSortAscending": ": 以升序排列此列",
                        "sSortDescending": ": 以降序排列此列"
                    }
                },
                'createdRow':function ( row,data,dataIndex ) {
                    var cnt = data.recordsFiltered;//分页数据
                    $('#coutent').html( cnt );
                    $(row).addClass('text-c');//居中
                    $(row).find('td:eq(1)').html(
                        data.avatar ==
                        null ? '<img src="{{ url('sys_img/user_avatar.png') }}" style="width: 50px;height: 40px;">' : '<img src="/'+ data.avatar +'" style="width: 50px;height: 40px;">'
                    );
                    $(row).find('td:eq(4)').html(
                        data.user_status==0 ? '<font style="vertical-align:inherit; color:green;">未审核</font>' :
                            data.user_status==1 ? '<font style="vertical-align:inherit; color:blue;">已通过</font>' :
                                data.user_status==-1 ? '<font style="vertical-align:inherit; color:grey;">已停止</font>' :
                                    '<font style="vertical-align:inherit; color:red;">拒绝</font>'
                    );//z状态
                    //操作
                    $(row).find('td:eq(-1)').html(
                        '<div class="btn-group">' +
                        '<button type="button" class="btn btn-info" onclick="admin_edit(' + '\'编辑\',\'/admin/user/'+data.id+'/edit\',\''+data.id+'\')" >' +
                        '<font style="vertical-align: inherit;"><font style="vertical-align: inherit;">编辑</font></font>' +
                        '</button>' +
                        '<button type="button" class="btn btn-danger" onclick="admin_del(this,\''+data.id+'\',\''+data.nickname+'\')" >' +
                        '<font style="vertical-align: inherit;"><font style="vertical-align: inherit;">删除</font></font>' +
                        '</button>' +
                        '<button type="button" class="btn btn-warning" onclick="admin_restore(this,\''+data.id+'\',\''+data.nickname+'\')">' +
                        '<font style="vertical-align: inherit;"><font style="vertical-align: inherit;">恢复</font></font>' +
                        '</button>' +
                        '</div>'
                    ).attr('class','td-manage');
                }
            });
        });
        /*管理员-管理员-添加*/
        function admin_add(title,url,w,h){
            layer_show(title,url,'1200','800');
        }
        /*管理员-管理员-编辑*/
        function admin_edit(title,url,id,w,h){
            layer_show(title,url,'1200','800');
        }
        /*管理员-管理员-删除*/
        function admin_del(obj,id,username){
            layer.confirm('<font color="red" >危险！确定删除用户(<b>'+username+'<b/>)吗？</font>',function(index){
                //此处请求后台程序，下方是成功后的前台处理……
                url = '/admin/user/'+ id;
                data = {
                    '_token':'{{ csrf_token() }}',
                    '_method':'delete',
                };
                $.post(url,data,function (msg) {
                    if( msg.status != 'success' ){
                        layer.alert(msg.msg,{
                            icon:5,
                            skin:'layer-ext-moon'
                        })
                    }else{
                        location.reload();
                        $(obj).parents('tr').remove();
                        layer.msg('删除成功',{icon:1,time:1000});
                    }
                });
            });
        }
        /*管理员-管理员-恢复*/
        function admin_restore(obj,id,username){
            layer.confirm('确认要恢复当前用户(<font color="red" ><b>'+username+'<b/></font>)吗？',function(index){
                //此处请求后台程序，下方是成功后的前台处理……
                url = '/admin/user/re_store';
                data = {
                    '_token':'{{ csrf_token()  }}',
                    'id':id,
                    '_method':'post',
                };
                $.post(url,data,function (msg) {
                    if( msg.status != 'success' ){
                        layer.alert(msg.msg,{
                            icon:5,
                            skin:'layer-ext-moon'
                        })
                    }else{
                        location.reload();
                        $(obj).parents('tr').remove();
                        layer.msg('恢复成功',{icon:1,time:1000});
                    }
                });
            });
        }
    </script>
@endsection