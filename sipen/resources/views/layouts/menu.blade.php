<ul class="nav nav-list ">
            <li class="active ">
                <a href=" {!! url('home') !!} ">
                    <i class="menu-icon fa fa-tachometer"></i>
                    <span class="menu-text"> PRINCIPAL </span>
                </a>
                <b class="arrow"></b>
            </li>
        @foreach(Session::get('menus') as $menu)
            <?php
            $titulo = trim(strtoupper($menu->title));
            if ($titulo == 'FACCIONADOS' && isset(Auth::user()->acesso_faccionados) && !Auth::user()->acesso_faccionados) continue;
            if ($titulo == 'APENADOS' && isset(Auth::user()->acesso_apenados) && !Auth::user()->acesso_apenados) continue;
            if ($titulo == 'UNIDADES' && isset(Auth::user()->acesso_unidades) && !Auth::user()->acesso_unidades) continue;
            if ($titulo == 'RELATÓRIOS' && isset(Auth::user()->acesso_relatorios) && !Auth::user()->acesso_relatorios) continue;
            if ($titulo == 'PRODUÇÃO' && isset(Auth::user()->acesso_producao) && !Auth::user()->acesso_producao) continue;
            if ($titulo == 'GALERIA IMAGENS' && isset(Auth::user()->acesso_galeria) && !Auth::user()->acesso_galeria) continue;
            ?>
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