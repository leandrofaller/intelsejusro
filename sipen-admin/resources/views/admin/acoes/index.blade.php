@extends('layout.master')

@section('main')
    <div class="row">
        <div class="col-md-6">
            <h2><i class="fa fa-bolt text-muted"></i> {{$title}}</h2>
        </div>
        <div class="col-md-6">
            <br>
            <div class="form-group">
                {{ Form::open(['method' => 'GET']) }}
                <div class="input-group">
                    <div class="input-group-btn">
                        <a href="{{route('acaopapel.index')}}" class="btn btn-success btn-sm hidden-xs">{{icon('check')}} Ações do Papel</a>
                        <a href="{{route('acoes.create')}}" class="btn btn-primary btn-sm">{{icon('plus')}} Nova Ação</a>
                    </div>
                    {{ Form::text('q', Request::get('q'), ['autofocus', 'class' => 'form-control', 'placeholder' => 'Procure pelo Titulo ou Rota']) }}
                    <div class="input-group-btn">
                        <button type="submit" class="btn btn-primary btn-sm"><i class="fa fa-search"></i></button>
                    </div>
                </div>
                {{ Form::close() }}
            </div>
        </div>
    </div>
    <hr/>
    @include('flash.message')
    @if ($errors->any())
        <div class="alert alert-warning">
            <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
            <ul>
                @foreach($errors->all() as $error)
                    <li><h4>{{ $error }} </h4></li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="panel panel-default">
        <div class="panel-heading"></div>
        <div class="panel-body">

            @if(count($acoes) == 0)
                <h3 class="text-center text-info">{{ icon('info-circle') }} Nenhum registro encontrado.</h3>
            @else
                <div class="table table-responsive">
                    <table class="table table-bordered table-condensed table-striped table-hover">
                        <thead>
                        <tr>
                            <th>SISTEMA</th>
                            <th>Titulo</th>
                            <th>ROTA</th>
                            <th class="text-center">ATIVO?</th>
                            <th class="col-md-2 text-center"><i class="fa fa-bolt"></i> Ações</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($acoes as $acoe)
                            <tr>
                                <td>
                                    <a href="{{ route('sistemas.edit', $acoe->app_id) }}">{{ $acoe->sistema->name}}</a>
                                </td>
                                <td>{{ $acoe->title }}</td>
                                <td>{{ $acoe->route }}</td>
                                <td class="text-center text-{{$acoe->active ? 'success':'danger'}}"><i
                                            class="fa fa-circle fa-2x"></i></td>
                                <td class="text-center">
                                    <a href="{{ route('acoes.edit', ['id' => $acoe->id]) }}"
                                       class="btn btn-primary btn-sm"><i class="fa fa-edit"> </i></a>

                                    <a href="{{route('acoes.destroy',$acoe->id)}}" type="submit"
                                       onclick="return confirm('Deseja realmente excluir a Ação?');"
                                       class="btn btn-danger btn-sm"><i class="fa fa-trash"></i> </a>

                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="col-md-12">
                    <div class="pagination">
                        {{$acoes->Render()}}
                    </div>
                </div>
            @endif

        </div>
    </div>
@endsection