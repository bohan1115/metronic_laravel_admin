@extends('layouts.base')
@section('content')

    <div class="row">
        <div class="col-md-12">
            <div class="note note-danger">

                <h3 class="caption">
                    此操作将删除本条及与其相关联的数据！ 你确定吗？
                </h3>

            </div>
        </div>
        <form method="POST">

            <div class="col-md-12">
                <button type="submit" class="btn green pull-left">是，我确定！</button>
                <button type="button" class="btn default pull-right" onclick="javascript:window.location.href='{{ex_route($done_route)}}';">取消</button>
            </div>
        </form>
    </div>
@stop