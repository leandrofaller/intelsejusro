@extends('layouts.login')

@section('conteudo')


    <div class="col-sm-10 col-sm-offset-1">
        <div class="login-container">
            <div class="space-12"></div>
            <div class="space-12"></div>
            <div class="space-12"></div>
            <div class="space-12"></div>
            <div class="center">
                <h1>
                    <span class="white" id="id-text2">SIPEN</span>
                </h1>
                <span class="white">SISTEMA DE INTELIGÊNCIA PENITENCIÁRIA</span>
            </div>

            <div class="space-12"></div>
            <div class="space-12"></div>
            <div class="space-12"></div>
            <div class="space-12"></div>

            <div class="position-relative">

                <div id="login-box" class="login-box visible widget-box no-border">
                    <div class="widget-body">
                        <div class="widget-main">
                            <h4 class="header blue lighter bigger"> Entrar </h4>
                            @include('flash.message')
                            {!!Form::open(array('url' => 'validaLogin'))!!}
                                <div class="form-group has-feedback">
                                    <label for="matricula">Matricula</label>
                                    <input type="text" class="form-control" autocomplete="off" name="matricula" id="matricula" placeholder="Informe a matricula">
                                </div>
                                <div class="form-group">
                                    <label for="password">Senha</label>
                                    <input type="password" class="form-control" autocomplete="off" name="password" id="password" placeholder="Informe a Senha" required>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <button type="submit" class="btn btn-primary btn-block btn-flat">Entrar</button>
                                    </div>
                                </div>
                            {!! Form::close() !!}
                        </div><!-- /.widget-main -->
                    </div><!-- /.widget-body -->

                    <div class="toolbar clearfix red">
                        <div>
                            {{--<a href="#"  class="forgot-password-link"> <i class="ace-icon fa fa-arrow-left"></i> Esqueceu a Senha? </a>--}}
                        </div>

                        <div>
                            <a href="{!! route('solicitaracesso') !!}" class="user-signup-link"> Solicitar Acesso <i class="ace-icon fa fa-arrow-right"></i> </a>
                        </div>
                    </div>
                </div><!-- /.login-box -->


            </div><!-- /.position-relative -->

        </div>
    </div><!-- /.col -->


@endsection
