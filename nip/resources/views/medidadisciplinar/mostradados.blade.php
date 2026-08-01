@extends('layouts.template')

@section('conteudo')

    <div class="page-header">
        <h1>
            {{ $titulo }}
            <small>
                <i class="ace-icon fa fa-angle-double-right"></i>
                {{ $subtitulo }}
            </small>
            <span class="pull-right">
              <a href="{!! route('medidadisciplinar.index' ) !!}" class="btn btn-xs btn-light bigger"> <i class="ace-icon fa fa-arrow-left"></i> Voltar </a>
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

    <div class="row">

        <div class="col-md-9">
            <div class="widget-box widget-color-red">
                <div class="widget-header">
                    <h4 class="widget-title">DADOS PESSOAIS</h4>
                </div>

                <div class="widget-body">
                    <div class="widget-main no-padding">
                        <fieldset>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        {!! Form::label('nomeapenado','Nome do Apenado')  !!}
                                        {!! Form::text('nomeapenadoc', $apenado->nomeapenado, ['class' => 'form-control','id'=>'nomeapenado', 'readonly']) !!}
                                    </div>
                                </div>


                                <div class="col-md-3">
                                    <div class="form-group">
                                        {!! Form::label('cpf','Cpf do Apenado')  !!}
                                        {!! Form::text('cpfc', $apenado->cpf, ['class' => 'form-control cpf','id'=>'cpf','readonly']) !!}
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        {!! Form::label('mae','Nome Mae')  !!}
                                        {!! Form::text('mae', $apenado->nomemae , ['class' => 'form-control', 'readonly']) !!}
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        {!! Form::label('pai','Nome Pai')  !!}
                                        {!! Form::text('pai', $apenado->nomepai , ['class' => 'form-control', 'readonly']) !!}
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <div class="form-group">
                                        {!! Form::label('unidadec','Unidade Prisional')  !!}
                                        {!! Form::text('unidadec', $apenado->nomeunidade , ['class' => 'form-control', 'readonly']) !!}
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        {!! Form::label('cela','Cela Atual')  !!}
                                        {!! Form::text('celac', $apenado->nomecela , ['class' => 'form-control', 'readonly']) !!}
                                    </div>
                                </div>
                        </fieldset>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="widget-box widget-color-red">
                <div class="widget-header">
                    <h4 class="widget-title">FOTO DO APENADO</h4>
                </div>

                <div class="widget-body">
                    <div class="widget-main no-padding">
                        <fieldset>

                                <div>
                                    <img class="img-responsive" style="height: 225px;"  src=""/>
                                </div>

                        </fieldset>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <div class="row">

        <div class="col-md-12">

            <div class="widget-box widget-color-red">
                <div class="widget-header">
                    <h4 class="widget-title">MEDIDA DISCIPLINAR</h4>
                    <span class="pull-right">
                        <a href="#" class="btn btn-purple bigger" id="btnNovo" name="btnNovo" >
                            <i class="ace-icon fa fa-plus"></i> INCLUSÃO DE MEDIDA DISCIPLINAR</a>
                    </span>
                </div>

                <div class="widget-body">
                    <div class="widget-main no-padding">
                        <fieldset>
                            <div class="table-responsive">
                                <table id="simple-table" class="table table-striped table-bordered table-hover">
                                    <thead>
                                    <tr class="">
                                        <th>#</th>
                                        <th>OCORRÊNCIA</th>
                                        <th>TIPO</th>
                                        <th>TEMPO</th>
                                        <th>DATA INÍCIO</th>
                                        <th>PLANTÃO</th>
                                        <th>DATA FIM</th>
                                        <th>DATA BAIXA</th>
                                        <th>SITUAÇÃO</th>
                                        <th></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @forelse($disciplinas as $disciplina)
                                        <tr>
                                            <td data-id={!! $disciplina->id !!}>{!! $disciplina->id !!}</td>
                                            <td data-ocorrencia_md="{!! $disciplina->ocorrencia_md !!}">{!! $disciplina->ocorrencia_md !!}</td>
                                            <td data-tipomedida_md="{!! $disciplina->tipomedida_md !!}">{!! $disciplina->tipomedida_md !!}</td>
                                            <td data-tempo_md="{!! $disciplina->tempo_md !!}">{!! $disciplina->tempo_md !!}</td>
                                            <td data-datainicio_md="{{strftime('%d/%m/%Y',strtotime($disciplina->datainicio_md))}}"> {!! strftime('%d/%m/%Y',strtotime($disciplina->datainicio_md)) !!}</td>
                                            <td data-plantao_md="{!! $disciplina->plantao_md !!}">{!! $disciplina->plantao_md !!}</td>
                                            <td data-datafim_md="{{strftime('%d/%m/%Y',strtotime($disciplina->datafim_md))}}"> {!! strftime('%d/%m/%Y',strtotime($disciplina->datafim_md)) !!}</td>
                                            <td> {!! $disciplina->databaixa_md == NULL ? '' : strftime('%d/%m/%Y',strtotime($disciplina->databaixa_md)) !!}</td>
                                            <td> {!! datamaior($disciplina->datainicio_md, $disciplina->datafim_md, $disciplina->databaixa_md) !!}</td>
                                            <td class="hidden" data-unidades_md="{!! $disciplina->unidades_md !!}"></td>
                                            <td class="hidden" data-descricao_md="{!! $disciplina->descricao_md !!}"></td>
                                            <td class="hidden" data-apenado_id="{!! $apenado->id !!}"></td>

                                            <td>
                                                @if($disciplina->databaixa_md == NULL)
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



                        </fieldset>
                    </div>
                </div>
            </div>
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
                                                {{ Form::text('unidades_md', null, ['id'=>'unidades_md', 'class' => 'form-control ', 'readonly']) }}
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
                                    <input type="hidden" id="apenado_id" name="apenado_id" value="{!! $apenado->id !!}">
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




    <div class="modal fade" id="myModalNovo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog modal-lg " role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">INCLUSÃO DE MEDIDA DISCIPLINAR</h4>
                </div>
                {!! Form::open(['route'=>['medidadisciplinar.salvar'], 'id'=>'formModalSalvar']) !!}
                <div class="modal-body" id="modalbody">
                    NOVO
                    <div class="widget-box widget-color-dark ">

                        <div class="widget-body">
                            <div class="widget-main no-padding">
                                <fieldset>
                                    <input name="apenado_id" id="apenado_id" type="hidden" value="{{$apenado->id}}">
                                    <input name="movimentacao_id" id="movimentacao_id" type="hidden" value="{{$apenado->idMovimentacao}}">
                                    <input name="processo_id" id="processo_id" type="hidden" value="{{$apenado->idProcesso}}">
                                    <input name="unidade_id" id="unidade_id" type="hidden" value="{{$apenado->unidade_id}}">

                                 <div class="row container-fluid" >
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            {!! Form::label('tipomedida_md', 'Tipo de Medida Disciplinar')  !!}  <small class="red">*</small>
                                            {{ Form::select('tipomedida_md', \App\Model\MedidaDisciplinar::$tipo, null, ['id'=>'tipomedida_md','class' => 'form-control' ]) }}
                                        </div>
                                    </div>

                                    <div class="col-md-8">
                                        <div class="form-group">
                                             {!! Form::label('unidades_md','Justificativa') !!} <small class="red">Para sair na Lista Geral</small>
                                             {{ Form::text('unidades_md', null, ['id'=>'unidades_md', 'maxlength'=>'70', 'class' => 'form-control naoValidar']) }}
                                        </div>
                                    </div>
                                 </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            {!! Form::label('datainicio_md1', 'Data Início')  !!} <small class="red">*</small>
                                            {{ Form::text('datainicio_md1', null, ['id'=>'datainicio_md1','class' => 'form-control date']) }}
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            {!! Form::label('tempo_md1', 'Tempo da Disciplina')  !!} <small class="red"> *</small>
                                            {{ Form::select('tempo_md1', \App\Model\MedidaDisciplinar::$tempo, null, ['id'=>'tempo_md1','class' => 'form-control' ]) }}
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            {!! Form::label('datafim_md1', 'Data Fim')  !!} <small class="red"> *</small>
                                            {{ Form::text('datafim_md1', null, ['id'=>'datafim_md1','class' => 'form-control', 'readonly']) }}
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            {!! Form::label('plantao_md','Plantão Responsável') !!} <small class="red"> *</small>
                                            {{ Form::text('plantao_md', null, ['id'=>'plantao_md', 'raws' => '3', 'class' => 'form-control naoValidar']) }}
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            {!! Form::label('ocorrencia_md', 'Número Ocorrência') !!} <small class="red"> *</small>
                                            {{ Form::text('ocorrencia_md', null, ['id'=>'ocorrencia_md','class' => 'form-control']) }}
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            {!! Form::label('descricao_md','Descrição da Ocorrência') !!} <small class="red"> *</small>
                                            {{ Form::textarea('descricao_md', null, ['id'=>'descricao_md', 'rows' => '3', 'class' => 'form-control']) }}
                                        </div>
                                    </div>
                                </fieldset>
                            </div>
                        </div>
                    </div>


                </div>
                <div class="modal-footer">
                    <button class="btn btn-success" id="btnModalsalvar" type="submit">SALVAR</button>
                </div>
                {{ Form::close() }}
            </div>
        </div>
    </div>


@endsection

@section('scripts')

    {{ HTML::script('resources/assets/js/medidadisciplinar/script.js') }}

    {{ HTML::script('resources/assets/chosen/chosen.jquery.js') }}
    {{ HTML::script('resources/assets/chosen/chosen.js') }}

    {{ HTML::script('resources/assets/js/datepickerJS/bootstrap-datepicker.min.js') }}
    {{ HTML::script('resources/assets/js/datepickerJS/bootstrap-datepicker.pt-BR.min.js') }}

    {{ HTML::script('resources/assets/js/mask/maskedinput.min.js') }}
    {{ HTML::script('resources/assets/js/validacao/formatainput.js') }}
    {{ HTML::script('resources/assets/js/moment.js') }}


@stop

