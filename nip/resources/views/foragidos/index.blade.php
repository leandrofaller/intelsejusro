@extends('layouts.template')

@section('conteudo')
<?php
use App\Model\Apenado;
?>

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


        <!-- /.row -->
        <div class="row">
            <div class="col-xs-12">



                <div class="table-responsive">
                   <table id="simple-table" class="table table-striped table-bordered table-hover">
                        <thead>
                            <tr class="">
                                <th>#</th>
                                <th>NOME DO APENADO</th>
                                <th>DATA NASCIMENTO</th>
                                <th>UNIDADE PRISIONAL DA FUGA</th>
                                <th>CELA</th>
                                <th>TIPO</th>
                                <th>DATA</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($apenados as $apenado)
                                    <tr>
                                        <th>{!! $apenado->id !!}</th>
                                        <td>{!! $apenado->nomeapenado !!}</td>
                                        <td>{!! strftime('%d/%m/%Y',strtotime($apenado->datanascimento)) !!}</td>
                                        <td>{!! $apenado->nomeunidade !!}</td>
                                        <td>{!! $apenado->nomecela !!}</td>
                                        <td>{!! tiposaida($apenado->tipo) !!}</td>
                                        <td>{!! strftime('%d/%m/%Y',strtotime($apenado->datafuga)) !!}</td>
                                        <td>
                                            <a href="{{ route('foragidos.recaptura', ['id'=>$apenado->id]) }}" class="btn btn-xs btn-danger" title="Apenado Recapturado" > <i class="ace-icon fa fa-paw bigger-120"></i> </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="12">
                                            <div class="well text-center ">
                                                <h2 class="text-danger"> <i class="fa fa-warning"></i> Sem foragido no Sistema Prisional!</h2>
                                            </div>
                                    </tr>
                                @endforelse
                            </tbody>
                   </table>
                    {!! $apenados->render() !!}
                </div>
                  
                <!-- /.box -->
            </div>
        </div>

@endsection