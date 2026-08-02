@extends('layouts.template')

@section('conteudo')

    <div class="page-header">
        <h1>
            {{ $titulo }}
            <small>
                <i class="ace-icon fa fa-angle-double-right"></i>
                {{ $subtitulo }}
            </small>
            <div class="pull-right"><a href="{{ route('galerias.novo')  }}" class="btn btn-grey"> INCLUIR FOTOS</a>
            </div>
        </h1>
    </div><!-- /.page-header -->

    @include('flash.message')
    @if ($errors->any())
        <div class="alert alert-danger">
            <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif


    <div class="col-md-12">
        <div class="widget-box widget-color-dark ">
            <div class="widget-header">
                <h4 class="widget-title">PESQUISAR</h4>
            </div>

            <div class="widget-body">
                <div class="widget-main no-padding">
                    <fieldset>

                        {{ Form::open( ['method' => 'get', 'route' =>  ['galerias'], 'id'=>'formulario' ]) }}
                        <fieldset>
                            <div class="col-md-4">
                                <div class="form-group">
                                    {!! Form::label('parametro','Pesquisa por Titulo / Descrição')  !!}
                                    {!! Form::text('parametro', '', ['class' => 'form-control naoValidar','id'=>'parametro' ]) !!}
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    {!! Form::label('categoria','Selecione a Categoria')  !!}
                                    {!! Form::select('categoria', $categorias, 0, ['class' => 'form-control','id'=>'categoria']) !!}
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    {!! Form::label('servidor','Selecione a Servidor')  !!}
                                    {!! Form::select('servidor', $servidores, 0, ['class' => 'form-control','id'=>'servidor']) !!}
                                </div>
                            </div>

                        </fieldset>
                        <div class="form-actions center">
                            <button type="submit" class="btn btn-sm btn-success">
                                <i class="ace-icon fa fa-search icon-on-right bigger-110"></i>
                                Pesquisar
                            </button>
                        </div>
                        {!! Form::close() !!}

                    </fieldset>
                </div>
            </div>
        </div>
    </div>






    @if($exibe)


        <div class="col-md-12">
            <div class="widget-box widget-color-dark ">
                <div class="widget-header">
                    <h4 class="widget-title">ARQUIVOS PÚBLICOS</h4>
                </div>

                <div class="widget-body">
                    <div class="widget-main no-padding">
                        @forelse($anexospublicos as $dado)
                            <div class="col-md-6 well">

                                    <?php
                                    $tipo = '';
                                    $extensao = pathinfo($dado->imagem, PATHINFO_EXTENSION);
                                    if ($extensao != 'jpg' && $extensao != 'png' && $extensao != 'bmp' && $extensao != 'jpeg' && $extensao != 'gif') {
                                        $tipo = 'doc';
                                    }
                                    ?>
                                    <div class="row msg_container base_receive">
                                        <div class="col-md-2 col-xs-2 avatar">
                                            <a href="{{ asset('public/'.$dado->imagem) }}" target="_blank"
                                               title="{!! $dado->titulo !!} / {!! $dado->users->nome !!}"
                                               class="{{$tipo == 'doc' ? '' : 'group1'}} cboxElement img-responsive ">
                                                <img width="100" height="100" alt="Clique Para Abrir"
                                                     src="{{ $tipo == 'doc' ? asset('public/documentos_Faccao/doc.png') : asset('public/'.$dado->imagem) }}"/>
                                            </a>
                                            <span class="label label-success text-center">{{$dado->publico}}</span>
                                        </div>
                                        <div class="col-md-10 col-xs-10">
                                            <div class="">
                                                <span class="label label-success">{!! $dado->categorias->nome !!}</span>
                                                <h5>{{$dado->titulo ? $dado->titulo : 'Sem Título'}}</h5>
                                                <div class="tagslabel">
                                                    <p style="height: 63px; top: 137px;">{{$dado->descricao ? $dado->descricao : 'Sem Descrição'}}</p>
                                                </div>
                                                <p></p>
                                            </div>
                                            <div class="pull-left">
                                                <p><span class="">{!! $dado->users->nome !!} </span> - <span
                                                            class="text-danger">{!! dataFormat($dado->created_at) !!}</span>
                                                </p>
                                            </div>

                                            <div class="pull-right">
                                                <a href="#" type="submit"
                                                   onclick="return confirm('Deseja realmente excluir esta Foto?');"
                                                   class="btn btn-success btn-xs"><i class="ace-icon fa fa-edit"></i>
                                                </a>
                                                <a href="{{route('galerias.excluir', ['id'=>$dado->id ]) }}"
                                                   type="submit"
                                                   onclick="return confirm('Deseja realmente excluir esta Foto?');"
                                                   class="btn btn-danger btn-xs"><i class="ace-icon fa fa-times"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                            </div>
                        @empty
                            <h4 class="text-danger"><i class="fa fa-warning"></i> Nenhuma Foto!</h4>
                    @endforelse
                    </div>
                </div>
            </div>
        </div>

    @endif


    @if($exibesigilo)

        <div class="col-md-12">
            <div class="widget-box widget-color-red ">
                <div class="widget-header">
                    <h4 class="widget-title">MEUS ARQUIVOS SIGILOSOS</h4>
                </div>

                <div class="widget-body">
                    <div class="widget-main no-padding">
                        @forelse($anexosprivados as $dado)
                            <div class="col-md-6 well">
                                    <?php
                                    $tipo = '';
                                    $extensao = pathinfo($dado->imagem, PATHINFO_EXTENSION);
                                    if ($extensao != 'jpg' && $extensao != 'png' && $extensao != 'bmp' && $extensao != 'jpeg' && $extensao != 'gif') {
                                        $tipo = 'doc';
                                    }
                                    ?>
                                    <div class="row msg_container base_receive">
                                        <div class="col-md-2 col-xs-2 avatar">
                                            <a href="{{ asset('public/'.$dado->imagem) }}" target="_blank"
                                               title="{!! $dado->titulo !!} / {!! $dado->users->nome !!}"
                                               class="{{$tipo == 'doc' ? '' : 'group1'}} cboxElement img-responsive ">
                                                <img width="100" height="100" alt="Clique Para Abrir"
                                                     src="{{ $tipo == 'doc' ? asset('public/documentos_Faccao/doc.png') : asset('public/'.$dado->imagem) }}"/>
                                            </a>
                                            <span class="label label-success text-center">{{$dado->publico}}</span>
                                        </div>
                                        <div class="col-md-10 col-xs-10">
                                            <div class="">
                                                <span class="label label-success">{!! $dado->categorias->nome !!}</span>
                                                <h5>{{$dado->titulo ? $dado->titulo : 'Sem Título'}}</h5>
                                                <div class="tagslabel">
                                                    <p style="height: 63px; top: 137px;">{{$dado->descricao ? $dado->descricao : 'Sem Descrição'}}</p>
                                                </div>
                                                <p></p>
                                            </div>
                                            <div class="pull-left">
                                                <p><span class="">{!! $dado->users->nome !!} </span> - <span
                                                            class="text-danger">{!! dataFormat($dado->created_at) !!}</span>
                                                </p>
                                            </div>

                                            <div class="pull-right">
                                                <a href="#" type="submit"
                                                   onclick="return confirm('Deseja realmente excluir esta Foto?');"
                                                   class="btn btn-success btn-xs"><i class="ace-icon fa fa-edit"></i>
                                                </a>
                                                <a href="{{route('galerias.excluir', ['id'=>$dado->id ]) }}"
                                                   type="submit"
                                                   onclick="return confirm('Deseja realmente excluir esta Foto?');"
                                                   class="btn btn-danger btn-xs"><i class="ace-icon fa fa-times"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                            </div>
                        @empty
                            <h4 class="text-danger"><i class="fa fa-warning"></i> Nenhuma Foto!</h4>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>

    @endif

    <script src={{asset('resources/assets/js/jquery.js')}}></script>

@endsection

@section('scripts')

    {{ HTML::script('resources/assets/js/datepickerJS/bootstrap-datepicker.min.js') }}
    {{ HTML::script('resources/assets/js/datepickerJS/bootstrap-datepicker.pt-BR.min.js') }}

    {{ HTML::script('resources/assets/js/mask/maskedinput.min.js') }}
    {{ HTML::script('resources/assets/js/validacao/formatainput.js') }}
    {{ HTML::script('resources/assets/js/validacao/validacao.js') }}


@stop