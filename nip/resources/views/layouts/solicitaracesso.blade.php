<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta charset="utf-8" />
    <title> @yield('titulo')</title>

    <!-- DESENVOLVIDO POR MARCOS MOREIRA COSTA - EQUIPE INFOPEN - SRDA - SEJUS  -->


    <meta name="description" content="SRDA - SISTEMA DE REGISTRO DE APENADOS" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />

    <!-- bootstrap & fontawesome -->
    {{ HTML::style('resources/assets/css/bootstrap.css') }}
    {{ HTML::style('resources/assets/css/font-awesome/4.5.0/css/font-awesome.min.css') }}
    <!-- page specific plugin styles -->
{{ HTML::style('resources/assets/css/select2.css') }}

    <!-- text fonts -->
    {{ HTML::style('resources/assets/css/ace-fonts.css') }}
    <!-- ace styles -->
    {{ HTML::style('resources/assets/css/ace.css') }}
    {{ HTML::script('resources/assets/js/ace-extra.js') }}
    <!-- page specific plugin styles -->
    {{ HTML::style('resources/assets/css/colorbox.css') }}

    {{ HTML::style('resources/assets/css/jquery-ui.custom.css') }}
    {{ HTML::style('resources/assets/chosen/chosen.css') }}
    {{ HTML::style('resources/assets/css/datepicker.css') }}
    {{ HTML::style('resources/assets/css/bootstrap-timepicker.css') }}
    {{ HTML::style('resources/assets/css/daterangepicker.css') }}
    {{ HTML::style('resources/assets/css/sweetalert.css') }}
    {{ HTML::style('resources/assets/css/jquery.gritter.css') }}

    {{ HTML::style('resources/assets/css/jquery-ui.css') }}


    @yield('css')

</head>

<body class="no-skin">
<div id="loader"><img src="{!! asset('img/loading.gif') !!}" alt=""> Carregando... </div>


<div id="navbar" class="navbar navbar-default">

    <div class="navbar-container" id="navbar-container">
        <!-- #section:basics/sidebar.mobile.toggle -->
        <button type="button" class="navbar-toggle menu-toggler pull-left" id="menu-toggler" data-target="#sidebar">
            <span class="sr-only">Toggle sidebar</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>

        <!-- /section:basics/sidebar.mobile.toggle -->
        <div class="navbar-header pull-left">
            <!-- #section:basics/navbar.layout.brand -->
            <a href="#" class="navbar-brand">
                <small>
                    <i class="fa fa-get-pocket"></i>
                    SIPEN - SISTEMA DE INTELIGÊNCIA PENITENCIÁRIA
                </small>
            </a>
        </div>


    </div><!-- /.navbar-container -->
</div>

<!-- /section:basics/navbar.layout -->
<div class="main-container" id="main-container">

    <div class="main-content">
        <div class="main-content-inner">
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
							<span class="blue bolder">SRDA</span>
							Todos os Direitos Reservados &copy; 2017 {{ date('Y') == '2017' ? '' : ' / ' . date('Y')  }}
						</span>
                - Desenvolvido por&nbsp; &nbsp; @mmc
            </div>
            <!-- /section:basics/footer -->
        </div>
    </div>

    <a href="#" id="btn-scroll-up" class="btn-scroll-up btn btn-sm btn-inverse">
        <i class="ace-icon fa fa-angle-double-up icon-only bigger-110"></i>
    </a>
</div><!-- /.main-container -->


<!-- scripts basic layout -->
{{ HTML::script('resources/assets/js/jquery.js') }}
{{ HTML::script('resources/assets/js/bootstrap.js') }}
{{ HTML::script('resources/assets/js/jquery.validate.js') }}

<!-- # scripts basic layout -->

{{ HTML::script('resources/assets/js/select2.js') }}
{{ HTML::script('resources/assets/js/ace/ace.js') }}



<script type="text/javascript">
    $(function(){
        $('#loader').css({	"display": "block", opacity: 0.7 });
    });
    jQuery(window).load(function() {
        jQuery("#loader").fadeOut("slow");
    });
</script>

<script type="text/javascript">
    $('a[name=btnTermo]').click(function(){
        $("#myModalTermo").modal({backdrop: "static"});
    });
</script>
<script type="text/javascript">
    $("#btnEnviar").prop('disabled', true);

    $('#termo').click(function(){
        if( $("#termo").is(':checked') ){
            $("#btnEnviar").prop('disabled', false);
        } else {
            $("#btnEnviar").prop('disabled', true);
        }
    });
</script>





@yield('scripts')

</body>
</html>


