<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta charset="utf-8" />
    <title>{{ isset($title) ? $title . ' - Admin' : 'Admin' }}</title>

    <meta name="description" content="top menu &amp; navigation" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />

    <!-- bootstrap & fontawesome -->
{{ HTML::style('css/bootstrap.min.css') }}
{{ HTML::style('font-awesome/4.5.0/css/font-awesome.min.css') }}

<!-- page specific plugin styles -->
    <!-- text fonts -->
{{ HTML::style('css/fonts.googleapis.com.css') }}
<!-- ace styles -->
    {{ HTML::style('css/ace.min.css') }}
    <!--[if lte IE 9]>
    {{ HTML::style('css/ace-part2.min.css') }}
    <![endif]-->
    {{ HTML::style('css/ace-skins.min.css') }}
    {{ HTML::style('css/ace-rtl.min.css') }}
    <!--[if lte IE 9]>
    {{ HTML::style('css/ace-ie.min.css') }}
    <![endif]-->

    <!-- inline styles related to this page -->

    <!-- ace settings handler -->
{{ HTML::script('js/ace-extra.min.js') }}
<!-- HTML5shiv and Respond.js for IE8 to support HTML5 elements and media queries -->
    <!--[if lte IE 8]>
    {{ HTML::script('js/html5shiv.min.js') }}
    {{ HTML::script('js/respond.min.js') }}
    <![endif]-->
    @yield('styles')
</head>

<body class="no-skin">
<div id="navbar" class="navbar navbar-default    navbar-collapse       h-navbar ace-save-state">
    @include('layout.topo')
</div>

<div class="main-container ace-save-state" id="main-container">
    <script type="text/javascript">
        try{ace.settings.loadState('main-container')}catch(e){}
    </script>

    <div id="sidebar" class="sidebar h-sidebar navbar-collapse collapse ace-save-state">

        @include('layout.menu')

    </div>

    <div class="main-content">
        <div class="main-content-inner">
            <div class="page-content">
                @yield('main')
            </div><!-- /.page-content -->
        </div>
    </div><!-- /.main-content -->

    <div class="footer">
        <div class="footer-inner">
            <div class="footer-content">
						<span class="bigger-120">
							<span class="blue bolder">Admin 1.0</span>
							 &copy; 2017 - SRDA - Sistema de Registro de Dados de Apenados - Desenvolvido por @mmc
						</span>
            </div>
        </div>

    </div>
</div>
    <!-- /.main-container -->

    <!-- basic scripts -->

    <!--[if !IE]> -->
{{ HTML::script('js/jquery-2.1.4.min.js') }}
<!-- <![endif]-->

    <!--[if IE]>
    {{ HTML::script('js/jquery-1.11.3.min.js') }}
    <![endif]-->

{{ HTML::script('js/bootstrap.min.js') }}

<!-- page specific plugin scripts -->

    <!-- ace scripts -->
{{ HTML::script('js/ace-elements.min.js') }}
{{ HTML::script('js/ace.min.js') }}

@yield('scripts')

<!-- inline scripts related to this page -->

</body>
</html>
