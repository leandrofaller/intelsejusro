@extends('layout.master')

@section('main')

    @section('styles')
        {{ HTML::style('chosen/chosen.css') }}
    @endsection

    <div class="row">
        <div class="col-md-12">
            <span class="text-left"><h2 style="display:inline"><i
                            class="fa fa-edit text-muted"></i> {{ $title }}</h2></span>
            <span class="pull-right hidden-xs"><a href="{{route('papeis.destroy',$papel->id)}}" type="submit"
                                        onclick="return confirm('Confirma excluir papel?');"
                                        class="btn btn-xs btn-danger"><i class="fa fa-trash"></i> Excluir</a></span>
        </div>
    </div>
    <hr>
    @include('flash.message')
    <div class="panel panel-default">
        <div class="panel-heading"></div>
        <div class="panel-body">
            <div class="row">
                <div class="col-md-4">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <span class="text-left"><h3 style="display:inline">{{icon('globe')}} Papel</h3></span>
                        </div>
                        <div class="panel-body">
                            {{ Form::model($papel, ['method' => 'post', 'route' =>  ['papeis.update', $papel->id]]) }}
                            <div class="form-group">
                                {{ Form::label('app_id', 'Sistema') }}
                                <small class="text-danger">*</small>
                                {{ Form::select('app_id', $sistemas, $papel->app_id, ['class' => 'form-control','disabled']) }}

                            </div>

                            <div class="form-group">
                                {{ Form::label('name', 'Nome Papel') }}
                                <small class="text-danger">*</small>
                                {{ Form::text('name', null, ['placeholder' => 'Informe o nome', 'class' => 'form-control','required']) }}

                            </div>
                            <?php $simnao = ['1' => 'Sim', '0' => 'Não']; ?>
                            <div class="form-group">
                                {{ Form::label('active', 'Ativo?') }}
                                {{ Form::select('active', $simnao, (int)$papel->active, ['class' => 'form-control']) }}
                            </div>

                            <hr>
                            <div>
                                <button type="submit" class="btn btn-primary btn-sm"><i class="fa fa-save"></i> <b>SALVAR
                                        PAPEL </b></button>
                                <button type="button" onclick="history.go(-1)" class="btn btn-default pull-right btn-sm btn-back"><b>VOLTAR</b>
                                </button>
                            </div>
                            {{ Form::close() }}
                        </div>
                    </div>

                </div>
                <div class="col-md-4">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <span class="text-left"><h3 style="display:inline">{{icon('users')}} Usuários <span
                                            class="badge">{{$papel->usuarios->count()}}</span></h3></span>
                        </div>
                        <div class="panel-body">

                            @if($papel->usuarios->count() == 0)
                                <div class="text-info text-center">
                                    <h5><i class="fa fa-info-circle"></i> Não há usuários associados à este papel.</h5>
                                </div>
                            @endif

                            <div class="list-group">
                                @foreach($papel->usuarios as $user_role)
                                    <a href="{{ route('usuarios.edit', $user_role->user_id) }}" class="list-group-item">
                                        <span class="text-primary">{{ $user_role->usuario->nome}}</span>
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <span class="text-left"><h3 style="display:inline">{{icon('bolt')}} Ações do Papel <span
                                            class="badge">{{$papel->acoes->count()}}</span></h3></span>
                        </div>

                        <div class="table table-responsive">
                            <table class="table table-condensed table-striped table-hover">
                                <thead>
                                <tr>
                                    <th>Nome</th>
                                    <th class="text-center">Ativo?</th>
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

@section('scripts')
{{ HTML::script('chosen/chosen.jquery.min.js') }}
{{ HTML::script('js/carrega_chosen.js') }}
@endsection
@endsection
