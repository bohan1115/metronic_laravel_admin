<ul class="page-sidebar-menu" data-keep-expanded="false" data-auto-scroll="true" data-slide-speed="200">
    <!-- DOC: To remove the sidebar toggler from the sidebar you just need to completely remove the below "sidebar-toggler-wrapper" LI element -->
    <li class="sidebar-toggler-wrapper">
        <!-- BEGIN SIDEBAR TOGGLER BUTTON -->
        <div class="sidebar-toggler">
        </div>
        <!-- END SIDEBAR TOGGLER BUTTON -->
    </li>
    <!--search section-->
    <!--<li class="start ">
        <a href="javascript:;">
            <i class="icon-home"></i>
            <span class="title">Dashboard</span>
            <span class="arrow "></span>
        </a>
        <ul class="sub-menu">
            <li>
                <a href="index.html">
                    <i class="icon-bar-chart"></i>
                    Default Dashboard</a>
            </li>
            <li>
                <a href="index_2.html">
                    <i class="icon-bulb"></i>
                    New Dashboard #1</a>
            </li>
            <li>
                <a href="index_3.html">
                    <i class="icon-graph"></i>
                    New Dashboard #2</a>
            </li>
        </ul>
    </li>
    <li class="active open">
        <a href="javascript:;">
            <i class="icon-rocket"></i>
            <span class="title">Page Layouts</span>
            <span class="selected"></span>
            <span class="arrow open"></span>
        </a>
        <ul class="sub-menu">
            <li>
                <a href="layout_horizontal_sidebar_menu.html">
                    Horizontal & Sidebar Menu</a>
            </li>
            <li>
                <a href="index_horizontal_menu.html">
                    Dashboard & Mega Menu</a>
            </li>
        </ul>
    </li>-->
    @forelse($left_menu as $item)

        @if($item['menu']->prefix == $prefix)
            <li class="active open">
        @else
    <li>
        @endif
        <a href="javascript:;">
            <i class="{{$item['menu']->icon}}"></i>
            <span class="title">{{$item['menu']->name}}</span>
            @if($item['menu']->prefix == $prefix)
                <span class="selected"></span>
                <span class="arrow open"></span>
            @else
                <span class="arrow "></span>
            @endif
        </a>
        <ul class="sub-menu">
            @foreach($item['value'] as $value)

                @if($value->route_name == $route)
                    <li class="active">
                @else
                    <li>
                @endif
                <a href="{{ex_route($value->route_name)}}">{{$value->name}}</a>
            </li>
            @endforeach
        </ul>
    </li>
    @empty
        empty
     @endforelse
</ul>