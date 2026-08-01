@extends('layouts.template')

@section('titulo', 'SRDA')

@section('conteudo')
    {{ HTML::style('resources/assets/css/ficha-print.css') }}
    <div class="page-header">
        <h1>
            {{ $titulo }}
            <small>
                <i class="ace-icon fa fa-angle-double-right"></i>
                {{ $subtitulo }}
            </small>
            <span class="pull-right">
              <a href="{!! route('home') !!}" class="btn btn-xs btn-light bigger"> <i class="ace-icon fa fa-arrow-left"></i> Voltar </a>
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

    <div class="widget-header widget-header-large">
        <h3 class="widget-title grey lighter">
            <i class="ace-icon fa fa-arrow-circle-right"></i>
            Aguardando Recebimento
        </h3>

        <!-- #section:pages/invoice.info -->
        <div class="widget-toolbar no-border invoice-info">
            <span class="invoice-info-label">Total:</span>
            <span class="red"> {{ count($presos)  }}</span>

            <br>
            <span class="invoice-info-label">Data:</span>
            <span class="blue">{{ date('d/m/Y')  }}</span>
        </div>

        <div class="widget-toolbar hidden-480">
            <a href="#">
                <i class="ace-icon fa fa-print"></i>
            </a>
        </div>

        <!-- /section:pages/invoice.info -->
    </div>



    <div class="row">
        <div class="col-xs-12">
            <div class="table-responsive">
                <table id="simple-table" class="table table-striped table-bordered table-hover">
                    <thead>
                        <tr class="">
                            <th>#</th>
                            <th>NOME</th>
                            <th>DATA TRANSFERÊNCIA</th>
                            <th>UNIDADE DE ORIGEM</th>
                            <th>ARTIGO</th>
                            <th>EXECUÇÃO</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                    @forelse($presos as $preso)
                        <tr>
                            <th>{!! $preso->idApen !!}</th>
                            <td>{!! $preso->nomeapenado !!}</td>
                            <td>{!! strftime('%d/%m/%Y',strtotime($preso->dataentrada)) !!}</td>
                            <td>{!! \App\Model\Apenado::mostraUnidadeOrigem($preso->idProc, $preso->oficioentrada) !!}</td>
                            <td>{!! $preso->artigos !!}</td>
                            <td>{!! $preso->numeroprocesso !!}</td>
                            <td> <a href="{{ route('apenados.recebimento', ['id'=>$preso->idApen]) }}" class="btn btn-xs btn-warning" title="Recebimento de Apenado" > <i class="ace-icon fa fa-arrow-circle-right bigger-120"></i> </a> </td>
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
        </div>
    </div>



@endsection

