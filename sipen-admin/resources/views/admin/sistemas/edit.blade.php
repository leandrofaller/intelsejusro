@extends('layout.master')
@section('main')
    <div class="row">
        <div class="col-md-6">
            <span class="text-left"> <h2 style="display: inline;"> <i
                            class="fa fa-edit text-muted"></i> {{ $title }} </h2> </span>
        </div>
        <div class="col-md-6">
            <span class="pull-right">
			{{ Form::open(['method' => 'POST', 'class' => 'pull-right', 'route' => ['sistemas.destroy', $sistema->id]]) }}
                <button type="submit" onclick="return confirm('Deseja realmente excluir o sistema?');"
                        class="btn btn-xs btn-danger"><i class="fa fa-trash-o"></i> EXCLUIR</button>
                {{ Form::close() }}
		</span>
        </div>
    </div>
    <hr/>
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

    <div class="panel panel-default">
        <div class="panel-heading"></div>
        <div class="panel-body">
            <div class="row">
                <div class="col-md-8">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <span class="text-left"><i class="fa fa-globe text-muted"></i> Informações do Sistema</span>
                        </div>
                        <div class="panel-body">
                            {{ Form::model($sistema, ['method' => 'POST', 'route' =>  ['sistemas.update', $sistema->id]]) }}
                            <div class="form-group">
                                {{ Form::label('name', 'Nome') }}
                                {{ Form::text('name', null, ['autofocus', 'placeholder' => 'Informe o nome', 'class' => 'form-control']) }}
                            </div>
                            <div class="form-group">
                                {{ Form::label('url', 'URL') }}
                                {{ Form::input('url', 'url', null, ['placeholder' => 'Informe a URL', 'class' => 'form-control']) }}
                            </div>
                            <?php $simnao = ['1' => 'Sim', '0' => 'Não']; ?>
                            <div class="form-group">
                                {{ Form::label('active', 'Ativo?') }}
                                {{ Form::select('active', $simnao, (int)$sistema->active, ['class' => 'form-control']) }}
                            </div>
                            <hr>
                            <div>
                                <button type="submit" class="btn btn-sm btn-success"><i class="fa fa-save"></i> <b>SALVAR</b>
                                </button>
                                <button type="button" onclick="history.go(-1)"
                                        class="btn btn-sm btn-default pull-right"><b>VOLTAR</b>
                                </button>
                            </div>
                            {{ Form::close() }}
                        </div>
                    </div>

                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <span class="text-left"><i class="fa fa-globe text-muted"></i> Configuração do Sistema</span>
                        </div>
                        <div class="panel-body">
                            {{ Form::model($configuracao, ['method' => 'POST', 'route' =>  ['sistemas.configuracao', $configuracao->id]]) }}
                            <div class="form-group">
                                {{ Form::label('email_admin', 'Email Principal') }} <small class="red">Para recebimento das notificações de Solicitações de acesso e controle</small>
                                {{ Form::text('email_admin', null, ['autofocus', 'placeholder' => 'Informe o e-mail', 'class' => 'form-control']) }}
                            </div>
                            <hr>
                                <h2>CONTROLE DE HORÁRIO DE ACESSO POR E-MAIL</h2>
                            <hr>
                            <div class="col-md-8">
                            <div class="form-group">
                                {{ Form::label('titulo', 'TÍTULO DO E-MAIL') }}
                                {{ Form::text('titulo', null, ['class' => 'form-control']) }}
                            </div>
                            </div>
                            <div class="col-md-2">
                            <div class="form-group">
                                {{ Form::label('horainicio', 'Hora Início') }} <small class="red"> Ex: 00:00:00</small>
                                {{ Form::text('horainicio', null, ['class' => 'form-control']) }}
                            </div>
                            </div>
                            <div class="col-md-2">
                            <div class="form-group">
                                {{ Form::label('horafim', 'Hora Fim') }} <small class="red"> Ex: 00:00:00</small>
                                {{ Form::text('horafim', null, ['class' => 'form-control']) }}
                            </div>
                            </div>
                            <hr>

                            <div>
                                <button type="submit" class="btn btn-sm btn-info"><i class="fa fa-save"></i> <b>SALVAR CONFIGURAÇÃO</b>
                                </button>
                                <button type="button" onclick="history.go(-1)"
                                        class="btn btn-sm btn-default pull-right"><b>VOLTAR</b>
                                </button>
                            </div>
                            {{ Form::close() }}
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                    <span class="text-left"> <i class="fa fa-puzzle-piece text-muted"></i> Papéis <span
                                class="badge"> {{ $sistema->papeis->count() }}</span> </span>
                            <a class="pull-right"
                               href="{{ route('papeis.create') }}">{{ icon('plus') }} Novo
                                papel</a>
                        </div>
                        <div class="panel-body">
                            <fieldset>
                                @if($sistema->papeis->count() == 0)
                                    <h4 class="text-info text-center"><i class="fa fa-info-circle"></i> Não há papel
                                        associdado
                                        à este sistema.</h4>
                                @endif

                                <div class="list-group">
                                    @foreach($sistema->papeis as $papel)
                                        <a class="list-group-item"
                                           href="{{ route('papeis.edit', $papel->id) }}">{{ $papel->name }}</a>
                                    @endforeach
                                </div>
                            </fieldset>
                        </div>
                    </div>
                </div>
            <!--
                {{--<div class="col-md-5">--}}
                    {{--<div class="panel panel-default">--}}
                        {{--<div class="panel-heading">--}}
                            {{--<i class="fa fa-bolt text-muted"></i> Ações <span--}}
                                    {{--class="badge"> {{ $sistema->acoes->count() }}</span>--}}
                            {{--<a href="{{ route('sistemas.edit', $sistema->id) }}" class="pull-right">{{ icon('plus') }}--}}
                                {{--Nova--}}
                                {{--ação</a>--}}
                        {{--</div>--}}
                        {{--<div class="panel-body">--}}
                            {{--<fieldset>--}}
                                {{--@if($sistema->acoes->count() == 0)--}}
                                    {{--<h4 class="text-info text-center"><i class="fa fa-info-circle"></i> Não há ações--}}
                                        {{--associadas--}}
                                        {{--à este sistema.</h4>--}}
                                {{--@endif--}}

                                {{--@if(isset($acao))--}}
                                    {{--{{ Form::model($acao, ['method' => 'POST', 'route' => ['acoes.update', $acao->id], 'class' => 'well well-sm']) }}--}}
                                {{--@else--}}
                                    {{--{{ Form::open(['route' => 'acoes.store', 'class' => 'well well-sm']) }}--}}
                                {{--@endif--}}

                                {{--{{ Form::hidden('app_id', $sistema->id) }}--}}

                                {{--<div class="form-group">--}}
                                    {{--<div class="input-group">--}}
                                        {{--<div class="input-group-addon">Título</div>--}}
                                        {{--{{ Form::text('title', null, ['class' => 'form-control', 'placeholder' => 'Digite o título da ação']) }}--}}
                                    {{--</div>--}}
                                {{--</div>--}}

                                {{--<div class="form-group">--}}
                                    {{--<div class="input-group">--}}
                                        {{--<div class="input-group-addon">Route</div>--}}
                                        {{--{{ Form::text('route', null, ['class' => 'form-control', 'placeholder' => 'Digite a rota da ação']) }}--}}
                                    {{--</div>--}}
                                {{--</div>--}}

                                {{--<div class="row">--}}
                                    {{--<div class="col-md-7">--}}
                                        {{--<div class="form-group">--}}
                                            {{--<?php $active = isset($acao) ? (int)$acao->active : 1; ?>--}}
                                            {{--<div class="input-group">--}}
                                                {{--<div class="input-group-addon">Ativo?</div>--}}
                                                {{--{{ Form::select('active', $simnao, $active, ['class' => 'form-control']) }}--}}
                                            {{--</div>--}}
                                        {{--</div>--}}
                                    {{--</div>--}}
                                    {{--<div class="col-md-5">--}}
                                        {{--<div class="form-group">--}}
                                            {{--<button type="submit" class="btn btn-block btn-success btn-sm"><i--}}
                                                        {{--class="fa fa-save"></i>--}}
                                                {{--SALVAR--}}
                                            {{--</button>--}}
                                        {{--</div>--}}
                                    {{--</div>--}}
                                {{--</div>--}}


                                {{--{{ Form::close() }}--}}

                                {{--<ul class="list-group">--}}
                                    {{--@foreach($sistema->acoes as $acao)--}}
                                        {{--<li class="list-group-item">--}}
                                            {{--<span title="{{ $acao->active ? 'Ativo' : 'Inativo' }}">{{ icon($acao->active ? 'check text-success' : 'times text-danger') }}</span>--}}
                                            {{--<a href="{{ route('sistemas.edit', ['id' => $acao->app_id, 'app_action_id' => $acao->id]) }}">--}}
                                                {{--<span class="text-primary">{{ $acao->title }}</span>--}}
                                                {{--<small class="text-muted">{{ $acao->route }}</small>--}}
                                            {{--</a>--}}

                                            {{--{{ Form::open(['method' => 'GET', 'route' => ['acoes.destroy', $acao->id], 'class' => 'pull-right']) }}--}}
                                            {{--<button type="submit" class="btn btn-xs btn-danger"--}}
                                                    {{--onclick="return confirm('Deseja realmente excluir a ação?');"><i--}}
                                                        {{--class="fa fa-trash-o"></i></button>--}}
                                            {{--{{ Form::close() }}--}}
                                        {{--</li>--}}
                                    {{--@endforeach--}}
                                {{--</ul>--}}
                            {{--</fieldset>--}}
                        {{--</div>--}}
                    {{--</div>--}}
                {{--</div>--}}
         -->

            </div>
        </div>
    </div>
@endsection