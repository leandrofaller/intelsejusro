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
                Listagem de Apenados que se encontram em Triagem
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
                            <th>CELA</th>
                            <th>DATA ENTRADA</th>
                            <th>INÍCIO TRIAGEM</th>
                            <th>FIM TRIAGEM</th>
                            <th>TEMPO</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                    @forelse($presos as $preso)
                        <tr>
                            <td>{!! $preso->idApen !!}</td>
                            <td class="hidden" data-id={!! $preso->idMov !!}>{!! $preso->idMov !!}</td>
                            <td class="hidden" data-apenado_id={!! $preso->idApen !!}>{!! $preso->idApen !!}</td>
                            <td data-nomeapenado={!! $preso->nomeapenado !!}>{!! $preso->nomeapenado !!}</td>
                            <td>{!! \App\Model\Apenado::nomecela($preso->cela_id) !!}</td>
                            <td>{!! dataFormat($preso->dataentrada) !!}</td>
                            <td data-data_inicio= {!! dataFormat($preso->triagem_inicio) !!}> {!! dataFormat($preso->triagem_inicio) !!}</td>
                            <td data-data_fim= {!! dataFormat($preso->triagem_fim) !!}> {!! dataFormat($preso->triagem_fim) !!}</td>
                            <td>{!! calculaDias($preso->triagem_inicio, $preso->triagem_fim) !!} </td>

                            <td>
                                @if($preso->triagem_baixa == NULL)
                                    <a href="#" id="btnConcluirTriagem" name="btnConcluirTriagem" class="btn btn-xs btn-danger" title="Concluir Triagem" > <i class="ace-icon fa fa-check-circle bigger-120"></i> </a>
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
    </div>



    <div class="modal fade" id="myModalConcluirTriagem" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog modal-lg " role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">FINALIZAR TRIAGEM</h4>
                </div>

                {!! Form::open(['route'=>['apenados.triagemBaixar'], 'id'=>'formModalConcluir' ]) !!}
                <div class="modal-body" id="modalbody">
                    Informações
                    <div class="widget-box widget-color-dark ">

                        <div class="widget-body">
                            <div class="widget-main no-padding">
                                <fieldset>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            {!! Form::label('data_inicio', 'Data Início')  !!}
                                            {{ Form::text('data_inicio', null, ['id'=>'data_inicio','class' => 'form-control ', 'readonly']) }}
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            {!! Form::label('data_fim', 'Data Fim')  !!}
                                            {{ Form::text('data_fim', null, ['id'=>'data_fim','class' => 'form-control ', 'readonly']) }}
                                        </div>
                                    </div>

                                    <input name="id" id="id" type="hidden">
                                    <input type="hidden" id="apenado_id" name="apenado_id">
                                    <hr>
                                </fieldset>
                            </div>
                        </div>

                    </div>
                    Informações da Conclusão
                    <div class="widget-box widget-color-dark ">

                        <div class="widget-body">
                            <div class="widget-main no-padding">
                                <fieldset>
                                    <div class="col-md-3">
                                        <div class="form-group"><br>
                                            {!! Form::label('databaixa_triagem','Data da Baixa')  !!}
                                            {{ Form::text('databaixa_triagem', null, ['id'=>'databaixa_triagem', 'class' => 'form-control date']) }}
                                        </div>
                                    </div>
                                </fieldset>
                            </div>
                        </div>
                    </div>


                </div>
                <div class="modal-footer">
                    <button class="btn btn-success" id="btnModalCancelar" type="submit"> BAIXAR</button>
                </div>
                {{ Form::close() }}

            </div>
        </div>
    </div>



@endsection


@section('scripts')

    {{ HTML::script('js/triagem/script.js') }}

    {{ HTML::script('js/datepickerJS/bootstrap-datepicker.min.js') }}
    {{ HTML::script('js/datepickerJS/bootstrap-datepicker.pt-BR.min.js') }}

    {{ HTML::script('js/mask/maskedinput.min.js') }}
    {{ HTML::script('js/validacao/formatainput.js') }}

@stop