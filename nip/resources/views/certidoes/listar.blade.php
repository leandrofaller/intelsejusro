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


        <!-- /.row -->
        <div class="row">
            <div class="col-md-12">
                <div  style="width: 350px;">
                    {!!Form::open ( ['route'=>'certidoes.listar','method' => 'GET','id'=>'formulario'] ) !!}
                            {!! Form::Text('parametro',null, ['class' => 'form-control pull-right','maxlength'=> 100,'placeholder' => 'Digite o Nome ou a Chave e Tecle Enter para Pesquisar','id'=>'parametro']) !!}
                    {!! Form::close() !!}
                </div>
            </div>
        </div>

        <div class="row">
            @if(!empty($certidoes))
            <div class="col-xs-12">
                <div class="table-responsive">
                   <table id="" class="table table-striped table-bordered table-hover">
                        <thead>
                            <tr class="">
                                <th>#</th>
                                <th>NOME DO APENADO</th>
                                <th>UNIDADE PRISIONAL ATUAL</th>
                                <th>CHAVE</th>
                                <th>TIPO CERTIDÃO</th>
                                <th>DATA</th>
                               <th></th>
                            </tr>
                            </thead>
                            <tbody>

                                @forelse($certidoes as $certidao)
                                    <tr>
                                        <th>{!! $certidao->id !!}</th>
                                        <td>{!! $certidao->nome !!}</td>
                                        <td>{!! \App\Model\Unidade::mostraNomeUnidade($certidao->unidade_id) !!}</td>
                                        <td>{!! $certidao->chavevalidacao !!} </td>
                                        <td>{!! $certidao->tipocertidao !!} </td>
                                        <td>{!! dataFormat($certidao->created_at) !!} </td>
                                        <td>
                                            <a href="{{ route('certidoes.mostrar', ['id'=>$certidao->id]) }}" class="btn btn-xs btn-info" title="Emitir Certidão" > <i class="ace-icon fa fa-plus-square"></i> </a>
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
                    {!! $certidoes->render() !!}

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

