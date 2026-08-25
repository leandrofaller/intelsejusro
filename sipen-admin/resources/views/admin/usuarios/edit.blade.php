@extends('layout.master')

@section('main')

@section('styles')
    {{ HTML::style('css/bootstrap-datepicker.css') }}
    {{ HTML::style('chosen/chosen.css') }}
@endsection
<div class="row">
    <div class="col-md-12">
        <h2><i class="fa fa-user text-muted"></i> {{ $title }}</h2>
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

<div class="row">
    <div class="col-md-9">
        {{ Form::model($usuario, ['method' => 'post', 'route' =>  ['usuarios.update', $usuario->id]]) }}
        <div class="panel panel-default">
            <div class="panel-heading">Dados Pessoais</div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-8">
                        <div class="form-group">
                            {{ Form::label('nome', 'Nome') }}
                            <small class="text-danger"> *</small>
                            {{ Form::text('nome', null, ['placeholder' => 'Informe o nome', 'class' => 'form-control','maxlength'=>'100']) }}
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            {{ Form::label('Cpf', 'Cpf') }}
                            <small class="text-danger"> *</small>
                            {{ Form::text('cpf', null, ['placeholder' => 'Cpf', 'class' => 'form-control cpf']) }}
                        </div>
                    </div>
                    <div class="col-md-4">
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
                            {{ Form::select('sexo', $sexo,$usuario->sexo, ['class' => 'form-control']) }}
                        </div>
                    </div>
-->
                    <div class="col-md-4">
                        <div class="form-group">
                            {{ Form::label('estado_civil_id', 'Estado Civil') }}
                            {{ Form::select('estado_civil_id', $estado_civil ,$usuario->estado_civil, ['class' => 'form-control']) }}
                        </div>
                    </div>
   <!--
                    <div class="col-md-3">
                        <div class="form-group">
                            {{ Form::label('dt_nascimento', 'Nascimento') }}
                            {{ Form::text('dt_nascimento', strftime('%d/%m/%Y',strtotime($usuario->dt_nascimento)), ['class' => 'form-control date']) }}
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
                    <div class="col-md-4">
                        <div class="form-group">
                            {{ Form::label('email', 'E-mail') }}
                            <small class="text-danger"> *</small>
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
                    <div class="col-md-6">
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
                    <div class="col-md-5">
                        <div class="form-group">
                            {{ Form::label('complemento', 'Complemento') }}
                            {{ Form::text('complemento', null, ['placeholder' => '', 'class' => 'form-control','maxlength'=>'100']) }}
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            {{ Form::label('bairro', 'Bairro') }}
                            {{ Form::text('bairro', null, ['placeholder' => '', 'class' => 'form-control','maxlength'=>'100']) }}
                        </div>
                    </div>

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

                    <div class="col-md-3">
                        <div class="form-group">
                            {{ Form::label('estado', 'Estado') }}
                            {{ Form::select('estado', $estados,$estado_id, ['class' => 'form-control']) }}
                        </div>
                    </div>

                    <div class="col-md-9">
                        <div class="form-group">
                            {{ Form::label('cidade_id', 'Cidade') }}
                            {{ Form::select('cidade_id',$cidade,null, ['id'=>'cidade','class' => 'form-control']) }}
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
                            {{ Form::select('unidade_id', $unidades, null, ['id'=>'unidade_id','class' => 'form-control chosen-select','data-placeholder'=>"Selecione a Unidade"]) }}
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            {{ Form::label('perfil', 'Perfil') }}
                            {{ Form::select('perfil', \App\Models\Admin\Unidades::$perfis ,null, ['id'=>'unidade_id','class' => 'form-control chosen-select','data-placeholder'=>"Selecione o Perfil"]) }}
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
                                {{ Form::checkbox('acesso_faccionados', 1, null) }} Faccionados
                            </label>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="checkbox">
                            <label>
                                {{ Form::checkbox('acesso_apenados', 1, null) }} Apenados
                            </label>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="checkbox">
                            <label>
                                {{ Form::checkbox('acesso_unidades', 1, null) }} Unidades
                            </label>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="checkbox">
                            <label>
                                {{ Form::checkbox('acesso_relatorios', 1, null) }} Relatórios
                            </label>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="checkbox">
                            <label>
                                {{ Form::checkbox('acesso_producao', 1, null) }} Produção
                            </label>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="checkbox">
                            <label>
                                {{ Form::checkbox('acesso_galeria', 1, null) }} Galeria de Imagens
                            </label>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="panel panel-default">
            <div class="panel-heading"></div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-12">
                        <button type="submit" class="btn btn-primary btn-sm"><i class="fa fa-save"></i> ATUALIZAR
                            USUARIO
                        </button>
                        <button type="button" onclick="history.go(-1)"
                                class="btn btn-default pull-right btn-sm">{{icon('arrow-left')}} VOLTAR
                        </button>
                    </div>
                </div>
            </div>
            {{ Form::close() }}
        </div>
    </div>

    <div class="col-md-3">

        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title" style="display: inline"><i class="fa fa-puzzle-piece text-muted"></i> Associar
                    novo papel</h3>
            </div>
            <div class="panel-body">
                {{ Form::open(['route' => 'usuarios.create_role']) }}
                {{ Form::hidden('user_id', $usuario->id) }}
                <div class="input-group">
                    {{ Form::select('app_role_id', $papeis, null, ['class' => 'form-control']) }}
                    <div class="input-group-btn">
                        <button type="submit" class="btn btn-primary btn-sm">{{icon('link')}} Associar Papel</button>
                    </div>
                </div>
                {{ Form::close() }}


            </div>
        </div>

        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title" style="display: inline"><i class="fa fa-puzzle-piece text-muted"></i> Papéis
                    Associados</h3>
            </div>
            <div class="panel-body">

                <fieldset>
                    @if($usuario->papeis->count() == 0)
                        <div class="text-info text-center">
                            <h4><i class="fa fa-info-circle"></i> O usuário não tem nenhum papel associado.</h4>
                        </div>
                    @endif
                    <ul class="list-group">

                        @foreach($usuario->papeis as $papelUsuario)
                            <li class="list-group-item">

                                    <span class="text-info" title="Sistema">{{ $papelUsuario->papel->sistema->name }}</span>
                                    <i class="fa fa-arrow-right"></i>
                                    <span title="Papel">{{ $papelUsuario->papel->name }}</span>

                                <span class="pull-right">

                                     <a href="{{route('usuarios.delete_role',[$papelUsuario->id,$usuario->id])}}"
                                        onclick="return confirm('Deseja realmente excluir este papel?');"
                                        class="btn btn-danger btn-xs"><i class="fa fa-trash"></i> </a>

                                </span>
                            </li>
                        @endforeach
                    </ul>
                </fieldset>

            </div>
        </div>

        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title" style="display: inline"><i class="fa fa-puzzle-piece text-muted"></i> Documento Anexo </h3>
            </div>
            <div class="panel-body">
                <div class="input-group">
                    @if($usuario->anexodocumento == '')
                    Não Possui Anexo.
                    @else
                    {{--<a href="http://www.sipe.syspanda.com.br/documentoServidores/{!! $usuario->anexodocumento !!}" alt="" target="_blank"> Visualizar Anexo </a>--}}
                        <a href="#" onclick="window.open('http://www.sipe.syspanda.com.br/documentoServidores/{!! $usuario->anexodocumento !!}', 'Anexo', 'STATUS=NO, TOOLBAR=NO, LOCATION=NO, DIRECTORIES=NO, RESISABLE=NO, SCROLLBARS=YES, TOP=10, LEFT=10, WIDTH=770, HEIGHT=400');">Visualizar Anexo</a>

                    @endif
                </div>

            </div>
        </div>


        <div class="panel @if($usuario->regiao_id) panel-success @else panel-danger @endif">
            <div class="panel-heading">
                <h3 class="panel-title" style="display: inline"><i class="fa fa-puzzle-piece text-muted"></i> Associar Região</h3>
            </div>
            <div class="panel-body">
                {{ Form::open(['route' => 'usuarios.createRegiao']) }}
                
                {{ Form::hidden('user_id', $usuario->id) }}
                <div class="input-group">
                    {{ Form::select('regiao_id', $regioes, null, ['class' => 'form-control']) }}
                    <div class="input-group-btn">
                        <button type="submit" class="btn btn-primary btn-sm">{{icon('link')}} Associar Região</button>
                    </div>
                </div>
                @if($usuario->regiao_id)
                  <div class="text-info text-center">
                        <h4> {{ \App\Models\Admin\Regioes::nomeRegiao($usuario->regiao_id) }} </h4>
                    </div>
                    
                @else
                    <div class="text-info text-center">
                        <h4><i class="fa fa-info-circle"></i> O usuário não tem nenhuma REGIÃO associada.</h4>
                    </div>                
                @endif
                
                {{ Form::close() }}


            </div>
        </div>

    </div>
</div>
@section('scripts')
    {{ HTML::script('js/jquery.maskedinput.min.js') }}
    {{ HTML::script('js/bootstrap-datepicker.min.js') }}
    {{ HTML::script('js/bootstrap-datepicker.pt-BR.min.js') }}
    {{ HTML::script('chosen/chosen.jquery.min.js') }}
    {{ HTML::script('js/mascara.js') }}
    {{ HTML::script('js/cidades.js') }}
@endsection
@endsection