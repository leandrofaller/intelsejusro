@extends('layout.master')

@section('main')

@section('styles')
    {{ HTML::style('css/bootstrap-datepicker.css') }}
    {{ HTML::style('chosen/chosen.css') }}
@endsection
    <div class="row">
        <div class="col-md-12">
            <h2><i class="fa fa-user-plus text-muted"></i> {{ $title }}</h2>
        </div>
    </div>
    <hr>
    @include('flash.message')
    @if ($errors->any())
        <div class="alert alert-warning fade in">
            <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
            <ul>
                @foreach($errors->all() as $error)
                    <li><h5>{{ $error }} </h5></li>
                @endforeach
            </ul>
        </div>
    @endif

    {{ Form::open ( array ('route' => 'usuarios.store'))  }}
        <div class="panel panel-default">
            <div class="panel-heading">Dados Pessoais</div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-5">
                        <div class="form-group">
                            {{ Form::label('nome', 'Nome') }}
                            <small class="text-danger"> *</small>
                            {{ Form::text('nome', null, ['placeholder' => 'Informe o nome', 'class' => 'form-control','maxlength'=>'100']) }}
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            {{ Form::label('Cpf', 'Cpf') }}
                            <small class="text-danger"> *</small>
                            {{ Form::text('cpf', null, ['placeholder' => 'Cpf', 'class' => 'form-control cpf']) }}
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            {{ Form::label('matricula', 'Matricula') }}
                            <small class="text-danger"> *</small>
                            {{ Form::text('matricula', null, ['placeholder' => 'matricula', 'class' => 'form-control', 'maxlength' => 11]) }}
                        </div>
                    </div>
<!--
                    <div class="col-md-2">
                        <div class="form-group">
                            {{ Form::label('rg', 'Rg') }}
                            {{ Form::text('rg', null, ['placeholder' => 'Rg', 'class' => 'form-control', 'maxlength' => 15]) }}
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            {{ Form::label('orgao_expedidor', 'Orgão Expedidor') }}
                            {{ Form::text('orgao_expedidor', null, ['placeholder' => 'Orgão Expedidor', 'class' => 'form-control','maxlength'=>'10']) }}
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            {{ Form::label('sexo', 'Sexo') }}
                            {{ Form::select('sexo', $sexo,null, ['class' => 'form-control']) }}
                        </div>
                    </div>
                    -->
                    <div class="col-md-1">
                        <div class="form-group">
                            {{ Form::label('estado_civil_id', 'Estado Civil') }}
                            {{ Form::select('estado_civil_id', $estado_civil ,1, ['class' => 'form-control']) }}
                        </div>
                    </div>
                <!--
                    <div class="col-md-3">
                        <div class="form-group">
                            {{ Form::label('dt_nascimento', 'Nascimento') }}
                            {{ Form::text('dt_nascimento', null, ['class' => 'form-control date']) }}
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            {{ Form::label('nome_mae', 'Nome Mãe') }}
                            {{ Form::text('nome_mae', null, ['placeholder' => 'Nome Mãe', 'class' => 'form-control','maxlength'=>'100']) }}
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            {{ Form::label('nome_pai', 'Nome Pai') }}
                            {{ Form::text('nome_pai', null, ['placeholder' => 'Nome Pai', 'class' => 'form-control','maxlength'=>'100']) }}
                        </div>
                    </div>
-->
                    <div class="col-md-2">
                        <div class="form-group">
                            {{ Form::label('email', 'E-mail') }}<small class="text-danger"> *</small>
                            {{ Form::text('email', null, ['placeholder' => 'email válido e único', 'class' => 'form-control','maxlength'=>'100']) }}
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <div class="panel panel-default">
            <div class="panel-heading">Endereço</div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-5">
                        <div class="form-group">
                            {{ Form::label('rua', 'Rua') }}
                            {{ Form::text('rua', null, ['placeholder' => 'Rua', 'class' => 'form-control','maxlength'=>'100']) }}
                        </div>
                    </div>
                    <div class="col-md-1">
                        <div class="form-group">
                            {{ Form::label('numero', 'Número') }}
                            {{ Form::text('numero', null, ['placeholder' => '', 'class' => 'form-control number','maxlength'=>'5']) }}
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            {{ Form::label('complemento', 'Complemento') }}
                            {{ Form::text('complemento', null, ['placeholder' => '', 'class' => 'form-control','maxlength'=>'100']) }}
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            {{ Form::label('bairro', 'Bairro') }}
                            {{ Form::text('bairro', null, ['placeholder' => '', 'class' => 'form-control','maxlength'=>'100']) }}
                        </div>
                    </div>

                    <div class="col-md-2">
                        <div class="form-group">
                            {{ Form::label('estado', 'Estado') }}
                            {{ Form::select('estado', $estados,0, ['id'=>'estado','class' => 'form-control chosen-select','data-placeholder'=>"Selecione o estado"]) }}
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            {{ Form::label('cidade_id', 'Cidade') }}
                            {{ Form::select('cidade_id', [],null, ['id'=>'cidade','class' => 'form-control']) }}
                        </div>
                    </div>
                <!--
                    <div class="col-md-2">
                        <div class="form-group">
                            {{ Form::label('cep', 'Cep') }}
                            {{ Form::text('cep', null, ['class' => 'form-control cep']) }}
                        </div>
                    </div>
-->
                    <div class="col-md-3">
                        <div class="form-group">
                            {{ Form::label('fone_fixo', 'Fone Fixo') }}
                            {{ Form::text('fone_fixo', null, ['class' => 'form-control fone']) }}
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            {{ Form::label('celular', 'Celular') }}
                            {{ Form::text('celular', null, ['class' => 'form-control celular']) }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

<div class="panel panel-default">
    <div class="panel-heading">Unidade de Trabalho</div>
    <div class="panel-body">
        <div class="row">

            <div class="col-md-8">
                <div class="form-group">
                    {{ Form::label('unidade_id', 'Unidade Prisional') }}
                    {{ Form::select('unidade_id', $unidades,0, ['id'=>'unidade_id','class' => 'form-control chosen-select','data-placeholder'=>"Selecione a Unidade"]) }}
                </div>
            </div>

            <div class="col-md-4">
                <div class="form-group">
                    {{ Form::label('perfil', 'Perfil') }}
                    {{ Form::select('perfil', \App\Models\Admin\Unidades::$perfis ,0, ['id'=>'unidade_id','class' => 'form-control chosen-select','data-placeholder'=>"Selecione O Perfil"]) }}
                </div>
            </div>


        </div>
    </div>
</div>

<div class="panel panel-default">
    <div class="panel-heading">Permissões de Acesso às Seções</div>
    <div class="panel-body">
        <div class="row">
            <div class="col-md-4">
                <div class="checkbox">
                    <label>
                        {{ Form::checkbox('acesso_faccionados', 1, true) }} Faccionados
                    </label>
                </div>
            </div>
            <div class="col-md-4">
                <div class="checkbox">
                    <label>
                        {{ Form::checkbox('acesso_apenados', 1, true) }} Apenados
                    </label>
                </div>
            </div>
            <div class="col-md-4">
                <div class="checkbox">
                    <label>
                        {{ Form::checkbox('acesso_unidades', 1, true) }} Unidades
                    </label>
                </div>
            </div>
            <div class="col-md-4">
                <div class="checkbox">
                    <label>
                        {{ Form::checkbox('acesso_relatorios', 1, true) }} Relatórios
                    </label>
                </div>
            </div>
            <div class="col-md-4">
                <div class="checkbox">
                    <label>
                        {{ Form::checkbox('acesso_producao', 1, true) }} Produção
                    </label>
                </div>
            </div>
            <div class="col-md-4">
                <div class="checkbox">
                    <label>
                        {{ Form::checkbox('acesso_galeria', 1, true) }} Galeria de Imagens
                    </label>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="alert alert-info"> <h2> A senha Padrão é : 123456</h2> </div>
    <div class="panel panel-default">
        <div class="panel-heading"></div>
        <div class="panel-body">
            <div class="row">
                <div class="col-md-12">
                    <button type="submit" class="btn btn-primary btn-sm"><i class="fa fa-save"></i> REGISTRAR USUARIO
                    </button>
                    <button type="button" onclick="history.go(-1)" class="btn btn-default pull-right btn-sm">{{icon('arrow-left')}} VOLTAR
                    </button>
                </div>
            </div>
        </div>
        {{ Form::close() }}
    </div>
        {{--<div class="panel panel-default">--}}
            {{--<div class="panel-heading"></div>--}}
            {{--<div class="panel-body">--}}
                {{--<div class="row">--}}

                {{--</div>--}}

            {{--</div>--}}
          {{--</div>--}}
@section('scripts')
    {{ HTML::script('js/jquery.maskedinput.min.js') }}
    {{ HTML::script('js/bootstrap-datepicker.min.js') }}
    {{ HTML::script('js/bootstrap-datepicker.pt-BR.min.js') }}
    {{ HTML::script('chosen/chosen.jquery.min.js') }}
    {{ HTML::script('js/mascara.js') }}
    {{ HTML::script('js/cidades.js') }}
@endsection
@endsection