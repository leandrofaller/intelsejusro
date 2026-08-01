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
                Listagem de Apenados que se encontram em cumprimento de Medida Disciplinar
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
                            <th>TIPO MEDIDA</th>
                            <th>DATA INÍCIO</th>
                            <th>DATA FIM</th>
                            <th>TEMPO</th>
                            <th>PLANTÃO</th>
                            <th>SITUAÇÃO</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                    @forelse($presos as $preso)
                        <tr>

                            <td>{!! $preso->apenado_id !!}</td>
                            <td class="hidden" data-id={!! $preso->id !!}>{!! $preso->id !!}</td>
                            <td class="hidden" data-apenado_id={!! $preso->apenado_id !!}>{!! $preso->apenado_id !!}</td>
                            <td data-nomeapenado={!! $preso->nomeapenado !!}>{!! $preso->nomeapenado !!}</td>
                            <td>{!! \App\Model\Apenado::nomecela($preso->cela_id) !!}</td>
                            <td data-tipomedida_md={!! $preso->tipomedida_md !!}>{!! $preso->tipomedida_md !!}</td>
                            <td data-datainicio_md={!! strftime('%d/%m/%Y',strtotime($preso->datainicio_md)) !!}>{!! strftime('%d/%m/%Y',strtotime($preso->datainicio_md)) !!}</td>
                            <td data-datafim_md={!! strftime('%d/%m/%Y',strtotime($preso->datafim_md)) !!}>{!! strftime('%d/%m/%Y',strtotime($preso->datafim_md)) !!}</td>
                            <td data-tempo_md={!! $preso->tempo_md !!}>{!! $preso->tempo_md !!}</td>
                            <td>{!! $preso->plantao_md !!}</td>
                            <td> {!! datamaior($preso->datainicio_md, $preso->datafim_md, $preso->databaixa_md) !!}</td>

                            <td class="hidden" data-unidades_md="{!! $preso->unidades_md !!}"></td>
                            <td class="hidden" data-descricao_md="{!! $preso->descricao_md !!}"></td>
                            <td class="hidden" data-ocorrencia_md="{!! $preso->ocorrencia_md !!}"></td>

                            <td>   @if($preso->databaixa_md == NULL)
                                    <a href="#" id="btnConcluir" name="btnConcluir" class="btn btn-xs btn-danger" title="Concluir Concluir Castigo" > <i class="ace-icon fa fa-check-circle bigger-120"></i> </a>
                                @endif
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
            <!-- /.box -->
        </div>
    </div>



    <div class="modal fade" id="myModalConcluir" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog modal-lg " role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">FINALIZAR MEDIDA DISCIPLINAR</h4>
                </div>

                {!! Form::open(['route'=>['medidadisciplinar.update'], 'id'=>'formModalConcluir' ]) !!}
                <div class="modal-body" id="modalbody">
                    Informações
                    <div class="widget-box widget-color-dark ">

                        <div class="widget-body">
                            <div class="widget-main no-padding">
                                <fieldset>

                                    <div class="row container-fluid" >
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                {!! Form::label('tipomedida_md', 'Tipo de Medida Disciplinar')  !!}
                                                {{ Form::text('tipomedida_md', null, ['id'=>'tipomedida_md', 'class' => 'form-control', 'readonly']) }}

                                            </div>
                                        </div>

                                        <div class="col-md-8">
                                            <div class="form-group">
                                                {!! Form::label('unidades_md','Sigla Unidade Origem')  !!}
                                                {{ Form::text('unidades_md', null, ['id'=>'unidades_md', 'class' => 'form-control', 'readonly']) }}
                                            </div>
                                        </div>

                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            {!! Form::label('datainicio_md', 'Data Início')  !!}
                                            {{ Form::text('datainicio_md', null, ['id'=>'datainicio_md','class' => 'form-control ', 'readonly']) }}
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            {!! Form::label('tempo_md', 'Tempo da Disciplina')  !!}
                                            {{ Form::text('tempo_md', null, ['id'=>'tempo_md', 'class' => 'form-control ', 'readonly']) }}
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            {!! Form::label('datafim_md', 'Data Fim')  !!}
                                            {{ Form::text('datafim_md', null, ['id'=>'datafim_md','class' => 'form-control ', 'readonly']) }}
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            {!! Form::label('plantao_md','Plantão Responsável')  !!}
                                            {{ Form::text('plantao_md', null, ['id'=>'plantao_md', 'raws' => '3', 'class' => 'form-control naoValidar', 'readonly']) }}
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            {!! Form::label('ocorrencia_md', 'Número Ocorrência')  !!}
                                            {{ Form::text('ocorrencia_md', null, ['id'=>'ocorrencia_md','class' => 'form-control', 'readonly']) }}
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            {!! Form::label('descricao_md','Descrição da Ocorrência')  !!}
                                            {{ Form::textarea('descricao_md', null, ['id'=>'descricao_md', 'rows' => '3', 'class' => 'form-control', 'readonly']) }}
                                        </div>
                                    </div>

                                    <input name="id" id="id" type="hidden">
                                    <input name="guiaList" id="guiaList" type="hidden" value="listagem{!! $tipo !!}">
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
                                    <div class="col-md-9">
                                        <div class="form-group">
                                            {!! Form::label('descricaobaixa_md','Informações Adicionais sobre a baixa')  !!}
                                            {{ Form::textarea('descricaobaixa_md', null, ['id'=>'descricaobaixa_md', 'rows' => '3', 'class' => 'form-control naoValidar']) }}
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group"><br>
                                            {!! Form::label('databaixa_md','Data da Baixa')  !!}
                                            {{ Form::text('databaixa_md', null, ['id'=>'databaixa_md', 'class' => 'form-control date']) }}
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

    {{ HTML::script('js/medidadisciplinar/script.js') }}

    {{ HTML::script('js/datepickerJS/bootstrap-datepicker.min.js') }}
    {{ HTML::script('js/datepickerJS/bootstrap-datepicker.pt-BR.min.js') }}

    {{ HTML::script('js/mask/maskedinput.min.js') }}
    {{ HTML::script('js/validacao/formatainput.js') }}

@stop