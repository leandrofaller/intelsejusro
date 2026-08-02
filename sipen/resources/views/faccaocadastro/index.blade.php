@extends('layouts.template')

@section('conteudo')


    <div class="page-header">
        <h1>
            {{ $titulo }}
            <small>
                <i class="ace-icon fa fa-angle-double-right"></i>
                {{ $subtitulo }}
            </small>
            <div class="pull-right"> <a href="{{ route('faccaocadastro.novo')  }}" class="btn btn-grey"> Nova Facção </a> </div>

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
                                    <th>NOME DA FACÇÃO</th>
                                    <th>SIGLA</th>
                                    <th>ANO FUNDAÇÃO</th>
                                    <th>ORIGEM</th>
                                    <th>HISTÓRICO</th>
                                    <th></th>
                                </tr>
                            </thead>
                                <tbody>
                                    @forelse($faccoes as $faccao)
                                        <tr>
                                            <th>{!! $faccao->id !!}</th>
                                            <td>{!! $faccao->nomefaccao !!}</td>
                                            <td>{!! $faccao->sigla !!}</td>
                                            <td>{!! $faccao->anofundacao !!}</td>
                                            <td>{!! $faccao->origem !!}</td>
                                            <td>{!! $faccao->historico !!}</td>

                                            <td>
                                                <a href="{{ route('faccaocadastro.editar', ['id'=>$faccao->id]) }}" class="btn btn-xs btn-info" title="Editar Cadastro, Mudança de Cela, Alterar Foto e Registrar Saída" > <i class="ace-icon fa fa-pencil-square bigger-120"></i> </a>
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
