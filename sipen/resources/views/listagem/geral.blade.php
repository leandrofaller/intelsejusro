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
            Geral
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

            <a href="{!! route('listagem.exportarBaseGeralExcel', 'resumido' ) !!}" title="GERAR EXCEL" class="btn btn-default">
                <i class="ace-icon fa fa-file-excel-o"></i> EXPORTAR BASE GERAL MEDIDA DISCIPLINAR
            </a>
            <a href="{!! route('listagem.exportarBaseGeralExcel', 'geral' ) !!}" title="GERAR EXCEL" class="btn btn-default">
                <i class="ace-icon fa fa-file-excel-o"></i> EXPORTAR BASE GERAL
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
                            <th>ORDEM</th>
                            {{--<th>CÓDIGO</th>--}}
                            <th>NOME</th>
                            <th>CELA</th>
                            <th>DATA ENTRADA</th>
                            <th>ARTIGO</th>
                            <th>EXECUÇÃO</th>
                            <th>MOTIVO TEMPORÁRIA</th>
                            <th>MEDIDA DISCIPLINAR</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php $i = 1;?>
                    @forelse($presos as $preso)
                        <tr>
                            <th>{!! $i++ !!}</th>
                            {{--<th>{!! $preso->idApen !!}</th>--}}
                            <td>{!! $preso->nomeapenado !!}</td>
                            <td>{!! $preso->nomecela !!}</td>
                            <td>{!! strftime('%d/%m/%Y',strtotime($preso->dataentrada)) !!}</td>
                            <td>{!! $preso->artigos !!}</td>
                            <td>{!! $preso->numeroprocesso !!}</td>
                            <td>{!! \App\Model\Temporaria::mostraTemporaria($preso->idApen) ?
                                    MotivoTemporarias(\App\Model\Temporaria::mostraTemporaria($preso->idApen)) : '' !!}</td>
                            <td >
                                @foreach(\App\Model\MedidaDisciplinar::listaMedidaDisciplinarAtiva($preso->idApen) as $d)
                                    @if($d->tipomedida_md == 'Outras Unidades')
                                        <span class="badge badge-danger">{!! $d->tipomedida_md !!} - {!! $d->unidades_md !!} - Até {!! dataFormat($d->datafim_md) !!}</span>
                                    @else
                                    <span class="badge badge-danger">{!! $d->tipomedida_md !!} - {!! $d->unidades_md !!} - Até {!! dataFormat($d->datafim_md) !!}</span>
                                    @endif
                                @endforeach
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


    <div class="modal fade" id="myModalRelGeral" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog modal-lg " role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">EXPORTAR BASE GERAL DE APENADOS DA UNIDADE</h4>

                </div>
                {!! Form::open(['route'=>['listagem.exportarBaseGeralExcel', 'xlsx'], 'id'=>'formModalVincular' ]) !!}
                <div class="modal-body" id="modalbody">
                    Selecione os campos que você deseja
                    <div class="widget-box widget-color-dark ">
                        <div class="widget-body">
                            <div class="widget-main no-padding">
                                <fieldset>
                                    <input name="apenado_id" id="apenado_id" type="hidden" value="">


                                        <div class="col-md-3">
                                            <div class="control-group">
                                                <label class="control-label bolder blue">Medida Disciplinar</label>
                                                <!-- #section:custom/checkbox -->
                                                <div class="checkbox">
                                                    <label><input name="exportar[]" type="checkbox" class="ace"><span class="lbl">Mostrar</span></label>
                                                </div>
                                            </div>
                                        </div>

                                </fieldset>
                            </div>
                        </div>
                    </div>

                    <div class="alert alert-danger "> <h1>EM DESENVOLVIMENTO</h1></div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-success" id="btnModalVincular" type="submit"> <i class="ace-icon fa fa-save"></i> EXPORTAR </button>
                </div>
                {{ Form::close() }}


            </div>
        </div>


    </div>


@endsection

@section('scripts')

    {{ HTML::script('js/listagem/script.js') }}

@stop