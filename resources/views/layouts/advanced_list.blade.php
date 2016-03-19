@extends('layouts.base')
@section('css')
    <link rel="stylesheet" type="text/css" href="/assets/global/plugins/select2/select2.css"/>
    <link rel="stylesheet" type="text/css" href="/assets/global/plugins/datatables/extensions/Scroller/css/dataTables.scroller.min.css"/>
    <link rel="stylesheet" type="text/css" href="/assets/global/plugins/datatables/extensions/ColReorder/css/dataTables.colReorder.min.css"/>
    <link rel="stylesheet" type="text/css" href="/assets/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.css"/>
@stop
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="portlet box blue">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="{{$icon_title or 'fa fa-list'}}"></i>{{$bar_title or '列表'}}
                    </div>
                    <div class="tools">

                        @if(isset($search_form))
                        <div class="btn btn-xs green-meadow advanced-search-btn">
                            <i class="glyphicon glyphicon-filter"></i>高级筛选
                        </div>
                        @endif
                    </div>
                </div>
                <div class="portlet-body">
                    @if(isset($search_form))
                    <div class="note note-success search-condition" style="display: none;">
                        {!! form_start($search_form,['id'=>'search-form','class'=>"form-horizontal",'method'=>'POST']) !!}
                        {!! form_body($search_form) !!}

                            <div class="row">
                                <div class="col-md-offset-3 col-md-9">
                                    {!! form_rest($search_form) !!}
                                </div>
                            </div>

                        {!! form_end($search_form) !!}
                    </div>
                    @endif
                    @yield('body_top_view_block')
                        <!--
                        <div class="table-toolbar">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="btn-group">
                                        <button id="sample_editable_1_new" class="btn green">
                                            Add New <i class="fa fa-plus"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="btn-group pull-right">
                                        <button class="btn dropdown-toggle" data-toggle="dropdown">Tools <i class="fa fa-angle-down"></i>
                                        </button>
                                        <ul class="dropdown-menu pull-right">
                                            <li>
                                                <a href="javascript:;">
                                                    Print </a>
                                            </li>
                                            <li>
                                                <a href="javascript:;">
                                                    Save as PDF </a>
                                            </li>
                                            <li>
                                                <a href="javascript:;">
                                                    Export to Excel </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        -->
                    <table id="dataTable" class="table table-striped table-bordered table-hover">
                    </table>
                    @yield('body_bottom_view_block')
                </div>
            </div>
        </div>
    </div>
@stop
@section('js')
    <script type="text/javascript" src="/assets/global/plugins/select2/select2.min.js"></script>
    <script type="text/javascript" src="/assets/global/plugins/datatables/media/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="/assets/global/plugins/datatables/extensions/TableTools/js/dataTables.tableTools.min.js"></script>
    <script type="text/javascript" src="/assets/global/plugins/datatables/extensions/ColReorder/js/dataTables.colReorder.min.js"></script>
    <script type="text/javascript" src="/assets/global/plugins/datatables/extensions/Scroller/js/dataTables.scroller.min.js"></script>
    <script type="text/javascript" src="/assets/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.js"></script>
@stop
@section('js_content')
<script>
    $.extend(true, $.fn.DataTable.TableTools.classes, {
        "container": "btn-group tabletools-btn-group pull-right",
        "buttons": {
            "normal": "btn btn-sm default",
            "disabled": "btn btn-sm default disabled"
        }
    });


    var oTable = $('#dataTable').DataTable({
        dom: "<'row' <'col-md-12'T>><'row'<'col-md-6 col-sm-12'l><'col-md-6 col-sm-12'f>r><'table-scrollable't><'row'<'col-md-5 col-sm-12'i><'col-md-7 col-sm-12'p>>",
        processing: true,
        serverSide: true,
        searching: false,//禁用搜索
        "language": {
            "aria": {
                "sortAscending": ": 升序",
                "sortDescending": ": 降序"
            },
            "emptyTable": "No data available in table",
            "infoEmpty": "No entries found",
            "infoFiltered": "(filtered1 from _MAX_ total entries)",
            "lengthMenu": "每页 _MENU_ 条",
            "search": "搜索:",
            "info": "Showing _START_ to _END_ of _TOTAL_ entries",
            "zeroRecords": "No matching records found"
        },
        /*"columnDefs": [{ // set default column settings
            'orderable': false,
            'targets': ['name']
        }, {
            "searchable": true,
            "targets": [0]
        }],*/
        ajax: {
            url: window.location.href,
            data: function (d) {

                var search_vals = $('#search-form').serializeArray();
                for(var i = 0;i<search_vals.length;++i)
                {
                    if(search_vals[i].name == '_token')
                    {
                        continue;
                    }
                    d[search_vals[i].name] = search_vals[i].value;
                }
            }
        },

        tableTools: {
            "sSwfPath": "/assets/global/plugins/datatables/extensions/TableTools/swf/copy_csv_xls_pdf.swf",
            "aButtons": [
                @if(in_array('pdf',$export_type))
                {
                "sExtends": "pdf",
                "sButtonText": "PDF"
            },
                    @endif
                    @if(in_array('csv',$export_type))
                {
                "sExtends": "csv",
                "sButtonText": "CSV"
            },
                @endif
                @if(in_array('xls',$export_type))
                {
                "sExtends": "xls",
                "sButtonText": "Excel"
            },
                    @endif
                    @if($print)

                {
                "sExtends": "print",
                "sButtonText": "Print",
                "sInfo": 'Please press "CTRL+P" to print or "ESC" to quit',
                "sMessage": "Generated by DataTables"
            },
                @endif
                @if($copy)
                {
                "sExtends": "copy",
                "sButtonText": "Copy"
            }
                    @endif
            ]
        },
        columns: [
            @foreach($list_display as $key=>$value)
                {title:'{{$value['label']}}',data:'{{$key}}',"bSortable": false},
            @endforeach
            @if($action)
                {title:'操作',data:'action'}
            @endif

            ]
    });

    $('#search-form').on('submit', function(e) {
        oTable.draw();
        e.preventDefault();
    });
    $('.tabletools-btn-group').css("margin-bottom","-30px");
    $('.advanced-search-btn').click(function(){
        $('.search-condition').slideToggle('fast');
    });
</script>

@stop
