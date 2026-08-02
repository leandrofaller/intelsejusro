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
              <a href="{!! route('apenados.selecionarOpcao', $apenado->idApen) !!}" class="btn btn-xs btn-light bigger"> <i class="ace-icon fa fa-arrow-left"></i> Voltar </a>
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






    {!! Form::open(['route'=>['apenados.update', $apenado->idApen], 'id'=>'formulario', 'method'=>'put', 'enctype' => 'multipart/form-data'   ]) !!}

    <div class="row">
        <div class="col-md-8">
            <div class="widget-box widget-color-dark">
                <div class="widget-header">
                    <h4 class="widget-title">DADOS PESSOAIS</h4>
                </div>

                <div class="widget-body">
                    <div class="widget-main no-padding">
                        <fieldset>
                            <div class="col-md-2">
                                <div class="form-group">
                                    {!! Form::label('idApen','Código')  !!}
                                    {!! Form::text('idApen', $apenado->idApen, ['class' => 'form-control','id'=>'idApen', 'readonly']) !!}
                                </div>
                            </div>
                            <div class="col-md-10">
                                <div class="form-group">
                                    {!! Form::label('nomeapenado','Nome do Apenado')  !!} <label class="red">*</label>
                                    {!! Form::text('nomeapenado', $apenado->nomeapenado, ['class' => 'form-control','id'=>'nomeapenado']) !!}
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    {!! Form::label('rg','RG do Apenado')  !!}
                                    {!! Form::text('rg', $apenado->rg, ['class' => 'form-control naoValidar','id'=>'rg']) !!}
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    {!! Form::label('cpf','Cpf do Apenado')  !!}
                                    {!! Form::text('cpf', $apenado->cpf, ['class' => 'form-control cpf naoValidar','id'=>'cpf']) !!}
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    {!! Form::label('datanascimento','Data de Nascimento')  !!} <label class="red">*</label>
                                    {!! Form::text('datanascimento', $apenado->datanascimento ? dataFormat($apenado->datanascimento) : null, ['class' => 'form-control date naoValidar']) !!}
                                </div>
                            </div>


                            <div class="col-md-3">
                                <div class="form-group">
                                    {!! Form::label('sexo', 'Sexo')  !!} <label class="red">*</label>
                                    <select name="sexo" id="sexo" class="form-control naoValidar">
                                        @if($apenado->sexo == "Masculino")
                                            <option value="Masculino" selected >Masculino</option>
                                            <option value="Feminino">Feminino</option>
                                        @else
                                            <option value="Masculino">Masculino</option>
                                            <option value="Feminino" selected >Feminino</option>
                                        @endif
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    {!! Form::label('etnia','Etnia')  !!} <label class="red">*</label>
                                    {{ Form::select('etnia', App\Model\Apenado::$etnia, $apenado->etnia, ['class' => 'form-control naoValidar']) }}
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    {!! Form::label('escolaridade','Grau de Instrução')  !!} <label class="red">*</label>
                                    {{ Form::select('escolaridade', App\Model\Apenado::$escolaridade, $apenado->escolaridade, ['class' => 'form-control naoValidar']) }}
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    {!! Form::label('naturalidade','Naturalidade')  !!}
                                    {!! Form::text('naturalidade', $apenado->naturalidade, ['class' => 'form-control naoValidar','id'=>'naturalidade']) !!}
                                </div>
                            </div>




                            <div class="col-md-6">
                                <div class="form-group">
                                    {!! Form::label('nomemae','Nome da Mãe')  !!} <label class="red">*</label>
                                    {!! Form::text('nomemae', $apenado->nomemae, ['class' => 'form-control naoValidar','id'=>'nomemae']) !!}
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    {!! Form::label('nomepai','Nome do Pai')  !!} <label class="red">*</label>
                                    {!! Form::text('nomepai', $apenado->nomepai, ['class' => 'form-control naoValidar','id'=>'nomepai']) !!}
                                </div>
                            </div>

                            <!-- /.row -->
                        </fieldset>

                    </div>
                </div>
            </div>

        </div>

        <div class="col-md-4">
            <div class="widget-box widget-color-dark">
                <div class="widget-header">
                    <h4 class="widget-title">FOTO DO APENADO</h4>
                </div>
                        <fieldset>
                            <div class="col-md-12">
                                    <div>
                                        <img class="img-responsive editable-empty" style="height: 270px;" src="{!! asset('public/'.\App\Model\Apenado::mostraFotoPrincipal($apenado->idApen)) !!}"/>
                                    </div>
                                {{--<div class="form-group">--}}
                                    {{--{!! Form::label('foto','Buscar Foto')  !!}--}}
                                    {{--<input type="file" id="foto" name="foto" class="naoValidar"  >--}}
                                {{--</div>--}}
                            </div>
                        </fieldset>
            </div>
        </div>








    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="widget-box widget-color-dark">
                <div class="widget-header">
                    <h4 class="widget-title">INFORMAÇÃO PROCESSUAL (PRINCIPAL)</h4>
                </div>
                <div class="widget-body">
                    <div class="widget-main no-padding">

                        <fieldset>
                            <input type="hidden" name="idProcesso" value="{!! $apenado->idProcesso !!}" id="idProcesso">
                            <div class="col-md-4">
                                <div class="form-group">
                                    {!! Form::label('numeroprocesso','Processo - Execução Penal')  !!} <label class="red">*</label>
                                    {!! Form::text('numeroprocesso', $apenado->numeroprocesso, ['class' => 'form-control naoValidar','id'=>'numeroprocesso']) !!}
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    {!! Form::label('vara','Vara')  !!} <label class="red">*</label>
                                    {!! Form::select('vara', \App\Model\Apenado::$varas, $apenado->vara, ['class' => 'form-control naoValidar','id'=>'vara']) !!}
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    {!! Form::label('artigos','Tipificação')  !!} <label class="red">*</label>
                                    {!! Form::text('artigos', $apenado->artigos, ['class' => 'form-control naoValidar','id'=>'artigos']) !!}
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    {!! Form::label('tempodepena','Tempo Total da Pena ')  !!}
                                    {!! Form::text('tempodepena',  $apenado->tempodepena, ['class' => 'form-control naoValidar','id'=>'tempodepena']) !!}
                                </div>
                            </div>


                            <div class="col-md-2">
                                <div class="form-group">
                                    {!! Form::label('datacondenacao','Data Condenação')  !!}
                                    {!! Form::text('datacondenacao', $apenado->datacondenacao == NULL ? '' : strftime('%d/%m/%Y',strtotime($apenado->datacondenacao)), ['class' => 'form-control date naoValidar','id'=>'datacondenacao ']) !!}
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    {!! Form::label('dataprisao','Data da Prisão')  !!}
                                    {!! Form::text('dataprisao', $apenado->dataprisao == NULL ? '' : strftime('%d/%m/%Y',strtotime($apenado->dataprisao)), ['class' => 'form-control date naoValidar','id'=>'dataprisao']) !!}
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    {!! Form::label('databeneficio','Data do Benefício Semiaberto')  !!}
                                    {!! Form::text('databeneficio', $apenado->databeneficio == NULL ? '' : strftime('%d/%m/%Y',strtotime($apenado->databeneficio)), ['class' => 'form-control date naoValidar   ','id'=>'databeneficio']) !!}
                                </div>
                            </div>

                        </fieldset>
                    </div>
                </div>
            </div>
        </div>


        <div class="col-md-12">
            <div class="widget-box widget-color-dark">
                <div class="widget-header">
                    <h4 class="widget-title">INFORMAÇÃO PRISIONAL</h4>
                </div>
                <div class="widget-body">
                    <div class="widget-main no-padding">

                        <fieldset>
                            <input type="hidden" name="idMovimentacao" value="{!! $apenado->idMovimentacao !!}" id="idMovimentacao">
                            <div class="col-md-6">
                                <div class="form-group">
                                    {!! Form::label('regime', 'Regime da Pena')  !!} <label class="red">*</label>
                                    {{ Form::select('regime', App\Model\Apenado::$regimepena, $apenado->regime, ['id'=>'regime', 'class' => 'form-control naoValidar']) }}
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    {!! Form::label('situacao','Situação')  !!} <label class="red">*</label>
                                    {{ Form::select('situacao', App\Model\Apenado::$situacao, $apenado->situacao, ['id'=>'situacao','class' => 'form-control naoValidar']) }}
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    {!! Form::label('monitorado','Apenado Monitorado')  !!} <label class="red">*</label>
                                    {!! Form::select('monitorado', \App\Model\Apenado::$monitorado, $apenado->monitorado, ['class' => 'form-control naoValidar']) !!}
                                </div>
                            </div>


                            <div class="col-md-6">
                                <div class="form-group">
                                    {!! Form::label('oficioentrada','Documento de Entrada')  !!} <label class="red">*</label>
                                    {!! Form::text('oficioentrada', $apenado->oficioentrada, ['class' => 'form-control naoValidar','id'=>'oficioentrada']) !!}
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    {!! Form::label('presooriundo','Oriundo da Justiça?')  !!} <label class="red">*</label>
                                    {{ Form::select('presooriundo', App\Model\Apenado::$presooriundo, $apenado->presooriundo, ['class' => 'form-control naoValidar']) }}
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    {!! Form::label('dataentrada','Data de Entrada')  !!} <label class="red">*</label>
                                    {!! Form::text('dataentrada', $apenado->dataentrada ? dataFormat($apenado->dataentrada) : null , ['class' => 'form-control date naoValidar','id'=>'dataentrada']) !!}
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    {!! Form::label('classificacao_id','Classificação')  !!}
                                    {{ Form::select('classificacao_id', $classificacao, $apenado->classificacao_id, ['class' => 'form-control naoValidar']) }}
                                </div>
                            </div>









                        </fieldset>
                    </div>
                </div>
            </div>
        </div>
    </div>



    <div class="widget-box widget-color-dark">


        <div class="form-actions center">
            <button type="submit" class="btn btn-sm btn-success" id="btnEnviar">
                <i class="ace-icon fa fa-save icon-on-right bigger-110"></i>
                Salvar
            </button>
        </div>


    </div>


    {!! Form::close() !!}





@endsection


@section('scripts')

    {{ HTML::script('resources/assets/js/selectGeral.js') }}

    {{ HTML::script('resources/assets/js/datepickerJS/bootstrap-datepicker.min.js') }}
    {{ HTML::script('resources/assets/js/datepickerJS/bootstrap-datepicker.pt-BR.min.js') }}

    {{ HTML::script('resources/assets/js/mask/maskedinput.min.js') }}
    {{ HTML::script('resources/assets/js/validacao/formatainput.js') }}

    {{ HTML::script('resources/assets/js/validacao/validacao.js') }}


    {{ HTML::script('resources/assets/js/integrantes/script.js') }}
    {{ HTML::script('resources/assets/js/validacao/confirme.js') }}

@stop



