<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta charset="utf-8" />
    <title> @yield('titulo')</title>

    <!-- DESENVOLVIDO POR MARCOS MOREIRA COSTA - EQUIPE INFOPEN - SRDA - SEJUS  -->


    <meta name="description" content="SIPEN - SISTEMA DE INTELIGÊNCIA PENITENCIÁRIA" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />

    <!-- bootstrap & fontawesome -->
    {{ HTML::style('resources/assets/css/bootstrap.css') }}
    {{ HTML::style('resources/assets/css/font-awesome/4.5.0/css/font-awesome.min.css') }}
    <!-- page specific plugin styles -->
{{ HTML::style('resources/assets/css/select2.css') }}

    <!-- text fonts -->
    {{--{{ HTML::style('css/ace-fonts.css') }}--}}
    <!-- ace styles -->
    {{ HTML::style('resources/assets/css/ace.css') }}
    {{--{{ HTML::script('js/ace-extra.js') }}--}}
    <!-- page specific plugin styles -->
    {{ HTML::style('resources/assets/css/colorbox.css') }}

    {{ HTML::style('resources/assets/css/jquery-ui.custom.css') }}
    {{ HTML::style('resources/assets/chosen/chosen.css') }}
    {{ HTML::style('resources/assets/css/datepicker.css') }}
    {{ HTML::style('resources/assets/css/bootstrap-timepicker.css') }}
    {{ HTML::style('resources/assets/css/daterangepicker.css') }}
    {{ HTML::style('resources/assets/css/sweetalert.css') }}
    {{--{{ HTML::style('css/jquery.gritter.css') }}--}}

    {{ HTML::style('resources/assets/css/jquery-ui.css') }}

    @yield('css')

    <!-- Custom Dark Mode CSS -->
    {{ HTML::style('resources/assets/css/dark-mode.css') }}

    <!-- Anti-flicker script -->
    <script>
        (function() {
            const theme = localStorage.getItem('theme');
            if (theme === 'dark' || (!theme && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
                document.documentElement.classList.add('dark-mode');
            }
        })();
    </script>
</head>

<body class="no-skin">
<div id="loader"><img src="{!! asset('public/img/loading.gif') !!}" alt=""> Carregando... </div>


<div id="navbar" class="navbar navbar-default">
    <script type="text/javascript">
        try{ace.settings.check('navbar' , 'fixed')}catch(e){}
    </script>
    @include('layouts.topo')

</div>

<!-- /section:basics/navbar.layout -->
<div class="main-container" id="main-container">
    <script type="text/javascript">
        try{ace.settings.check('main-container' , 'fixed')}catch(e){}
    </script>

    <!-- #section:basics/sidebar -->
    <div id="sidebar" class="sidebar responsive">
        @include('layouts.menu')
    </div>

    <!-- /section:basics/sidebar -->
    <div class="main-content">
        <div class="main-content-inner">

            <!-- /section:basics/content.breadcrumbs -->
            <div class="page-content">

                @yield('conteudo')

            </div><!-- /.page-content -->
        </div>
    </div><!-- /.main-content -->

    <div class="footer">
        <div class="footer-inner">
            <!-- #section:basics/footer -->
            <div class="footer-content">
						<span class="bigger-120">
							<span class="blue bolder">SIPEN</span>
							Todos os Direitos Reservados &copy; 2017 {{ date('Y') == '2017' ? '' : ' / ' . date('Y')  }}
						</span>
                - Desenvolvido por&nbsp;&nbsp;@mmc (E-mail de Suporte: <b>sipen@gmail.com</b>)
            </div>
            <!-- /section:basics/footer -->
        </div>
    </div>

    <a href="#" id="btn-scroll-up" class="btn-scroll-up btn btn-sm btn-inverse">
        <i class="ace-icon fa fa-angle-double-up icon-only bigger-110"></i>
    </a>
</div><!-- /.main-container -->


<!-- scripts basic layout -->
{{ HTML::script('resources/assets/js/jquery-2.1.4.min.js') }}
{{--{{ HTML::script('js/jquery.js') }}--}}
{{ HTML::script('resources/assets/js/bootstrap.js') }}
{{ HTML::script('resources/assets/js/fuelux/fuelux.wizard.js') }}
{{ HTML::script('resources/assets/js/jquery.validate.js') }}

{{ HTML::script('resources/assets/js/jquery-ui.custom.js') }}
{{ HTML::script('resources/assets/js/jquery.ui.touch-punch.js') }}
{{ HTML::script('resources/assets/js/ace/ace.js') }}
{{ HTML::script('resources/assets/js/ace/ace.sidebar.js') }}
<!-- # scripts basic layout -->

{{--{{ HTML::script('js/jquery.gritter.js') }}--}}
{{--{{ HTML::script('js/bootbox.js') }}--}}
{{--{{ HTML::script('js/jquery.easypiechart.js') }}--}}
{{--{{ HTML::script('js/jquery.hotkeys.js') }}--}}
{{--{{ HTML::script('js/bootstrap-wysiwyg.js') }}--}}

{{--{{ HTML::script('js/select2.js') }}--}}

{{--{{ HTML::script('js/fuelux/fuelux.spinner.js') }}--}}
{{--{{ HTML::script('js/x-editable/bootstrap-editable.js') }}--}}
{{--{{ HTML::script('js/x-editable/ace-editable.js') }}--}}
{{--{{ HTML::script('js/jquery.maskedinput.js') }}--}}

{{--{{ HTML::script('js/ace/elements.scroller.js') }}--}}
{{--{{ HTML::script('js/ace/elements.colorpicker.js') }}--}}
{{--{{ HTML::script('js/ace/elements.fileinput.js') }}--}}
{{--{{ HTML::script('js/ace/elements.typeahead.js') }}--}}
{{--{{ HTML::script('js/ace/elements.wysiwyg.js') }}--}}
{{--{{ HTML::script('js/ace/elements.spinner.js') }}--}}
{{--{{ HTML::script('js/ace/elements.treeview.js') }}--}}
{{ HTML::script('resources/assets/js/ace/elements.wizard.js') }}
{{--{{ HTML::script('js/ace/elements.aside.js') }}--}}

{{--{{ HTML::script('js/ace/ace.ajax-content.js') }}--}}
{{--{{ HTML::script('js/ace/ace.touch-drag.js') }}--}}
{{--{{ HTML::script('js/ace/ace.sidebar-scroll-1.js') }}--}}
{{--{{ HTML::script('js/ace/ace.submenu-hover.js') }}--}}
{{--{{ HTML::script('js/ace/ace.widget-box.js') }}--}}
{{--{{ HTML::script('js/ace/ace.settings.js') }}--}}
{{--{{ HTML::script('js/ace/ace.settings-rtl.js') }}--}}
{{--{{ HTML::script('js/ace/ace.settings-skin.js') }}--}}
{{--{{ HTML::script('js/ace/ace.widget-on-reload.js') }}--}}
{{--{{ HTML::script('js/ace/ace.searchbox-autocomplete.js') }}--}}

{{ HTML::script('resources/assets/js/sweetalert.min.js') }}
{{ HTML::script('resources/assets/js/sweetalert-dev.js') }}

<!-- O ACE.SIDEBAR.JS DA CONFLITO COM O MENU RESPONSIVO -  -->
{{--{{ HTML::script('js/ace/ace.sidebar.js') }}--}}

<script>

    $('[data-rel=tooltip]').tooltip({container:'body'});
    $('[data-rel=popover]').popover({container:'body'});

</script>

<script type="text/javascript">
    $(function(){
        $('#loader').css({	"display": "block", opacity: 0.7 });
    });
    jQuery(window).load(function() {
        jQuery("#loader").fadeOut("slow");
    });
</script>

<script type="text/javascript">
//    $('a[name=btnPerguntas]').click(function(){
    $("#btnPerguntas").click(function () {
        $("#myModalAjuda").modal({backdrop: "static"});
    });
</script>


<!-- Dark Mode Toggle Script -->
<script type="text/javascript">
    $(document).ready(function() {
        const toggleBtn = $('#toggle-dark-mode');
        const icon = $('#dark-mode-icon');
        
        function syncIcon() {
            if ($('html').hasClass('dark-mode')) {
                icon.removeClass('fa-moon-o').addClass('fa-sun-o');
            } else {
                icon.removeClass('fa-sun-o').addClass('fa-moon-o');
            }
        }
        
        syncIcon();
        
        toggleBtn.on('click', function(e) {
            e.preventDefault();
            $('html').toggleClass('dark-mode');
            
            if ($('html').hasClass('dark-mode')) {
                localStorage.setItem('theme', 'dark');
            } else {
                localStorage.setItem('theme', 'light');
            }
            syncIcon();
        });
    });
</script>

@yield('scripts')

</body>
</html>


