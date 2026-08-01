<div class="modal fade" id="myModalFichaFaccionado" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-lg " role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">IMPRESSÃO DE FICHA DE FACCIONADO</h4>
            </div>

            {!! Form::open(['route'=>['faccaointegrantes.fichaPrisional'] , 'target'=>'_blanck' ]) !!}

            <div class="modal-body" id="modalbody">
                Selecione os campos que você deseja
                <div class="widget-box widget-color-dark ">
                    <div class="widget-body">
                        <div class="widget-main no-padding">
                            <fieldset>
                                <input name="apenado_id" id="apenado_id" type="hidden" value="">

                                <div class="col-md-4">
                                    <div class="checkbox">
                                        <label class="block">
                                            <input name="listar[]" value="DP" type="checkbox" checked="checked" class="ace input-lg">
                                            <span class="lbl bigger-120"> DADOS PESSOAIS</span>
                                        </label>
                                    </div>
                                    <div class="checkbox">
                                        <label class="block">
                                            <input name="listar[]" value="ER" type="checkbox" class="ace input-lg">
                                            <span class="lbl bigger-120"> ENDEREÇO RESIDENCIAL</span>
                                        </label>
                                    </div>
                                    <div class="checkbox">
                                        <label class="block">
                                            <input name="listar[]" value="IP" type="checkbox" class="ace input-lg">
                                            <span class="lbl bigger-120"> INFORMAÇÕES PRISIONAIS</span>
                                        </label>
                                    </div>
                                    {{--<div class="checkbox">--}}
                                        {{--<label class="block">--}}
                                            {{--<input name="listar[]" value="M" type="checkbox" class="ace input-lg">--}}
                                            {{--<span class="lbl bigger-120"> MOVIMENTAÇÕES</span>--}}
                                        {{--</label>--}}
                                    {{--</div>--}}
                                    {{--<div class="checkbox">--}}
                                        {{--<label class="block">--}}
                                            {{--<input name="listar[]" value="P" type="checkbox" class="ace input-lg">--}}
                                            {{--<span class="lbl bigger-120"> PROCESSOS</span>--}}
                                        {{--</label>--}}
                                    {{--</div>--}}

                                    {{--<div class="checkbox">--}}
                                        {{--<label class="block">--}}
                                            {{--<input name="listar[]" value="MC" type="checkbox" class="ace input-lg">--}}
                                            {{--<span class="lbl bigger-120"> MUDANÇAS DE CELAS</span>--}}
                                        {{--</label>--}}
                                    {{--</div>--}}

                                </div>



                                <div class="col-md-4">
                                    {{--<div class="checkbox">--}}
                                        {{--<label class="block">--}}
                                            {{--<input name="listar[]" value="T" type="checkbox" class="ace input-lg">--}}
                                            {{--<span class="lbl bigger-120"> TEMPORÁRIAS</span>--}}
                                        {{--</label>--}}
                                    {{--</div>--}}
                                    {{--<div class="checkbox">--}}
                                        {{--<label class="block">--}}
                                            {{--<input name="listar[]" value="A" type="checkbox" class="ace input-lg">--}}
                                            {{--<span class="lbl bigger-120"> ADVOGADOS</span>--}}
                                        {{--</label>--}}
                                    {{--</div>--}}
                                    {{--<div class="checkbox">--}}
                                        {{--<label class="block">--}}
                                            {{--<input name="listar[]" value="MD" type="checkbox" class="ace input-lg">--}}
                                            {{--<span class="lbl bigger-120"> MEDIDA DISCIPLINAR</span>--}}
                                        {{--</label>--}}
                                    {{--</div>--}}
                                    {{--<div class="checkbox">--}}
                                        {{--<label class="block">--}}
                                            {{--<input name="listar[]" value="PA" type="checkbox" class="ace input-lg">--}}
                                            {{--<span class="lbl bigger-120"> PAD's</span>--}}
                                        {{--</label>--}}
                                    {{--</div>--}}
                                    <div class="checkbox">
                                        <label class="block">
                                            <input name="listar[]" value="IA" type="checkbox" class="ace input-lg">
                                            <span class="lbl bigger-120"> INF. ADICIONAIS</span>
                                        </label>
                                    </div>
                                    <div class="checkbox">
                                        <label class="block">
                                            <input name="listar[]" value="MF" type="checkbox" class="ace input-lg">
                                            <span class="lbl bigger-120"> MOSTRAR FOTOS </span>
                                        </label>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="checkbox">
                                        <label class="block">
                                            <input name="listar[]" value="DF" type="checkbox" class="ace input-lg">
                                            <span class="lbl bigger-120"> DADOS FACCÕES </span>
                                        </label>
                                    </div>

                                    <div class="checkbox">
                                        <label class="block">
                                            <input name="listar[]" value="HDF" type="checkbox" class="ace input-lg">
                                            <span class="lbl bigger-120"> DETALHAR FACCÕES</span>
                                        </label>
                                    </div>
                                    {{--<div class="checkbox">--}}
                                        {{--<label class="block">--}}
                                            {{--<input name="listar[]" value="AF" type="checkbox" class="ace input-lg">--}}
                                            {{--<span class="lbl bigger-120"> ANEXOS FACÇÕES</span>--}}
                                        {{--</label>--}}
                                    {{--</div>--}}
                                </div>

                            </fieldset>
                        </div>
                    </div>
                </div>


            </div>
            <div class="modal-footer">
                <button class="btn btn-success" id="btnModalVincular" type="submit"> <i class="ace-icon fa fa-save"></i> GERAR FICHA </button>
            </div>
            {{ Form::close() }}


        </div>
    </div>


</div>