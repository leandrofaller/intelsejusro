@extends('layouts.template')

@section('conteudo')

    <div class="page-header">
        <h1>
            {{ $titulo }}
            <small>
                <i class="ace-icon fa fa-angle-double-right"></i>
                {{ $subtitulo }}
            </small>
            <span class="pull-right">
                  <a href="{!! route('carceragens.index', $carceragem->unidade_id) !!}" class="btn btn-xs btn-light bigger"> <i class="ace-icon fa fa-arrow-left"></i> Voltar </a>
            </span>
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
            <div class="well">
                <div class="pull-right"> <a href="{{route('celas.novo', ['idCarceragem'=> $carceragem->id])}}" class="btn btn-grey"> Nova Cela </a> </div>
                <h4 class="green smaller lighter">Celas da Carceragem</h4>
                <h2 class="box-title">{!! $carceragem->nomecarceragem !!}</h2>
            </div>
            <!-- /.box-header -->

            <div class="table-responsive">
                <table id="simple-table" class="table table-striped table-bordered table-hover">
                    <tr>
                        <th>#</th>
                        <th>Nome</th>
                        <th>Capacidade</th>
                        <th>Tipo</th>
                        <th>Status</th>
                        <th></th>
                    </tr>

                        @forelse($celas as $cela)
                            <tr>
                                <th>{!! $cela->id !!}</th>
                                <td>{!! $cela->nomecela !!}</td>
                                <td>{!! $cela->capacidade !!}</td>
                                <td>{!! $cela->tipocela !!}</td>
                                <td>{!! $cela->status !!}</td>
                                <td>
                                    <div class="hidden-sm hidden-md btn-group">
                                        <a href="{{ route('celas.editar', ['id'=>$cela->id, 'idCarceragem'=>$cela->carceragem_id]) }}" title="Editar Cela "  class="btn btn-xs btn-info">
                                            <i class="ace-icon fa fa-pencil bigger-120"></i>
                                        </a>
                                    </div>
                                    <a href="{{route('celas.destroy', ['id'=>$cela->id, 'idCarceragem'=>$cela->carceragem_id]) }}" type="submit"
                                       onclick="return confirm('Deseja realmente excluir esta Cela?');"
                                       class="btn btn-danger btn-sm"><i class="fa fa-trash"></i> </a>

                                </td>
                            </tr>
                    @empty
                        <tr>
                            <td colspan="12">
                                <div class="well text-center ">
                                    <h2 class="text-danger"> <i class="fa fa-warning"></i> Nenhum Registro Encontrado!</h2>
                                </div>
                        </tr>
                    @endforelse
                </table>
            </div>

        </div>
    </div>





@endsection

