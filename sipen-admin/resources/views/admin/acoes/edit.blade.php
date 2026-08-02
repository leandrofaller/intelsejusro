@extends('layout.master')

@section('main')

    <div class="row">
        <div class="col-md-12">
            <span class="text-left"><h2 style="display:inline"><i
                            class="fa fa-edit text-muted"></i> {{ $title }}</h2></span>
            <span class="pull-right"><a href="{{route('acoes.destroy',$acao->id)}}" type="submit"
                                        onclick="return confirm('Deseja Realmente Excluir a Ação?');"
                                        class="btn btn-xs btn-danger"><i class="fa fa-trash"></i> Excluir Ação</a></span>
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
    <div class="panel panel-default">
        <div class="panel-heading"></div>
        <div class="panel-body">
            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                {{ Form::model($acao, ['method' => 'post', 'route' =>  ['acoes.update', $acao->id]]) }}
                                <div class="form-group">
                                    <div class="col-md-4">
                                        {{ Form::label('app_id', 'Sistema') }}
                                        <small class="text-danger">*</small>
                                        {{ Form::select('app_id', $sistemas, $acao->app_id, ['class' => 'form-control']) }}
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="col-md-4">
                                        {{ Form::label('title', 'Titulo') }}
                                        <small class="text-danger">*</small>
                                        {{ Form::text('title', null, ['placeholder' => 'Informe o nome', 'class' => 'form-control','required']) }}
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="col-md-4">
                                        {{ Form::label('route', 'Rota') }}
                                        <small class="text-danger">*</small>
                                        {{ Form::text('route', null, ['placeholder' => 'Informe o nome', 'class' => 'form-control','required']) }}
                                    </div>
                                </div>
                                <?php $simnao = ['1' => 'Sim', '0' => 'Não']; ?>
                                <div class="form-group">
                                    <div class="col-md-4">
                                        {{ Form::label('active', 'Ativo?') }}
                                        {{ Form::select('active', $simnao, (int)$acao->active, ['class' => 'form-control']) }}
                                    </div>
                                </div>
                            </div>
                            <hr/>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="well well-sm ">
                                        <button type="submit" class="btn btn-primary btn-sm"><i class="fa fa-save"> </i>
                                            <b>SALVAR</b>
                                        </button>
                                        <button type="button" onclick="history.go(-1)"
                                                class="btn btn-default btn-back pull-right btn-sm"><b>VOLTAR</b>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            {{ Form::close() }}
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

@endsection
