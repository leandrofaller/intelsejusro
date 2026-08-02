@extends('layout.master')

@section('main')

    @include('flash.message')
    <br>
    <div class="row">
        <div class="col-md-6">
            <h2><i class="fa fa-users text-muted"></i> {{ $title }}</h2>
        </div>
        <div class="col-md-6">
            <br>
            <div class="form-group">
                {{ Form::open(['method' => 'GET']) }}
                <div class="input-group">
                    <div class="input-group-btn">
                        <a href="{{ route('usuarios.create') }}" class="btn btn-primary btn-sm">{{ icon('plus') }}
                            NOVO </a>
                    </div>
                    {{ Form::text('q', Request::get('q'), ['autofocus', 'class' => 'form-control', 'placeholder' => 'Procure por nome, CPF ou email']) }}
                    <div class="input-group-btn">
                        <button type="submit" class="btn btn-default btn-sm"><i class="fa fa-search"></i></button>
                    </div>
                </div>
                {{ Form::close() }}
            </div>
        </div>
    </div>

    <hr>

    @if(empty($usuarios) && Request::has('q'))
        <h3 class="text-center text-info">
            {{ icon('info-circle') }} Não existe nenhum registro cadastrado.
        </h3>
    @endif

    @if(empty($usuarios) && Request::has('q'))
        <h3 class="text-center text-info">
            {{ icon('info-circle') }} Não foi encontrado nenhum registro com os parâmetros da busca.
        </h3>
    @else
        <div class="table table-responsive">
            <table class="table table-bordered table-condensed table-hover">
                <thead>
                <tr>
                    <?php $query = ['q' => Request::get('q')]; ?>
                    <th class="">ID</th>
                    <th class="">NOME</th>
                    <th class="">EMAIL</th>
                    <th class="">MATRICULA</th>
                    <th class="">UNIDADE PRISIONAL</th>
                    <th class="">REGIÃO</th>
                    <th class="">PERFIL</th>
                    <th class="text-center">ATIVO</th>
                    <th class="col-md-2 text-center">{{icon('bolt')}} AÇÕES</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($usuarios as $usuario)
                    <tr>
                        <td>{{ $usuario->id}}</td>
                        <td>{{ strtoupper($usuario->nome) }}</td>
                        <td>{{ strtolower($usuario->email) }}</td>
                        <td>{{$usuario->matricula}}</td>
                        <td>{{$usuario->unidades->nomeunidade}}</td>
                        <td>{{ \App\Models\Admin\Regioes::nomeRegiao($usuario->regiao_id)}}</td>
                        <td>{{$usuario->perfil}}</td>
                        <td class="text-center text-{{$usuario->active == 1 ? 'success':'danger'}}"><i
                                    class="fa fa-circle fa-2x"></i></td>
                        <td class="text-center">
                            <div class="btn-group">
                                <a href="{{ route('usuarios.edit', ['id' => $usuario->id]) }}"
                                   class="btn btn-sm btn-primary" data-toggle="tooltip" data-placement="top"
                                   title="Editar"><i class="fa fa-edit"></i></a>
                                {{--<a href="{{ route('usuarios.show', $usuario->id ) }}" class="btn btn-sm btn-info"><i--}}
                                            {{--class="fa fa-info-circle" data-toggle="tooltip" data-placement="top"--}}
                                            {{--title="Informações"></i></a>--}}
                                <a href="{{ route('usuarios.show', $usuario->id ) }}" class="btn btn-sm btn-default"><i
                                            class="fa fa-lock" data-toggle="tooltip" data-placement="top"
                                            title="Resetar Senha"></i></a>
                                @if($usuario->active == 1)
                                <a href="{{ route('usuarios.ativar_inativar', [$usuario->id, 0] ) }}"  onclick="return confirm('Deseja realmente inativar este usuário?');"
                                   class="btn btn-sm btn-warning"><i
                                            class="fa fa-user-times" data-toggle="tooltip" data-placement="top"
                                            title="Inativar Usuário"></i></a>
                                    @else
                                    <a href="{{ route('usuarios.ativar_inativar',[$usuario->id,1] ) }}"  onclick="return confirm('Deseja realmente ativar este usuário?');"
                                       class="btn btn-sm btn-success"><i
                                                class="fa fa-user-plus" data-toggle="tooltip" data-placement="top"
                                                title="Ativar Usuário"></i></a>
                                @endif
                                <a href="{{ route('usuarios.deletar', $usuario->id) }}"  onclick="return confirm('Deseja realmente EXCLUIR este usuário?');"
                                   class="btn btn-sm btn-danger"><i
                                            class="fa fa-trash" data-toggle="tooltip" data-placement="top"
                                            title="Excluir Usuário"></i></a>
                            </div>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        <div class="pagination">
            {{ $usuarios->Render()}}
        </div>
    @endif
@endsection