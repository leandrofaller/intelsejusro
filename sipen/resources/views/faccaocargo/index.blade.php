@extends('layouts.template')

@section('conteudo')


    <div class="page-header">
        <h1>
            {{ $titulo }}
            <small>
                <i class="ace-icon fa fa-angle-double-right"></i>
                {{ $subtitulo }}
            </small>
            <div class="pull-right"> <a href="{{ route('faccaocargo.novo')  }}" class="btn btn-grey"> Novo Cargo</a> </div>
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
                                <thead>
                                    <tr class="">
                                        <th>#</th>
                                        <th>NOME DO CARGO</th>
                                        <th>DESCRIÇÃO</th>
                                        <th>NIVEL</th>
                                        <th>FACÇÃO</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                    <tbody>
                                        @forelse($cargos as $cargo)
                                            <tr>
                                                <th>{!! $cargo->id !!}</th>
                                                <td>{!! $cargo->nomecargo !!}</td>
                                                <td>{!! $cargo->descricao !!}</td>
                                                <td>{!! $cargo->nivel !!}</td>
                                                <td>{!! $cargo->faccoes->nomefaccao !!}</td>
                                                <td>
                                                    <a href="{{ route('faccaocargo.editar', ['id'=>$cargo->id]) }}" class="btn btn-xs btn-info" title="Editar Cargo de Facção" > <i class="ace-icon fa fa-pencil-square bigger-120"></i> </a>
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


                                    </tbody>
                            </table>
                </div>
            </div>
        </div>


@endsection
