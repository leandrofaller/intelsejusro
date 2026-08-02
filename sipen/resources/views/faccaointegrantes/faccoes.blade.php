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

                @forelse($faccoes as $faccoe)
                        <div class="col-md-4  pricing-box">
                            <div class="widget-box widget-color-blue">
                                <div class="widget-header">
                                    <h5 class="widget-title bigger lighter">{!! $faccoe->nomefaccao !!}</h5>
                                </div>

                                <div class="widget-body">
                                    <div class="widget-main">
                                        <ul class="list-unstyled spaced2">
                                            <li>
                                                <i class="ace-icon fa fa-check green"></i>
                                                Fundação: {!! $faccoe->anofundacao !!}
                                            </li>
                                            <li>
                                                <i class="ace-icon fa fa-check green"></i>
                                                Sigla:  {!! $faccoe->sigla !!}
                                            </li>
                                            <hr>
                                                <li><i class="ace-icon fa fa-check green"></i>Sob Análise:
                                                    {!! \App\Model\Integrantes::contaIntegrantesInvestigacao($faccoe->id)[0] !!}
                                                </li>
                                                <li><i class="ace-icon fa fa-check green"></i>Comprovados:
                                                    {!! \App\Model\Integrantes::contaIntegrantesComprovado($faccoe->id)[0] !!}
                                                </li>
                                            <hr>

                                        </ul>

                                       <div class="pull-left">
                                           <small>Total Faccionados</small>
                                           <div class="price">
                                               {!! \App\Model\Integrantes::contaIntegrantes($faccoe->id)[0] !!}
                                           </div>
                                       </div>
                                       <div class="pull-right">
                                           <small>Total Geral</small>
                                           <div class="price">
                                               {!! \App\Model\Integrantes::contaIntegrantesGeral($faccoe->id)[0] !!}
                                           </div>
                                       </div>
                                    </div>

                                    <div>
                                        <a href="{{ route('faccaointegrantes.listarporfaccao', [$faccoe->id, 2]) }}" class="btn btn-block btn-inverse">
                                            <i class="ace-icon fa fa-list bigger-110"></i>
                                            <span>LISTAR SOB ANÁLISE</span>
                                        </a>
                                        <a href="{{ route('faccaointegrantes.listarporfaccao', [$faccoe->id, 1] ) }}" class="btn btn-block btn-inverse">
                                            <i class="ace-icon fa fa-list bigger-110"></i>
                                            <span>LISTAR COMPROVADOS</span>
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