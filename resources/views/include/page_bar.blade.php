<div class="page-bar">
    <ul class="page-breadcrumb">
        <li>
            <i class="fa fa-home"></i>
            <a href="{{ route('index') }}">首页</a>
            <i class="fa fa-angle-right"></i>
        </li>
        @if(menu_prefix($prefix))
        <li>
            <a href="#">{{menu_prefix($prefix)}}</a>
            <i class="fa fa-angle-right"></i>
        </li>
        @endif
        <li>
            <a href="#">{{$bar_title or ''}}</a>
        </li>
    </ul>
    <!--
    <div class="page-toolbar">
        <div class="btn-group pull-right">
            <button type="button" class="btn btn-fit-height grey-salt dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-delay="1000" data-close-others="true">
                Actions <i class="fa fa-angle-down"></i>
            </button>
            <ul class="dropdown-menu pull-right" role="menu">
                <li>
                    <a href="#">Action</a>
                </li>
                <li>
                    <a href="#">Another action</a>
                </li>
                <li>
                    <a href="#">Something else here</a>
                </li>
                <li class="divider">
                </li>
                <li>
                    <a href="#">Separated link</a>
                </li>
            </ul>
        </div>
    </div>-->
</div>