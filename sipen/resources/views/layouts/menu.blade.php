<ul class="nav nav-list ">
            <li class="active ">
                <a href=" {!! url('home') !!} ">
                    <i class="menu-icon fa fa-tachometer"></i>
                    <span class="menu-text"> PRINCIPAL </span>
                </a>
                <b class="arrow"></b>
            </li>
        @foreach(Session::get('menus') as $menu)
            <li class="open">
                <a href="#" class="dropdown-toggle">
                    <i class="menu-icon fa fa-{{$menu->icon}}"></i>
                    <span class="menu-text">{{$menu->title}}</span>
                    <b class="arrow fa fa-angle-down"></b>
                </a>
                <b class="arrow"></b>
                <ul class="submenu">
                    @foreach(MenusChildren($menu->id) as $m)
                        <li class="">
                            <a href="{{route($m->route)}}"> <i class="menu-icon fa fa-caret-right"></i> {{$m->title}} </a>
                            <b class="arrow"></b>
                        </li>
                    @endforeach
                </ul>
            </li>
        @endforeach
</ul><!-- /.nav-list -->

<!-- #section:basics/sidebar.layout.minimize -->
<div class="sidebar-toggle sidebar-collapse" id="sidebar-collapse">
    <i class="ace-icon fa fa-angle-double-left" data-icon1="ace-icon fa fa-angle-double-left" data-icon2="ace-icon fa fa-angle-double-right"></i>
</div>

<!-- /section:basics/sidebar.layout.minimize -->
<script type="text/javascript">
    try{ace.settings.check('sidebar' , 'collapsed')}catch(e){}
</script>