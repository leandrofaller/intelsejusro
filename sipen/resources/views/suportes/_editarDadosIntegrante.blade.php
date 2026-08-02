<div class="modal fade" id="myModalEditarDadosIntegrante" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-lg " role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">EDITAR DADOS DO FACCIONADO</h4>
            </div>

            {!! Form::open(['route'=>['faccaointegrantes.updateDadosFaccionado'], 'id'=>'formulario', 'method'=>'put']) !!}

            <div class="modal-body" id="modalbody">
                <div class="widget-box widget-color-dark ">
                    <div class="widget-body">
                        <div class="widget-main no-padding">
                            <fieldset>
                                <input name="CodigoIntegrante" id="CodigoIntegrante" type="hidden" value="{!! $apenado->idIntegrante !!}">
                                <input type="hidden" value="{{ $apenado->id }}" name="CodigoApenado">

                                <div class="col-md-8">
                                    <div class="form-group">
                                        {!! Form::label('atual', 'Faccão Atual')  !!}
                                        {{ Form::text('atual', \App\Model\Faccao::mostraNomeFaccao($apenado->faccao_id), ['class' => 'form-control naoValidar' ,'readonly']) }}
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        {!! Form::label('databatismoatual', 'Data do Batismo Atual')  !!}
                                        {{ Form::text('databatismoatual', $apenado->databatismo ? dataFormat($apenado->databatismo) : '', ['class' => 'form-control naoValidar' ,'readonly']) }}
                                    </div>
                                </div>

                                <div class="col-md-8">
                                    <div class="form-group">
                                        {!! Form::label('novafaccao', 'Nova Faccão')  !!}
                                        {{ Form::select('novafaccao', $faccoes, $apenado->faccao_id, ['class' => 'form-control']) }}

                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        {!! Form::label('novadatabatismo', 'Nova Data de Batismo')  !!}
                                        {{ Form::text('novadatabatismo', $apenado->databatismo ? dataFormat($apenado->databatismo) : '', ['class' => 'form-control date ' ]) }}
                                    </div>
                                </div>
                            </fieldset>
                        </div>
                    </div>
                </div>


            </div>
            <div class="modal-footer">
                <button class="btn btn-success" id="btnModalVincular" type="submit"> <i class="ace-icon fa fa-save"></i> SALVAR </button>
            </div>
            {{ Form::close() }}


        </div>
    </div>


</div>