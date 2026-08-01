@extends('layouts.template')

@section('conteudo')
    <div class="page-header">
        <h1>
            {{ $titulo }}
            <small>
                <i class="ace-icon fa fa-angle-double-right"></i>
                {{ $subtitulo }}
            </small>
            <span class="pull-right">
                  <a href="{{ route('home') }}" class="btn btn-xs btn-light bigger"> <i class="ace-icon fa fa-arrow-left"></i> Voltar </a>
            </span>
        </h1>
    </div><!-- /.page-header -->

    @if ($errors->any())
        <div class="alert alert-danger">
            <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif


    <div class="col-sm-5">
        <div class="widget-box">
            <div class="widget-header">
                <h4 class="widget-title">CONTROLE DE ACESSO</h4>
            </div>

            <div class="widget-body">
                <div class="widget-main no-padding">
                {!! Form::open(['route'=>['alterarPasswordSalvar'], 'id'=>'formulario', 'method'=>'put']) !!}
                        <!-- <legend>Form</legend> -->
                        <fieldset>
                            @include('flash.message')
                            <div class="col-md-12">
                                <div class="form-group">
                                    {!! Form::label('password', 'Nova Senha')  !!}
                                    {{ Form::password('password', array('class' => 'form-control','id'=>'password')) }}
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    {!! Form::label('password2', 'Confirme a Nova Senha')  !!}
                                    {{ Form::password('password2', array('class' => 'form-control','id'=>'password2')) }}
                                </div>
                            </div>

                        </fieldset>

                        <div class="form-actions center">
                            <input  class="btn btn-success" type="submit" id="btnEnviar" value="Salvar" >
                        </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>


@endsection

@section('scripts')


@stop
