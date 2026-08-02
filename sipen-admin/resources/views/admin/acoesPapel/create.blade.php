@extends('layout.master')

@section('main')

@section('styles')
    {{ HTML::style('chosen/chosen.css') }}
@endsection

<div class="row">
    <div class="col-md-12">
            <span class="text-left"><h3 style="display:inline"><i
                            class="fa fa-external-link text-muted"></i> {{ $title }}</h3></span>
    </div>
</div>

<hr>
@include('flash.message')
<div class="panel panel-default">
    <div class="panel-heading"></div>
    <div class="panel-body">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">

                        <span class="text-left"><h4
                                    style="display:inline">{{icon('puzzle-piece') .$papel->name}}</h4></span>

                        <span class="pull-right hidden-xs"><h4 style="display:inline">{{icon('bolt')}} Ações Associadas <span
                                        class="badge">{{$papel->acoes->count()}}</span></h4></span>
                    </div>
                    <div class="panel-body">
                        {{ Form::open(['route' => 'acaopapel.store', 'class' => 'well well-sm']) }}
                        {{ Form::hidden('app_role_id', $papel->id) }}

                        <div class="form-group">
                            <div class="input-group">

                                {{ Form::select('app_action_id[]', $acoes, 0, ['class' => 'form-control chosen-select','multiple','data-placeholder'=>"Selecione as Ações"]) }}
                                <div class="input-group-btn">

                                    <button type="submit" class="btn btn-primary btn-sm"><i class="fa fa-save"></i>
                                    </button>
                                </div>

                            </div>
                        </div>
                        <small class="text-warning text-left">{{icon('info-circle')}} Segure o CRTL para selecionar
                            vários ao mesmo tempo.
                        </small>
                        {{ Form::close() }}
                        <div class="table table-responsive">
                        <table class="table table-condensed table-striped table-hover">
                            <thead>
                            <tr>
                                <th>Nome</th>
                                <th class="text-center">Ativo?</th>
                                <th class="text-center">{{icon('bolt')}} Ações</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($papel->acoes as $acao_papel)
                                <tr>
                                    <td>
                                        <a href="{{ route('acoes.edit', [$acao_papel->acao->id]) }}">

                                            <span class="text-primary">{{ $acao_papel->acao->title }}</span>
                                            <span class="text-muted">{{ $acao_papel->acao->route }}</span>
                                        </a>
                                    </td>
                                    <td class="text-center">
                                        <span class="text-muted text-left text-{{$acao_papel->acao->active ? 'success':'danger'}}"><i
                                                    class="fa fa-circle fa-1x"></i> </span>
                                    </td>
                                    <td class="text-center">
                                        {{ Form::open(['method' => 'post', 'route' => ['acaopapel.destroy', $acao_papel->id]]) }}
                                        {{ Form::hidden('app_role_id', $papel->id) }}
                                        <button type="submit" class="btn btn-danger btn-xs"
                                                onclick="return confirm('Deseja realmente remover a associação do papel?');"> <i class="fa fa-trash-o"></i></button>
                                        {{ Form::close() }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3">
                                        <h5 class="text-info text-center">{{ icon('info-circle') }} Não há ações associadas à
                                            este papel.</h5>
                                    </td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@section('scripts')
    {{ HTML::script('chosen/chosen.jquery.min.js') }}
    {{ HTML::script('js/carrega_chosen.js') }}
@endsection
@endsection
