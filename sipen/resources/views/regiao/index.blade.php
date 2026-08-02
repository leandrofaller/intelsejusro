@extends('layouts.template')

@section('conteudo')


    <div class="page-header">
        <h1>
            {{ $titulo }}
            <small>
                <i class="ace-icon fa fa-angle-double-right"></i>
                {{ $subtitulo }}
            </small>
            <div class="pull-right"> <a href="{{ route('regioes.novo')  }}" class="btn btn-grey"> NOVO </a> </div>

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
                    <!-- /.box-header -->
                    <div class="table-responsive">
                        <table id="simple-table" class="table table-striped table-bordered table-hover">
                            <tr>
                                <th>#</th>
                                <th>NOME REGIÃO</th>
                                <th>QTD UNIDADES</th>
                                <th>UNIDADES</th>
                                <th></th>
                            </tr>
                            @foreach($regioes as $regiao)
                                <tr>
                                    <th>{!! $regiao->id !!}</th>
                                    <td>{!! $regiao->nomeregiao !!}</td>
                                    <td>{!! \App\Model\Regioes::contaQtdUnidades($regiao->id) !!}</td>
                                    <td>
                                        @foreach(\App\Model\Regioes::UnidadesRegiao($regiao->id) as $ur)
                                            <p>{{ $ur->nomeunidade }}</p>
                                        @endforeach
                                    </td>
                                    <td>
                                        <div class="hidden-sm hidden-md btn-group">
                                            <a href="{{ route('regioes.editar', ['id'=>$regiao->id]) }}" title="Editar "  class="btn btn-xs btn-info">
                                                <i class="ace-icon fa fa-pencil bigger-120"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </table>
                    </div>

            </div>
        </div>


@endsection
