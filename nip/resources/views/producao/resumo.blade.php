@extends('layouts.template')

@section('conteudo')


    <div class="page-header">
        <h1>
            {{ $titulo }}
            <small>
                <i class="ace-icon fa fa-angle-double-right"></i>
                {{ $subtitulo }}
            </small>

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


        <div class="row">
            <div class="col-md-12">

                @forelse($tipos as $tipo)
                        <div class="col-md-3  pricing-box">
                            <div class="widget-box widget-color-dark">
                                <div class="widget-header">
                                    <h5 class="widget-title bigger lighter">{!! $tipo->descricao !!}</h5>
                                </div>

                                <div class="widget-body">
                                    <div class="widget-main">
                                        <ul class="list-unstyled spaced2">
                                            <li>
                                                <i class="ace-icon fa fa-check green"></i>
                                                Rascunho:  {{ \App\Model\Producao::contaTipoStatus($tipo->id, 1 )  }}
                                            </li>
                                            <li>
                                                <i class="ace-icon fa fa-check green"></i>
                                                Concluído: {{ \App\Model\Producao::contaTipoStatus($tipo->id, 2 )  }}
                                            </li>
                                            <li><i class="ace-icon fa fa-check green"></i>
                                                    Devolvido: {{ \App\Model\Producao::contaTipoStatus($tipo->id, 3 )  }}
                                            </li>
                                        </ul>

                                        <hr>
                                        <small>TOTAL GERAL</small>
                                        <div class="price">
                                            {{ \App\Model\Producao::contaTipos($tipo->id)  }}
                                        </div>
                                    </div>

                                    <div>
                                        <a href="{{ route('producao.resumolista', $tipo->id) }}" class="btn btn-block btn-inverse">
                                            <i class="ace-icon fa fa-list bigger-110"></i>
                                            <span>LISTAR</span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>

                @empty
                    <tr>
                        <td colspan="12">
                            <div class="well text-center ">
                                <h2 class="text-danger"> <i class="fa fa-warning"></i> Nenhum Registro Encontrado!</h2>
                            </div>
                    </tr>
            @endforelse
                <!-- /.box -->
            </div>
        </div>






@endsection