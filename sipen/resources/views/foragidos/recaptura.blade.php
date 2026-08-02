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
              <a href="{!! route('foragidos.index') !!}" class="btn btn-xs btn-light bigger"> <i class="ace-icon fa fa-arrow-left"></i> Voltar </a>
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


        <div class="col-md-3">
            <div class="widget-box widget-color-dark">
                <div class="widget-header">
                    <h4 class="widget-title">FOTO DO APENADO</h4>
                </div>
                <fieldset>
                    <div class="col-md-12">
                            <div>
                                <img class="img-responsive editable-empty" style="height: 280px;" src="{!! asset($apenado->foto) !!}"/>
                            </div>
                    </div>
                </fieldset>
            </div>
        </div>

        <div class="col-md-9">

            <div class="alert alert-dismissable">
                <h2> <i class="ace-icon fa fa-lock"></i> RECAPTURA DE APENADO </h2>
                <small>Preencha todas as informações </small>
            </div>
            <div class="widget-box widget-color-dark ">
                <div class="widget-header">
                    <h4 class="widget-title">DADOS PESSOAIS</h4>
                </div>

                <div class="widget-body">
                    <div class="widget-main no-padding">
                        <fieldset>

                                <div class="col-md-9">
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
                                <div class="col-md-2">
                                    <div class="form-group">
                                        {!! Form::label('datanascimento','Nascimento')  !!}
                                        {!! Form::text('datanascimentoc', strftime('%d/%m/%Y',strtotime($apenado->datanascimento)) , ['class' => 'form-control', 'readonly']) !!}
                                    </div>
                                </div>
                                <div class="col-md-5">
                                    <div class="form-group">
                                        {!! Form::label('unid','Nome da Unidade da Fuga')  !!}
                                        {!! Form::text('unid', $apenado->nomeunidade, ['class' => 'form-control','id'=>'unid','readonly']) !!}
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        {!! Form::label('cela','Cela')  !!}
                                        {!! Form::text('celac', $apenado->nomecela , ['class' => 'form-control', 'readonly']) !!}
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        {!! Form::label('numprocesso','Processo / Execução')  !!}
                                        {!! Form::text('numprocesso', $apenado->numeroprocesso, ['class' => 'form-control','id'=>'numprocessoX','readonly']) !!}
                                    </div>
                                </div>


                        </fieldset>
                    </div>
                </div>
            </div>
        </div>


        <div class="col-xs-12">
            <div class="widget-box widget-color-dark ">


                <div class="widget-body">
                    <div class="widget-main no-padding">
                        {!! Form::open(['route'=>['foragidos.recapturaSalvar', $apenado->idApen ], 'id'=>'formulario' ]) !!}

                        <fieldset>
                            <input type="hidden" name="unidade_preso" id="unidade_preso" value="{{ $apenado->unidade_id }}">
                            <input type="hidden" name="idFuga" value="{{ $apenado->idFuga }}">
                            <input type="hidden" name="idMovimentacao" value="{{ $apenado->idMovimentacao }}">
                            <input type="hidden" name="idProcesso" value="{{ $apenado->idProcesso }}">


                                <div class="col-md-6">
                                    <div class="form-group">
                                        {!! Form::label('unidade_id','Unidade Prisional')  !!}
                                        <select name="unidade_id" id="unidade_id" class="form-control">
                                            <!-- se perfil for Admin- mostra todas as unidades senão mostra somente a unidade do servidor -->
                                            <option value=""></option>
                                            @foreach($unidades as $unidade)
                                                <option value="{{ $unidade->id }}"> {{$unidade->nomeunidade}} </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        {!! Form::label('carceragem_id','Carceragem')  !!}
                                        <select name="carceragem_id" id="carceragem_id" class="form-control">
                                            <option value="">  </option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        {!! Form::label('cela_id','Cela')  !!}
                                        <select name="cela_id" id="cela_id" class="form-control">
                                            <option value=""></option>
                                        </select>
                                    </div>
                                </div>



                            <div class="col-md-2">
                                <div class="form-group">
                                    {!! Form::label('dataentrada','Data de Recaptura / Entrada')  !!}
                                    {!! Form::text('dataentrada', null, ['class' => 'form-control date','id'=>'dataentrada']) !!}
                                </div>
                            </div>
                            <div class="col-md-10">
                                <div class="form-group">
                                    {!! Form::label('oficioentrada','Documento de Recebimento')  !!}
                                    {!! Form::text('oficioentrada', null, ['class' => 'form-control','id'=>'oficioentrada']) !!}
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    {!! Form::label('descricaorecaptura','Informações Adicionais sobre a Recaptura / Entrada na Unidade')  !!}
                                    {{ Form::textarea('descricaorecaptura', null, ['id'=>'descricaorecaptura', 'maxlength'=>'240', 'rows'=>'3', 'class' => 'form-control']) }}
                                </div>
                                <small>Máximo 240 caracteres</small>
                            </div>

                            <!-- ********************************************************** -->

                            {{--<div id="novaUnidadeEntrada" hidden>--}}

                                <hr>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                {!! Form::label('regime', 'Regime da Pena')  !!}
                                                {{ Form::select('regime', App\Model\Apenado::$regimepena, null, ['class' => 'form-control']) }}
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                {!! Form::label('monitorado','Apenado Monitorado')  !!}
                                                {!! Form::select('monitorado', \App\Model\Apenado::$monitorado, null, ['class' => 'form-control']) !!}
                                            </div>
                                        </div>

                                        <div class="col-md-3">
                                            <div class="form-group">
                                                {!! Form::label('presooriundo','Oriundo da Justiça?')  !!}
                                                {{ Form::select('presooriundo', App\Model\Apenado::$presooriundo, null, ['class' => 'form-control']) }}
                                            </div>
                                        </div>

                                        <div class="col-md-2">
                                            <div class="form-group">
                                                {!! Form::label('situacao','Situação')  !!}
                                                {{ Form::select('situacao', App\Model\Apenado::$situacao, null, ['class' => 'form-control']) }}
                                            </div>
                                        </div>

                            {{--</div>--}}


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





    <script src={{asset('resources/assets/js/jquery.js')}}></script>

@endsection

@section('scripts')

    {{ HTML::script('resources/assets/js/selectGeral.js') }}
    {{ HTML::script('resources/assets/js/apenados/recaptura.js') }}

    {{--{{ HTML::script('js/scripts_extras.js') }}--}}

    {{ HTML::script('resources/assets/js/validacao/validacao.js') }}

    {{ HTML::script('resources/assets/js/datepickerJS/bootstrap-datepicker.min.js') }}
    {{ HTML::script('resources/assets/js/datepickerJS/bootstrap-datepicker.pt-BR.min.js') }}

    {{ HTML::script('resources/assets/js/mask/maskedinput.min.js') }}
    {{ HTML::script('resources/assets/js/validacao/formatainput.js') }}

@stop