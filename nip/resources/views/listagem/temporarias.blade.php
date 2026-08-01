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
            <i class="ace-icon fa fa-leaf green"></i>
                Listagem de Apenados
        </h3>
        <!-- #section:pages/invoice.info -->
        <div class="widget-toolbar no-border invoice-info">
            <span class="invoice-info-label">Total:</span>
            <span class="red"> {{ count($presos)  }}</span>
            <br>
            <span class="invoice-info-label">Data:</span>
            <span class="blue">{{ date('d/m/Y')  }}</span>
        </div>
        <div class="widget-toolbar hidden-480"> </div>
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
                            <th>CELA</th>
                            <th>DATA SAÍDA</th>
                            <th>MOTIVO</th>
                            <th>TEMPO</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                    @forelse($presos as $preso)
                        <tr>
                            <td>{!! $preso->id !!}</td>
                            <td>{!! $preso->apenados->nomeapenado  !!}</td>
                            <td>{!! $preso->movimentacoes->celas->nomecela !!} </td>
                            <td>{!! dataFormat($preso->datasaida) !!} <span class="badge"> {!! $preso->horasaida !!}</span> </td>
                            <td>{!! MotivoTemporarias($preso->motivo) !!}</td>
                            <td>{!! calculaDias($preso->datasaida, $preso->dataretorno) !!} </td>

                            <td>
                                @if($preso->dataretorno == NULL)
                                   <a href="{!! route('temporarias.editar', $preso->id) !!}"  class="btn btn-xs btn-danger" title="Baixa" > <i class="ace-icon fa fa-check-circle "></i> </a>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="12">
                                <div class="well text-center">
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
    </div>






@endsection


@section('scripts')

    {{ HTML::script('js/datepickerJS/bootstrap-datepicker.min.js') }}
    {{ HTML::script('js/datepickerJS/bootstrap-datepicker.pt-BR.min.js') }}

    {{ HTML::script('js/mask/maskedinput.min.js') }}
    {{ HTML::script('js/validacao/formatainput.js') }}

@stop