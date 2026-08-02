
<script type="text/javascript">
    try{ace.settings.loadState('sidebar')}catch(e){}
</script>

<div class="sidebar-shortcuts" id="sidebar-shortcuts">
    {{--<div class="sidebar-shortcuts-large" id="sidebar-shortcuts-large">--}}
        {{--<button class="btn btn-success">--}}
            {{--<i class="ace-icon fa fa-signal"></i>--}}
        {{--</button>--}}

        {{--<button class="btn btn-info">--}}
            {{--<i class="ace-icon fa fa-pencil"></i>--}}
        {{--</button>--}}

        {{--<button class="btn btn-warning">--}}
            {{--<i class="ace-icon fa fa-users"></i>--}}
        {{--</button>--}}

        {{--<button class="btn btn-danger">--}}
            {{--<i class="ace-icon fa fa-cogs"></i>--}}
        {{--</button>--}}
    {{--</div>--}}

    {{--<div class="sidebar-shortcuts-mini" id="sidebar-shortcuts-mini">--}}
        {{--<span class="btn btn-success"></span>--}}

        {{--<span class="btn btn-info"></span>--}}

        {{--<span class="btn btn-warning"></span>--}}

        {{--<span class="btn btn-danger"></span>--}}
    {{--</div>--}}
</div><!-- /.sidebar-shortcuts -->


<ul class="nav nav-list">
    @foreach(\Session::get('menus') as $menu)
        <li class="hover">
            <a href="#" class="dropdown-toggle">
                <i class="menu-icon fa fa-{{$menu->icon}}"></i>
                <span class="menu-text"> {{$menu->title}} </span>
                <b class="arrow fa fa-angle-down"></b>
            </a>
            <b class="arrow"></b>
             <ul class="submenu">
            @foreach(MenusChildren($menu->id) as $m)
                    <li class="hover">
                        <a href='{{route($m->route)}}' >
                            <i class="menu-icon fa fa-caret-right"></i>
                            {{icon($m->icon). $m->title}}
                        </a>
                        <b class="arrow"></b>
                    </li>
            @endforeach
            </ul>
        </li>
    @endforeach

</ul><!-- /.nav-list -->