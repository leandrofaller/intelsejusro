@extends('layout.master')

@section('main')

    <div class="row">
        <div class="col-md-6">
            <h2><i class="fa fa-check text-muted"></i> {{ $title }}</h2>
        </div>
        <div class="col-md-6">
            <br>
            {{ Form::open(['method' => 'GET']) }}
            <div class="form-group">
                <div class="input-group">
                    <div class="input-group-btn">
                        {{--<a href="{{route('papeis.create')}}" class="btn btn-primary btn-sm">{{icon('plus')}} Novo</a>--}}
                    </div>
                    {{ Form::text('q', Request::get('q'), ['autofocus', 'class' => 'form-control', 'placeholder' => 'Procure por papel']) }}
                    <div class="input-group-btn">
                        <button type="submit" class="btn btn-primary btn-sm"><i class="fa fa-search"></i></button>
                    </div>
                </div>
            </div>
            {{ Form::close() }}
        </div>
    </div>
    <hr>

    @include('flash.message')
    <div class="panel panel-default">
        <div class="panel-heading"></div>
        <div class="panel-body">
            @if(empty($papeis))
                <h4 class="text-info text-center">{{ icon('info-circle') }} Nenhum registro encontrado</h4>
            @else
                <div class="table table-responsive">
                    <table class="table table-bordered table-condensed table-striped table-hover">
                        <thead>
                        <tr>
                            <th>PAPEL</th>

                            <th>N° DE AÇÕES</th>
                            <th>Nº DE USUÁRIOS</th>
                            <th class="text-center">ATIVO?</th>
                            <th class="col-md-2 text-center"><i class="fa fa-bolt"></i> Ações</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($papeis as $papel)
                            <tr>
                                <td>
                                    <a href="{{ route('papeis.edit', $papel->id) }}">{{ $papel->name }}</a>
                                </td>
                                <td>{{ $papel->acoes->count() }}</td>
                                <td>{{ $papel->usuarios->count() }}</td>
                                <td class="text-center text-{{$papel->active ? 'success':'danger'}}"><i
                                            class="fa fa-circle fa-2x"></i></td>
                                <td class="text-center">
                                    <a href="{{ route('acaopapel.create', ['id' => $papel->id]) }}"
                                       class="btn btn-primary btn-sm"><i class="fa fa-external-link"> </i></a>
                                    <a href="{{route('papeis.destroy',$papel->id)}}" type="submit"
                                       onclick="return confirm('Deseja realmente excluir este papel?');"
                                       class="btn btn-danger btn-sm"><i class="fa fa-trash"></i> </a>

                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7">
                                    <div class="text-center"><h4 class="text-danger">{{icon('info-circle')}} Nenhum item
                                            encontrado</h4></div>
                                </td>
                            </tr>

                        @endforelse
                        </tbody>
                    </table>
                </div>
                <div id="text-center">
                    {{ $papeis->Render()}}
                </div>
            @endif
        </div>
    </div>
@endsection