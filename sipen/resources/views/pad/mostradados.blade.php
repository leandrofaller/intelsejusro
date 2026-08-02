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
              <a href="{!! route('pad.index' ) !!}" class="btn btn-xs btn-light bigger"> <i class="ace-icon fa fa-arrow-left"></i> Voltar </a>
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
            <div class="widget-box widget-color-blue2 ">
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
            <div class="widget-box widget-color-blue2">
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

            <div class="widget-box widget-color-dark">
                <div class="widget-header">
                    <h4 class="widget-title">PAD CADASTRADOS</h4>
                    <span class="pull-right">
                        <a href="#" class="btn btn-success bigger" id="btnNovo" name="btnNovo" >
                            <i class="ace-icon fa fa-plus"></i> NOVO PAD</a>
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
                                        <th>NÚMERO PAD</th>
                                        <th>DATA PAD</th>
                                        <th>RELATÓRIO SEGURANÇA</th>
                                        <th>TIPO DO FATO</th>
                                        <th>CLASSIFICAÇÃO DA FALTA</th>
                                        <th>DATA CONCLUSÃO</th>
                                        <th>SITUAÇÃO</th>
                                        <th></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @forelse($pads as $pad)
                                        <tr>
                                            <td data-id={!! $pad->id !!}>{!! $pad->id !!}</td>
                                            <td data-numeropad="{!! $pad->numeropad !!}">{!! $pad->numeropad !!}</td>
                                            <td data-datainiciopad="{{strftime('%d/%m/%Y',strtotime($pad->datainiciopad))}}"> {!! strftime('%d/%m/%Y',strtotime($pad->datainiciopad)) !!}</td>
                                            <td data-numerorelatorioseguranca="{!! $pad->numerorelatorioseguranca !!}">{!! $pad->numerorelatorioseguranca !!}</td>
                                            <td data-tipofato="{!! $pad->tipofato !!}">{!! $pad->tipofato !!}</td>
                                            <td data-tipofalta="{!! $pad->tipofalta !!}">{!! $pad->tipofalta !!}</td>

                                            <td>{!! $pad->dataconclusaopad == null ? '' : strftime('%d/%m/%Y',strtotime($pad->dataconclusaopad)) !!}</td>
                                            <td>{!! $pad->situacaopad !!} </td>

                                            <td class="hidden" data-descricaopad="{!! $pad->descricaopad !!}">{!! $pad->descricaopad !!}</td>

                                            <td>
                                                @if($pad->dataconclusaopad == null )
                                                    <a href="#" id="btnConcluir" name="btnConcluir" class="btn btn-xs btn-danger" title="Concluir PAD" > <i class="ace-icon fa fa-check-circle bigger-120"></i> </a>
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
                    <h4 class="modal-title">CONCLUSÃO DE PAD</h4>
                </div>
                {!! Form::open(['route'=>['pad.update'], 'id'=>'formModalConcluir' ]) !!}
                <div class="modal-body" id="modalbody">
                    Informações do Pad
                    <div class="widget-box widget-color-dark ">

                        <div class="widget-body">
                            <div class="widget-main no-padding">
                                <fieldset>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            {!! Form::label('id','Código Pad')  !!}
                                            {{ Form::text('id', null, ['id'=>'id', 'class' => 'form-control', 'readonly']) }}
                                        </div>
                                    </div>

                                    <div class="col-md-8">
                                        <div class="form-group">
                                            {!! Form::label('numeropad','Número do Pad')  !!}
                                            {{ Form::text('numeropad', null, ['id'=>'numeropad', 'class' => 'form-control naoValidar', 'readonly']) }}
                                        </div>
                                    </div>

                                    <div class="col-md-2">
                                        <div class="form-group">
                                            {!! Form::label('datainiciopad', 'Data início')  !!}
                                            {{ Form::text('datainiciopad', null, ['id'=>'datainiciopad','class' => 'form-control', 'readonly']) }}
                                        </div>
                                    </div>



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
                                    <input type="hidden" id="idPad" name="idPad" value="">
                                    <input type="hidden" id="apenado_id" name="apenado_id" value="{!! $apenado->id !!}">

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            {!! Form::label('numerorelatorioseguranca','Número Relatório da Segurança')  !!} <span class="red">*</span>
                                            {{ Form::text('numerorelatorioseguranca', null, ['id'=>'numerorelatorioseguranca', 'class' => 'form-control naoValidar']) }}
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            {!! Form::label('descricaopad','Informações')  !!} <span class="red">*</span>
                                            {{ Form::textarea('descricaopad', null, ['id'=>'descricaopad', 'class' => 'form-control', 'rows'=>'5']) }}
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            {!! Form::label('tipofato', 'Tipo do Fato')  !!} <span class="red">*</span>
                                            {{ Form::select('tipofato', \App\Model\Pad::$fato, null, ['id'=>'tipofato','class' => 'form-control' ]) }}
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            {!! Form::label('tipofalta', 'Classificação da Falta')  !!} <span class="red">*</span>
                                            {{ Form::select('tipofalta', \App\Model\Pad::$tipofalta, null, ['id'=>'tipofalta','class' => 'form-control' ]) }}
                                        </div>
                                    </div>


                                    <div class="col-md-3">
                                        <div class="form-group">
                                            {!! Form::label('dataconclusaopad', 'Data da Conclusão')  !!} <span class="red">*</span>
                                            {{ Form::text('dataconclusaopad', null, ['id'=>'dataconclusaopad','class' => 'form-control date' ]) }}
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            {!! Form::label('situacaopad', 'Situação')  !!} <span class="red">*</span>
                                            {{ Form::select('situacaopad', \App\Model\Pad::$situacao, null, ['id'=>'situacaopad','class' => 'form-control' ]) }}
                                        </div>
                                    </div>


                                    <hr>

                                </fieldset>
                            </div>
                        </div>
                    </div>


                </div>
                <div class="modal-footer">
                    <button class="btn btn-success" id="btnModalCancelar" type="submit"> SALVAR</button>
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
                    <h4 class="modal-title">CADASTRO DE NOVO PAD</h4>
                </div>
                {!! Form::open(['route'=>['pad.salvar'], 'id'=>'formModalSalvar']) !!}
                <div class="modal-body" id="modalbody">
                    NOVO
                    <div class="widget-box widget-color-dark ">

                        <div class="widget-body">
                            <div class="widget-main no-padding">
                                <fieldset>
                                    <input name="apenado_id" id="apenado_id" type="hidden" value={{$apenado->id}}>
                                    <input name="movimentacao_id" id="movimentacao_id" type="hidden" value={{$apenado->idMovimentacao}}>
                                    <input name="processo_id" id="processo_id" type="hidden" value={{$apenado->idProcesso}}>
                                    <input name="unidade_id" id="unidade_id" type="hidden" value={{$apenado->unidade_id}}>


                                    <div class="col-md-9">
                                        <div class="form-group">
                                            {!! Form::label('numerorelatorioseguranca', 'Número Relatório da Segurança')  !!} <span class="red">*</span>
                                            {{ Form::text('numerorelatorioseguranca', null, ['id'=>'numerorelatorioseguranca','class' => 'form-control']) }}
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            {!! Form::label('datainiciopad', 'Data')  !!} <span class="red">*</span>
                                            {{ Form::text('datainiciopad', null, ['id'=>'datainiciopad','class' => 'form-control date']) }}
                                        </div>
                                    </div>

                                    <div class="col-md-9">
                                        <div class="form-group">
                                            {!! Form::label('numeropad','Número do PAD')  !!}
                                            {{ Form::text('numeropad', null, ['id'=>'numeropad', 'class' => 'form-control naoValidar']) }}
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            {!! Form::label('tipofato', 'Tipo do Fato')  !!} <span class="red">*</span>
                                            {{ Form::select('tipofato', \App\Model\Pad::$fato, null, ['id'=>'tipofato','class' => 'form-control' ]) }}
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            {!! Form::label('tipofalta', 'Classificação da Falta')  !!} <span class="red">*</span>
                                            {{ Form::select('tipofalta', \App\Model\Pad::$tipofalta, null, ['id'=>'tipofalta','class' => 'form-control' ]) }}
                                        </div>
                                    </div>


                                    <div class="col-md-12">
                                        <div class="form-group">
                                            {!! Form::label('descricaopad', 'Descrição do PAD')  !!} <span class="red">*</span>
                                            {{ Form::textarea('descricaopad', null, ['id'=>'descricaopad','class' => 'form-control', 'rows'=>'5']) }}
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


    <div class="modal fade" id="myModalVincular" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog modal-lg " role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">VINCULAR ADVOGADO A APENADO</h4>

                </div>
                {!! Form::open(['route'=>['advogados.vincular'], 'id'=>'formModalVincular' ]) !!}
                <div class="modal-body" id="modalbody">
                    Selecione o advogado para inclusão ao preso
                    <div class="widget-box widget-color-dark ">


                        <div class="widget-body">
                            <div class="widget-main no-padding">
                                <fieldset>
                                    <input name="apenado_id" id="apenado_id" type="hidden" value={{$apenado->id}}>

                                    <div class="col-md-9">
                                        <div class="form-group">
                                            {!! Form::label('advogado_id','Nome do (a) Advogado')  !!}
                                            {{ Form::select('advogado_id', [], null, ['id'=>'advogado_id', 'class' => 'form-control chosen-select']) }}
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            {!! Form::label('datacadastroadvogado', 'Data de Cadastro')  !!}
                                            {{ Form::text('datacadastroadvogado', null, ['id'=>'datacadastroadvogado','class' => 'form-control date naoValidar']) }}
                                        </div>
                                    </div>



                                </fieldset>
                            </div>
                        </div>
                    </div>


                </div>
                <div class="modal-footer">
                    <button class="btn btn-success" id="btnModalVincular" type="submit"> <i class="ace-icon fa fa-save"></i> SALVAR</button>
                    <span class="pull-left">
                                            <a href="#" class="btn btn-info  bigger" id="btnNovo" name="btnNovo" > <i class="ace-icon fa fa-plus"></i> INCLUIR NOVO ADVOGADO</a>
                                          </span>

                </div>
                {{ Form::close() }}


            </div>
        </div>


    </div>


@endsection

@section('scripts')

    {{ HTML::script('resources/assets/js/pad/script.js') }}

    {{ HTML::script('resources/assets/chosen/chosen.jquery.js') }}
    {{ HTML::script('resources/assets/chosen/chosen.js') }}

    {{ HTML::script('resources/assets/js/datepickerJS/bootstrap-datepicker.min.js') }}
    {{ HTML::script('resources/assets/js/datepickerJS/bootstrap-datepicker.pt-BR.min.js') }}

    {{ HTML::script('resources/assets/js/mask/maskedinput.min.js') }}
    {{ HTML::script('resources/assets/js/validacao/formatainput.js') }}

@stop