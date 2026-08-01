
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta charset="utf-8" />
    <title> @yield('titulo')</title>

    <meta name="description" content="top menu &amp; navigation" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />

{{ HTML::style('resources/assets/css/bootstrap.css') }}
{{ HTML::style('resources/assets/css/font-awesome/4.5.0/css/font-awesome.min.css') }}
{{ HTML::style('resources/assets/css/ace.css') }}


<!-- HTML5shiv and Respond.js for IE8 to support HTML5 elements and media queries -->
</head>
<body class="login-layout">
<div class="main-container">
    <div class="main-content">
        <div class="row">
            @yield('conteudo')
        </div><!-- /.row -->
    </div><!-- /.main-content -->
</div><!-- /.main-container -->


{{ HTML::script('resources/assets/js/jquery.js') }}
</body>

</html>