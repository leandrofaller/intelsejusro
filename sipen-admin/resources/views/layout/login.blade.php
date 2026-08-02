<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta charset="utf-8" />
    <title>{{ isset($title) ? $title . ' - Admin' : 'Manager Users' }}</title>

    <meta name="description" content="top menu &amp; navigation" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />

    {{ HTML::style('css/bootstrap.min.css') }}
    {{ HTML::style('font-awesome/4.5.0/css/font-awesome.min.css') }}
    {{ HTML::style('css/fonts.googleapis.com.css') }}
    {{ HTML::style('css/ace.min.css') }}
    {{ HTML::style('css/ace-rtl.min.css') }}


<!-- HTML5shiv and Respond.js for IE8 to support HTML5 elements and media queries -->
</head>
<body class="login-layout light-login">
<div class="main-container">
    <div class="main-content">
        <div class="row">
            @yield('content')
        </div><!-- /.row -->
    </div><!-- /.main-content -->
</div><!-- /.main-container -->


{{ HTML::script('js/jquery-2.1.4.min.js') }}
{{ HTML::script('js/bootstrap.min.js') }}
</body>

</html>
