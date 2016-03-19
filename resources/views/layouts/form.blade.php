@extends('layouts.base')
@section('css')

    @foreach($css as $item)
    <link rel="stylesheet" type="text/css" href="{{$item}}"/>
    @endforeach
@stop
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="portlet box blue">
                <div class="portlet-title">
                    <div class="caption">

                        <i class="{{$icon_title or 'fa fa-gift'}}"></i>{{$bar_title or '列表'}}
                    </div>
                </div>
                <div class="portlet-body">
                    {!! form_start($form) !!}
                    <div class="alert alert-danger display-hide" style="display: none;">
                        <button class="close" data-close="alert"></button>
                        您的输入有如下错误，请修改后重试！
                    </div>
                    {!! form_body($form) !!}
                    <div class="form-actions">
                        <div class="row">
                            <div class="col-md-offset-3 col-md-9">
                                {!! form_rest($form) !!}
                            </div>
                        </div>
                    </div>
                    {!! form_end($form) !!}

                </div>
            </div>
        </div>
    </div>
@stop
@section('js')
    @foreach($js as $item)
    <script type="text/javascript" src="{{$item}}"></script>
    @endforeach
@stop
@section('js_content')
    <script>
    @foreach($js_content as $item)
        {!! $item !!}
    @endforeach
    </script>
    <script>
        $('form').submit(function(e){

            $("form").children(".form-group").removeClass('has-error');
            $("form").children(".form-group").children('.text-danger').remove();
            $.ajax({
                url:$("form").attr('action'),
                type:'POST',
                data:$("form").serialize(),
                dataType:'json',
                success:function(data){
                    if(data.code == 900){
                       console.log(data.msg);
                        $('.alert-danger',$("form")).html('<button class="close" data-close="alert"></button>'+data.msg).show();
                    }
                    else if(data.code == 100)
                    {
                        $('.alert-danger',$("form")).hide();
                        window.location.href = data.to;
                    }
                    else{
                        $.each(data,function(name,val){
                            //console.log(name,val);
                            $('.alert-danger',$("form")).show();

                            $('#'+name).parent().parent().addClass('has-error');
                            $('#'+name).parent().parent().append('<div class="text-danger">'+val+'</div>');
                         })
                    }
                }
            });
            e.preventDefault();
        });
    </script>
@stop