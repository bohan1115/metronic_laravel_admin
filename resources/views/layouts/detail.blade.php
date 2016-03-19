@extends('layouts.base')
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="portlet box blue">
            <div class="portlet-title">
                <div class="caption">
                    <i class="{{$icon_title or 'fa fa-list'}}"></i>{{$bar_title or '详情'}}
                </div>
            </div>
            <div class="portlet-body">
                <table class="table table-hover table-striped table-bordered">
                    @foreach($list_display as $key=>$value)
                    <tr>
                        <td>
                            {{$key}}
                        </td>
                        <td>

                            <?php
                                if(is_array($value['field']))
                                {

                                    if($data_source[$value['field'][0]] instanceof \Illuminate\Database\Eloquent\Collection)
                                        {
                                            $arr = [];
                                            foreach($data_source[$value['field'][0]] as $item)
                                                {
                                                    $arr[] = $item[$value['field'][1]];
                                                }
                                            echo render_field($value['type'],$arr);
                                        }
                                    else {
                                        echo render_field($value['type'],$data_source[$value['field'][0]][$value['field'][1]]);
                                    }
                                }
                                else
                                {
                                    echo render_field($value['type'],$data_source[$value['field']]);
                                }
                            ?>

                        </td>
                    </tr>
                        @endforeach
                </table>
                <div class="row">
                    <div class="col-md-offset-3 col-md-9">
                        <button class="btn green" onclick="javascript:window.history.back(-1);" type="button">返回</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@stop
