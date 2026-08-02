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
            <div class="col-md-12">
                <div  style="width: 350px;">
                    {!!Form::open ( ['route'=>'pad.index','method' => 'GET','id'=>'formulario'] ) !!}
                            {!! Form::Text('parametro',null, ['class' => 'form-control pull-right','maxlength'=> 100,'placeholder' => 'Digite o Nome ou Cpf e Tecle Enter para Pesquisar','id'=>'parametro']) !!}
                    {!! Form::close() !!}
                </div>
            </div>
        </div>

        <div class="row">
            @if(!empty($apenados))
            <div class="col-xs-12">
                <div class="table-responsive">
                   <table id="simple-table" class="table table-striped table-bordered table-hover">
                        <thead>
                            <tr class="">
                                <th>#</th>
                                <th>NOME DO APENADO</th>
                                <th>CPF</th>
                                <th>UNIDADE PRISIONAL ATUAL</th>
                                <th>CELA</th>
                                <th>SITUAÇÃO</th>
                               <th></th>
                            </tr>
                            </thead>
                            <tbody>    
                            @forelse($apenados as $apenado)
                                <?php
                                $status = \App\Model\Apenado::situacaoAtual($apenado->id);
                                $legenda = verificastatus($apenado->id);
                                ?>
                                <tr>
                                    <th>{!! $apenado->id !!}</th>
                                    <td>{!! $apenado->nomeapenado !!}</td>
                                    <td>{!! $apenado->cpf !!}</td>
                                    <td>{!! Apenado::mostraunidadeAtual($apenado->id) !!}</td>
                                    <td>{!! Apenado::mostracelaAtual($apenado->id) !!}</td>
                                    <td>{!! $legenda !!}</td>

                                    <td>
                                        @if( $status  == 'Apenado Preso' )
                                            <a href="{{ route('pad.mostradados',$apenado->id ) }}" class="btn btn-xs btn-info" title="Incluir Visitante" > <i class="ace-icon fa fa-plus-square
 bigger-120"></i> </a>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="12">
                                        <div class="well text-center ">
                                            <h2 class="text-danger"> <i class="fa fa-warning"></i> Nenhum Registro Encontrado!</h2>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse

                            </tbody>
                   </table>
                </div>
                <!-- /.box -->
            </div>
            @else
                <div class="col-md-12">
                    <div class="well text-center ">
                        <h2 class="text-info"> <i class="fa fa-warning"></i> Pesquise o Apenado</h2>
                    </div>
                </div>
            @endif

        </div>






@endsection