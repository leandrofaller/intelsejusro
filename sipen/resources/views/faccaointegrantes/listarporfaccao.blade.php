@extends('layouts.template')

@section('conteudo')
<?php
use App\Model\Apenado;
use App\Model\Integrantes;
?>

    <div class="page-header">
        <h1>
            {{ $titulo }}
            <small>
                <i class="ace-icon fa fa-angle-double-right"></i>
                {{ $subtitulo }}
            </small>
            <span class="pull-right">
              <a href="{!! route('faccaointegrantes.faccoes' ) !!}" class="btn btn-xs btn-light bigger"> <i class="ace-icon fa fa-arrow-left"></i> Voltar </a>
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
    <div class="col-md-6">
        <div class=" alert alert-warning "> Integrantes do
           <h2> {{ $faccao->nomefaccao  }} </h2>
        </div>
    </div>
    <div class="col-md-3">
        <div class="alert alert-info "> Sigla
            <h2> {{ $faccao->sigla  }} </h2>
        </div>
    </div>

    <div class="col-md-3">
        <div class="alert alert-danger"> Total de  Integrantes
            <h2> {{ count($apenados) }} </h2>
        </div>
    </div>

</div>


        <div class="row">
            <div class="col-md-12">
                <span class="pull-right">
                  {{--<a href="{!! route('relatorios.integrantesFaccao_pdf', $faccao->id ) !!}" class="btn btn-danger bigger"> <i class="ace-icon fa fa-file-pdf-o"></i> GERAR PDF </a>--}}
                </span>
            </div>
        </div>

        <!-- /.row -->
        <div class="row">
            <div class="col-md-12">
                <div  style="width: 350px;">
                    {{--{!! Form::open(['route'=>['faccaointegrantes.listarporfaccao',$faccao->id], 'id'=>'formulario', 'method'=>'GET']) !!}--}}
                        {{--{!! Form::Text('parametro',null, ['class' => 'form-control pull-right','maxlength'=> 100,'placeholder' => 'Digite o Nome ou Cpf e Tecle Enter para Pesquisar','id'=>'parametro']) !!}--}}
                    {{--{!! Form::close() !!}--}}
                </div>
            </div>
        </div>



        <div class="row">
            <div class="col-xs-12">
                <div class="table-responsive">
                   <table id="simple-table" class="table table-striped table-bordered table-hover">
                        <thead>
                            <tr class="">
                                <th>#</th>
                                <th>COMARCA</th>
                                <th>NOME DO APENADO</th>
                                <th>UNIDADE PRISIONAL ATUAL</th>
                                <th>FACCÃO</th>
                                <th>CARGO</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($apenados as $apenado)

                                <tr>
                                    <th>{!! $apenado->idApen !!}</th>
                                    <td>{!! $apenado->cidadeunidade !!}</td>
                                    <td>{!! $apenado->nomeapenado !!}</td>
                                    <td>{!! $apenado->nomeunidade !!}</td>
                                    <td>{!! $apenado->nomefaccao !!}</td>
                                    <td>{!! \App\Model\Integrantes::mostraCargoAtual($apenado->idInteg) !!}</td>
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
                <!-- /.box -->
                {{--{!! $apenados->render() !!}--}}

            </div>
        </div>





@endsection

