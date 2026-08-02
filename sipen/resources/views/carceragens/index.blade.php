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
              <a href="{{ route('unidadesprisionais.index') }}" class="btn btn-xs btn-light bigger"> <i class="ace-icon fa fa-arrow-left"></i> Voltar </a>
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
                <div class="pull-right"> <a href="{{route('carceragens.novo', ['idUnidade'=>$unidade->id] )}}" class="btn btn-grey"> Nova Carceragem </a> </div>
                <h4 class="green smaller lighter">Carceragens da Unidade</h4>
                <h2 class="box-title">{!! $unidade->nomeunidade !!}</h2>

            </div>
            <!-- /.box-header -->

            <div class="table-responsive">
                <table id="simple-table" class="table table-striped table-bordered table-hover">
                    <tr>
                        <th>#</th>
                        <th>Nome</th>
                        <th>Tipo</th>
                        <th>Facção</th>
                        <th>Status</th>
                        <th></th>
                    </tr>

                        @forelse($carceragens as $carceragem)
                            <tr>
                                <th>{!! $carceragem->id !!}</th>
                                <td>{!! $carceragem->nomecarceragem !!}</td>
                                <td>{!! $carceragem->tipocarceragem !!}</td>
                                <td>{!! \App\Model\Faccao::mostraSiglaFaccao($carceragem->faccao) !!}</td>
                                <td>{!! $carceragem->status !!}</td>
                                <td>

                                    <div class="hidden-sm hidden-mds btn-group">
                                        <a href="{{ route('carceragens.editar', ['id'=>$carceragem->id, 'idUnidade'=>$carceragem->unidade_id]) }}" title="Editar Carceragem "  class="btn btn-xs btn-info">
                                            <i class="ace-icon fa fa-pencil bigger-120"></i>
                                        </a>
                                        <a href="{{ route('celas.index', ['idCarceragem'=>$carceragem->id]) }}" title="Listar Celas" class="btn btn-xs btn-warning">
                                            <i class="ace-icon fa fa-list-ul bigger-120"></i>
                                        </a>
                                    </div>

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
