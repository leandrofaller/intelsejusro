@extends('layout.master')

@section('main')

    <div class="row">
        <div class="col-md-6">
            <h3><i class="fa fa-plus text-muted"></i> {{ $title }} </h3>
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

    {{ Form::open(['method' => 'POST', 'route' =>  'acoes.store']) }}
    <div class="panel panel-default">
        <div class="panel-heading">

        </div>
        <div class="panel-body">
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        {{ Form::label('app_id', 'Sistema') }}
                        <small class="text-danger">*</small>
                        {{ Form::select('app_id', $sistemas, Request::has('app_id') ? (int)Request::get('app_id') : 0, ['class' => 'form-control']) }}

                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group">
                        {{ Form::label('title', 'Titulo') }}
                        <small class="text-danger"> *</small>
                        {{ Form::text('title', null, ['autofocus', 'placeholder' => 'Informe o titulo', 'class' => 'form-control']) }}

                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group">
                        {{ Form::label('route', 'Rota') }}
                        <small class="text-danger"> *</small>
                        {{ Form::text('route', null, ['autofocus', 'placeholder' => 'Informe a rota', 'class' => 'form-control']) }}

                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        {{ Form::label('active', 'Ativo?') }}
                        <select name="active" id="" class="form-control">
                            <option selected value="1">Sim</option>
                            <option value="0">Não</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="well well-sm">
                    <button type="submit" class="btn btn-primary btn-sm"><i class="fa fa-save"></i> <b>SALVAR AÇÃO</b>
                    </button>
                    <button type="button" onclick="history.go(-1)" class="btn btn-default pull-right btn-sm"><b>VOLTAR</b>
                    </button>
                </div>
            </div>

            {{ Form::close() }}

        </div>
    </div>

@endsection