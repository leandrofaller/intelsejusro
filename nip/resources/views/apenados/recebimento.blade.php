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
              <a href="{!! route('apenados.index') !!}" class="btn btn-xs btn-light bigger"> <i class="ace-icon fa fa-arrow-left"></i> Voltar </a>
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

        <div class="col-md-12">

            <div class="alert alert-warning">
                <h2> <i class="ace-icon fa fa-arrow-circle-right"></i> RECEBIMENTO DE APENADO </h2>
                <small>Preencha todas as informações </small>
            </div>
            <div class="alert alert-danger">
                @if($apenado->unidade_id == 63) <h2>  PRESO EM TRÂNSITO </h2> @endif
            </div>

            <div class="widget-box widget-color-dark ">
                <div class="widget-header">
                    <h4 class="widget-title">DADOS PESSOAIS</h4>
                </div>

                <div class="widget-body">
                    <div class="widget-main no-padding">
                        <fieldset>

                                <div class="col-md-12">
                                    <div class="form-group">
                                        {!! Form::label('nomeapenadoc','Nome do Apenado')  !!}
                                        {!! Form::text('nomeapenadoc', $apenado->nomeapenado, ['class' => 'form-control', 'readonly']) !!}
                                    </div>
                                </div>


                                <div class="col-md-3">
                                    <div class="form-group">
                                        {!! Form::label('cpfc','Cpf do Apenado')  !!}
                                        {!! Form::text('cpfc', $apenado->cpf, ['class' => 'form-control cpf','id'=>'cpfc', 'readonly']) !!}
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        {!! Form::label('numprocesso','Processo / Execução')  !!}
                                        {!! Form::text('numprocesso', $apenado->numeroprocesso, ['class' => 'form-control','id'=>'numprocesso','readonly']) !!}
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        {!! Form::label('datanascimento','Nascimento')  !!}
                                        {!! Form::text('datanascimentoc', $apenado->datanascimento ? strftime('%d/%m/%Y',strtotime($apenado->datanascimento)) : null , ['class' => 'form-control', 'readonly']) !!}
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        {!! Form::label('unidadeorigem','Unidade de Origem')  !!}
                                        {!! Form::text('unidadeOrigem', \App\Model\Apenado::mostraUnidadeOrigem($apenado->idProcesso, $apenado->oficioentrada) , ['class' => 'form-control', 'readonly']) !!}
                                    </div>
                                </div>

                        </fieldset>
                    </div>
                </div>
            </div>
        </div>


        <div class="col-xs-12">
            <div class="widget-box widget-color-dark ">
                <div class="widget-header">
                    <h4 class="widget-title">INFORMAÇÕES NECESSÁRIAS PARA VALIDAR O RECEBIMENTO</h4>
                </div>

                <div class="widget-body">
                    <div class="widget-main no-padding">
                        {!! Form::open(['route'=>['apenados.recebimentoSalvar', $apenado->idMovimentacao ], 'id'=>'formulario' ]) !!}
                        <fieldset>
                            <input type="hidden" value="{{ $apenado->idApen }}" name="idApen">
                            <input type="hidden" name="idMovimentacao" value="{!! $apenado->idMovimentacao !!}" id="idMovimentacao">
                            <input type="hidden" name="transito" value="{!! $apenado->unidade_id == 63 ? 'Sim' : '' !!}" id="transito">

                            <div class="col-md-6">
                                <div class="form-group">
                                    {!! Form::label('regime', 'Regime da Pena')  !!}
                                    {{ Form::select('regime', App\Model\Apenado::$regimepena, $apenado->regime, ['id'=>'regime', 'class' => 'form-control']) }}
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    {!! Form::label('situacao','Situação')  !!}
                                    {{ Form::select('situacao', App\Model\Apenado::$situacao, $apenado->situacao, ['id'=>'situacao', 'class' => 'form-control']) }}
                                </div>
                            </div>


                            <div class="col-md-2">
                                <div class="form-group">
                                    {!! Form::label('monitorado','Apenado Monitorado')  !!}
                                    {!! Form::select('monitorado', \App\Model\Apenado::$monitorado, $apenado->monitorado, ['class' => 'form-control']) !!}
                                </div>
                            </div>



                            <div class="col-md-2">
                                <div class="form-group">
                                    {!! Form::label('presooriundo','Oriundo da Justiça?')  !!}
                                    {{ Form::select('presooriundo', App\Model\Apenado::$presooriundo, $apenado->presooriundo, ['class' => 'form-control']) }}
                                </div>
                            </div>

                            <div class="col-md-2">
                                <div class="form-group">
                                    {!! Form::label('dataentrada','Data de Entrada')  !!}
                                    {!! Form::text('dataentrada', strftime('%d/%m/%Y',strtotime($apenado->dataentrada)), ['class' => 'form-control date','id'=>'dataentrada']) !!}
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    {!! Form::label('oficioentrada','Ofício de Entrada')  !!}
                                    {!! Form::text('oficioentrada', $apenado->oficioentrada, ['class' => 'form-control','id'=>'oficioentrada']) !!}
                                </div>
                            </div>


                            <div class="col-md-3">
                                <div class="form-group">
                                   {!! Form::label('carceragem_id', 'Selecione a Carceragem')  !!}
                                   <select name="carceragem_id" id="carceragem_id" class="form-control">
                                        <option value=""></option>
                                           @foreach($carceragens as $carceragen)
                                              <option value="{{ $carceragen->id }}"> {{$carceragen->nomecarceragem}} </option>
                                           @endforeach
                                   </select>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                   {!! Form::label('cela_id','Selecione a Nova Cela')  !!}
                                      <select name="cela_id" id="cela_id" class="form-control"> </select>
                                </div>
                            </div>
                    </fieldset>
                        <div class="form-actions center">
                            <input  class="btn btn-success" type="submit" id="btnEnviar" value="Salvar" >
                        </div>
                    {!! Form::close() !!}
                        <!-- /.row -->
                    </div>
                    <!-- /.box-body -->
                </div>
            </div>
        </div>
    </div>

    <script src={{asset('js/jquery.js')}}></script>

@endsection

@section('scripts')

    {{ HTML::script('resources/assets/js/selectGeral.js') }}
    {{ HTML::script('resources/assets/js/validacao/validacao.js') }}
    {{--{{ HTML::script('chosen/chosen.jquery.js') }}--}}
    {{--{{ HTML::script('chosen/chosen.js') }}--}}

    {{--{{ HTML::script('js/datepickerJS/bootstrap-datepicker.min.js') }}--}}
    {{--{{ HTML::script('js/datepickerJS/bootstrap-datepicker.pt-BR.min.js') }}--}}

    {{--{{ HTML::script('js/mask/maskedinput.min.js') }}--}}
    {{--{{ HTML::script('js/validacao/formatainput.js') }}--}}

@stop