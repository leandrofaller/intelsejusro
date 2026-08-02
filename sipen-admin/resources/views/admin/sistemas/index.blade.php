@extends('layout.master')

@section('main')
    <div class="row">
        <div class="col-md-6">
            <h2><i class="fa fa-globe text-muted"></i> {{$title}}</h2>
        </div>
        <div class="col-md-6">
            <br>
            <div class="form-group">
                {{ Form::open(['method' => 'GET']) }}
                <div class="input-group">
                    <div class="input-group-btn">
                        <a href="{{route('sistemas.create')}}" class="btn btn-primary btn-sm">{{icon('plus')}} Novo</a>
                    </div>
                    {{ Form::text('q', Request::get('q'), ['autofocus', 'class' => 'form-control', 'placeholder' => 'Procure pelo nome ou URL']) }}
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

            @if(count($sistemas) == 0)
                <h3 class="text-center text-info">{{ icon('info-circle') }} Nenhum registro encontrado.</h3>
            @else
                <div class="list-group">
                    @foreach ($sistemas as $sistema)

                        <div class="col-xs-6 col-sm-3 pricing-box">
                            <div class="widget-box widget-color-blue2">
                                <div class="widget-header">
                                    <h5 class="widget-title bigger lighter"><a
                                                href="{{route('sistemas.edit', ['id' => $sistema->id])}}"
                                                style="color:#FFF">{{$sistema->name}}</a></h5>
                                </div>

                                <div class="widget-body">
                                    <div class="widget-main">

                                        <ul class="list-unstyled spaced2">
                                            <li>
                                                <i class="ace-icon fa fa-check green"></i>
                                                Url: {{$sistema->url}}
                                            </li>

                                            <li>
                                                <i class="ace-icon fa fa-check green"></i>
                                                Criado : {{dataFormat($sistema->created_at)}}
                                            </li>

                                            <li>
                                                <i class="ace-icon fa fa-check green"></i>
                                                Atualizado : {{ dataFormat($sistema->updated_at)}}
                                            </li>

                                            <li>
                                                <i class="ace-icon fa fa-{{$sistema->active ? 'check green':'times red'}}"></i>
                                                Ativo : {{$sistema->active ? 'SIM':'NÃO'}}
                                            </li>
                                        </ul>

                                        <hr/>

                                    </div>

                                    <div>
                                        <a href="{{route('sistemas.edit', ['id' => $sistema->id])}}"
                                           class="btn btn-block btn-primary">
                                            <i class="ace-icon fa fa-arrow-right bigger-110"></i>
                                            <span>Detalhes</span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="col-md-12">
                    <div class="pagination">
                        {{$sistemas->Render()}}
                    </div>
                </div>
            @endif

        </div>
    </div>
@endsection