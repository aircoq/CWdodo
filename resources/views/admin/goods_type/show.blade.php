@extends('admin.common.common')

@section('title')

@endsection

@section('css')
    <link rel="stylesheet" href="{{asset('bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css')}}">
    <style>
        .error{color:red;}
    </style>
@endsection

@section('content')
    <div class="box-header">
        <div class="col-sm-12">
            <select class="form-control" style="width:30%;" id="project">
                <option value="0"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">选择商品类型</font></font></option>
                @foreach ($all_type as $v)
                    <option value="{{ $v['id'] }}">
                        <font style="vertical-align: inherit;"><font style="vertical-align: inherit;">
                                {{ $v['type_name'] }}
                            </font></font>
                    </option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="box-body">
        <div class="col-sm-12">
            <table id="dataTables" class="table table-bordered table-striped dataTable" role="grid" aria-describedby="dataTables_info" style="width:100%">
                <thead>
                <tr role="row">
                    <th class="sorting_asc" tabindex="0">
                        ID
                    </th>
                    <th class="sorting" tabindex="1">
                        商品属性名称
                    </th>
                    <th class="sorting" tabindex="2">
                        属性类型
                    </th>
                    <th class="sorting" tabindex="3">
                        属性录入方式
                    </th>
                    <th class="sorting" tabindex="4">
                        属性可选值
                    </th>
                    <th class="sorting" tabindex="5">
                        删除时间
                    </th>
                    <th style="width:90px" class="sorting td-manage" tabindex="6">
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
                    <td class="td-manage">do</td>
                </tr>
                </tbody>
                <tfoot>
                <tr role="row">
                    <th class="sorting_asc">
                        ID
                    </th>
                    <th class="sorting">
                        商品属性名称
                    </th>
                    <th class="sorting">
                        属性类型
                    </th>
                    <th class="sorting">
                        属性录入方式
                    </th>
                    <th class="sorting">
                        属性可选值
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
@endsection

@section('script')
    <script type="text/javascript" src="{{ asset('bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js')}}"></script>
    <script>

        /** database 插件  */
        var table = $('#dataTables').DataTable({
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
                "url": "{{ url('admin/goods_type/'.$id ) }}",// 服务端uri地址，显示数据的uri
                "type": "get",   // ajax 的http请求类型
                'headers': { 'X-CSRF-TOKEN' : '{{ csrf_token() }}' },
            },
            'columns':[//按列显示从服务器端过来的数据
                {'data':'id',"defaultContent": ""},
                {'data':'attr_name',"defaultContent": ""},
                {'data':'',"defaultContent": ""},
                {'data':'',"defaultContent": ""},
                {'data':'attr_values',"defaultContent": ""},
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
                //操作
                $(row).find('td:eq(2)').html(
                    data.attr_type == 0 ? '单选' : '唯一'
                );
                $(row).find('td:eq(3)').html(
                    data.attr_input_type == 0 ? '手工' : '列表'
                );
                $(row).find('td:eq(-1)').html(
                    '<div class="btn-group">' +
                    '<button type="button" class="btn btn-info" onclick="admin_edit(' + '\'编辑\',\'/admin/goods_attr/'+data.id+'/edit\',\''+data.id+'\')" >' +
                    '<font style="vertical-align: inherit;"><font style="vertical-align: inherit;">编辑</font></font>' +
                    '</button>' +
                    '<button type="button" class="btn btn-danger" onclick="admin_del(this,\''+data.id+'\',\''+data.type_name+'\')" >' +
                    '<font style="vertical-align: inherit;"><font style="vertical-align: inherit;">删除</font></font>' +
                    '</button>' +
                    '</div>'
                ).attr('class','td-manage');
            }
        });
        /**编辑*/
        function admin_edit(title,url,id,w,h){
            layer_show(title,url,'800','500');
        }
        /**删除*/
        function admin_del(obj,id,username){
            layer.confirm('<font color="red" >危险！确定删除(<b>'+username+'<b/>)吗？</font>',function(index){
                //此处请求后台程序，下方是成功后的前台处理……
                url = '/admin/goods_attr/'+ id;
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
        /**动态选择框ajax无刷新*/
        $('#project').change(function() {
        table.ajax.url( "{{ url('admin/goods_type') }}"+'/'+$('#project').val() ).load();
        });
    </script>
@endsection