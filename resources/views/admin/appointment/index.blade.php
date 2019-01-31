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
                    店铺管理
                    <small>预约管理</small>
                </h1>
                <ol class="breadcrumb">
                    <li><a href="{{ url('admin/index') }}"><i class="fa fa-dashboard"></i>系统首页</a></li>
                    <li class="active">预约管理</li>
                </ol>
            </section>
            <!-- 主要内容 -->
            <section class="content container-fluid">
                <!--------------------------
                |   你的页面内容放在这里   |
                -------------------------->
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">预约列表</h3>
                        <a class="btn btn-box-tool btn-xs"  href="javascript:;" onclick="layer_show('添加','{{ url('admin/appointment/create')  }}','1200','800')" id="a-admin-add">
                            <font style="vertical-align:inherit; color:#3c8dbc;"><font style="font-size:14px;"><i class="fa fa-fw fa-plus"></i>新增预约</font></font>
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
                                            <th tabindex="0">
                                                ID
                                            </th>
                                            <th tabindex="1">
                                                宠物名称
                                            </th>
                                            <th tabindex="2">
                                                预约时间
                                            </th>
                                            <th tabindex="3">
                                                服务类型
                                            </th>
                                            <th tabindex="4">
                                                客户基本信息
                                            </th>
                                            <th tabindex="5">
                                               接送地址
                                            </th>
                                            <th tabindex="6">
                                                寄养信息
                                            </th>
                                            <th tabindex="7">
                                                订单号
                                            </th>
                                            <th tabindex="8">
                                                接管状态
                                            </th>
                                            <th tabindex="9">
                                                接待者
                                            </th>
                                            <th tabindex="10">
                                                完成时间
                                            </th>
                                            <th class="td-manage" tabindex="11">
                                                操作
                                            </th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr role="row">
                                            <td class="sorting_1">id</td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td class="td-manage">do</td>
                                        </tr>
                                        </tbody>
                                        <tfoot>
                                        <tr role="row">
                                            <th>
                                                ID
                                            </th>
                                            <th>
                                                宠物名称
                                            </th>
                                            <th >
                                                预约时间
                                            </th>
                                            <th>
                                                服务类型
                                            </th>
                                            <th>
                                                客户基本信息
                                            </th>
                                            <th>
                                                接送地址
                                            </th>
                                            <th>
                                                寄养信息
                                            </th>
                                            <th>
                                                订单号
                                            </th>
                                            <th>
                                                接管状态
                                            </th>
                                            <th>
                                                接待者
                                            </th>
                                            <th>
                                                完成时间
                                            </th>
                                            <th class="td-manage">
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
            /** 时间戳转换为普通日期格式  */
            function getLocalTime(nS) {
                return new Date(parseInt(nS) * 1000).toLocaleString().replace(/:\d{1,2}$/,' ');
            }
            /** database 插件  */
            $('#dataTables').DataTable({
                "lengthMenu":[[10,20,50,-1],[10,20,50,'全部']],
                'paging':true,//分页
                'info':true,//分页辅助
                'searching':true,//既时搜索
                'ordering':false,//启用排序
                "processing":true,//当表格在处理的时候（比如排序操作）是否显示“处理中...”
                "stateSave":true,//是否开启状态保存,这样当终端用户重新加载这个页面的时候可以使用以前的设置
                "serverSide": false,//是否开启服务端
                "ajax": {
                    "url": "{{ url('admin/appointment/') }}",// 服务端uri地址，显示数据的uri
                    "type": "get",   // ajax 的http请求类型
                    'headers': { 'X-CSRF-TOKEN' : '{{ csrf_token() }}' },
                },
                'columns':[//按列显示从服务器端过来的数据
                    {'data':'id',"defaultContent": ""},
                    {'data':'pet_name',"defaultContent": "暂无"},
                    {'data':'start_at',"defaultContent": ""},
                    {'data':'',"defaultContent": ""},
                    {'data':'',"defaultContent": ""},
                    {'data':'',"defaultContent": ""},
                    {'data':'',"defaultContent": ""},
                    {'data':'appointment_number',"defaultContent": ""},
                    {'data':'',"defaultContent": ""},
                    {'data':'provider',"defaultContent": "N/A"},
                    {'data':'deleted_at',"defaultContent": "N/A"},
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
                    //操作
                    $(row).find('td:eq(2)').html(
                        getLocalTime(data.start_at)
                    );
                    $(row).find('td:eq(3)').html(
                        data.appointment_type == 0 ? '寄养' : data.appointment_type == 1 ? '美容' : data.appointment_type == 2 ? '洗澡' : '护理'
                    );
                    $(row).find('td:eq(4)').html(
                        data.user_name + (data.sex==1?'先生':'女士') + data.user_phone
                    );
                    $(row).find('td:eq(5)').html(
                        data.is_pickup ==1 ? (data.province+data.city+data.district+data.address) : '无需接送'
                    );
                    $(row).find('td:eq(6)').html(
                        data.appointment_type ==0 ? ('至'+getLocalTime(data.end_at)) : 'N/A'
                    );
                    $(row).find('td:eq(8)').html(
                        data.appointment_status ==0 ? '<font style="vertical-align:inherit; color:blue;">未完成</font>' : '已完成'
                    );

                    $(row).find('td:eq(-1)').html(
                        '<div class="btn-group">' +
                        '<button type="button" class="btn btn-info" onclick="layer_show(' + '\'编辑\',\'/admin/appointment/'+data.id+'/edit\',1200,800)" >' +
                        '<font style="vertical-align: inherit;">编辑</font>' +
                        '</button>'+
                        '<button type="button" class="btn btn-danger" onclick="do_del(this,\''+data.id+'\',\''+'ID='+data.id+'\',1200,800)" >' +
                        '<font style="vertical-align: inherit;">完成</font>' +
                        '</button>'+
                        '</div>'
                    ).attr('class','td-manage');
                }
            });
        });
        /**完成订单（软删除）*/
        function do_del(obj,id,username){
            layer.prompt({
                title: '请签名确认订单('+username+')为已完成'
            }, function(val, index){
                url = '/admin/appointment/'+ id;
                data = {
                    '_token':'{{ csrf_token() }}',
                    'provider':val,
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
    </script>
@endsection