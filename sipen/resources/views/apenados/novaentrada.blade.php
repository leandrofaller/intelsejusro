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

    <div class="alert alert-danger">
        <h2> <i class="ace-icon fa fa-arrow-circle-right"></i> NOVA ENTRADA DE APENADO </h2>
        <small>Preencha todas as informações </small>
        </p>
    </div>



    {!! Form::open(['route'=>['apenados.novaentradaSalvar', $apenado->id], 'id'=>'formulario', 'enctype' => 'multipart/form-data'   ]) !!}

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
                                    {!! Form::label('idApen','Cód do Apenado')  !!}
                                    {!! Form::text('idApen', $apenado->id, ['class' => 'form-control','id'=>'idApen', 'readonly']) !!}
                                </div>
                            </div>

                            <div class="col-md-10">
                                <div class="form-group">
                                    {!! Form::label('nomeapenado','Nome do Apenado')  !!}
                                    {!! Form::text('nomeapenado', $apenado->nomeapenado, ['class' => 'form-control','id'=>'nomeapenado']) !!}
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    {!! Form::label('alcunha','Alcunha')  !!}
                                    {!! Form::text('alcunha', $apenado->alcunha, ['class' => 'form-control','id'=>'alcunha']) !!}
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
                                    {!! Form::label('datanascimento','Data de Nascimento')  !!}
                                    {!! Form::text('datanascimento', $apenado->datanascimento ? strftime('%d/%m/%Y',strtotime($apenado->datanascimento)) : null, ['class' => 'form-control date']) !!}
                                </div>
                            </div>


                            <div class="col-md-3">
                                <div class="form-group">
                                    {!! Form::label('sexo', 'Sexo')  !!}
                                    <select name="sexo" id="sexo" class="form-control">
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
                                    {!! Form::label('etnia','Etnia')  !!}
                                    {{ Form::select('etnia', App\Model\Apenado::$etnia, $apenado->etnia, ['class' => 'form-control']) }}
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    {!! Form::label('escolaridade','Escolaridade')  !!}
                                    {{ Form::select('escolaridade', App\Model\Apenado::$escolaridade, $apenado->escolaridade, ['class' => 'form-control']) }}
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    {!! Form::label('naturalidade','Naturalidade')  !!}
                                    {!! Form::text('naturalidade', $apenado->naturalidade, ['class' => 'form-control','id'=>'naturalidade']) !!}
                                </div>
                            </div>




                            <div class="col-md-6">
                                <div class="form-group">
                                    {!! Form::label('nomemae','Nome da Mãe')  !!}
                                    {!! Form::text('nomemae', $apenado->nomemae, ['class' => 'form-control','id'=>'nomemae']) !!}
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    {!! Form::label('nomepai','Nome do Pai')  !!}
                                    {!! Form::text('nomepai', $apenado->nomepai, ['class' => 'form-control','id'=>'nomepai']) !!}
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
                        @if($apenado->foto != 'N')
                            <div>
                                <img class="img-responsive editable-empty" style="height: 280px;" src="{!! asset($apenado->foto) !!}"/>
                            </div>
                        @endif

                        <div class="form-group">
                            {!! Form::label('foto','Buscar Foto')  !!}
                            <input type="file" id="foto" name="foto" class="naoValidar"  >
                        </div>
                    </div>
                </fieldset>


            </div>

        </div>


    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="widget-box widget-color-dark">
                <div class="widget-header">
                    <h4 class="widget-title">INFORMAÇÃO PROCESSUAL</h4>
                </div>
                <div class="widget-body">
                    <div class="widget-main no-padding">

                        <fieldset>
                            <input type="hidden" name="idProcesso" value="" id="idProcesso">
                            <div class="col-md-4">
                                <div class="form-group">
                                    {!! Form::label('numeroprocesso','Processo - Execução Penal')  !!}
                                    {!! Form::text('numeroprocesso', null, ['class' => 'form-control','id'=>'numeroprocesso']) !!}
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    {!! Form::label('vara','Vara')  !!} <label class="red">*</label>
                                    {!! Form::select('vara', \App\Model\Apenado::$varas, null, ['class' => 'form-control','id'=>'vara']) !!}
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    {!! Form::label('artigos','Artigos')  !!} <label class="red">*</label>  <small class="blue" > Somente o Número, separados por virgula. Ex 121,33</small>
                                    {!! Form::text('artigos', null, ['class' => 'form-control','id'=>'artigos']) !!}
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    {!! Form::label('datacondenacao','Data Condenação')  !!}
                                    {!! Form::text('datacondenacao', null, ['class' => 'form-control date naoValidar','id'=>'datacondenacao ']) !!}
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    {!! Form::label('tempodepena','Tempo da Pena')  !!} <small>(Anos)</small>
                                    {!! Form::text('tempodepena', null, ['class' => 'form-control naoValidar','id'=>'tempodepena']) !!}
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    {!! Form::label('dataprisao','Data da Prisão')  !!}
                                    {!! Form::text('dataprisao', null, ['class' => 'form-control date naoValidar','id'=>'dataprisao']) !!}
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    {!! Form::label('databeneficio','Data do Benefício')  !!}
                                    {!! Form::text('databeneficio', null, ['class' => 'form-control date naoValidar','id'=>'databeneficio']) !!}
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
                            <input type="hidden" name="idMovimentacao" value="" id="idMovimentacao">
                            <div class="col-md-6">
                                <div class="form-group">
                                    {!! Form::label('regime', 'Regime da Pena')  !!}
                                    {{ Form::select('regime', App\Model\Apenado::$regimepena, null, ['class' => 'form-control']) }}
                                </div>
                            </div>

                            <div class="col-md-2">
                                <div class="form-group">
                                    {!! Form::label('situacao','Situação')  !!}
                                    {{ Form::select('situacao', App\Model\Apenado::$situacao, null, ['class' => 'form-control']) }}
                                </div>
                            </div>


                            <div class="col-md-2">
                                <div class="form-group">
                                    {!! Form::label('monitorado','Apenado Monitorado')  !!}
                                    {!! Form::select('monitorado', \App\Model\Apenado::$monitorado, null, ['class' => 'form-control']) !!}
                                </div>
                            </div>

                            <div class="col-md-2">
                                <div class="form-group">
                                    {!! Form::label('dataentrada','Data de Entrada')  !!}
                                    {!! Form::text('dataentrada', null, ['class' => 'form-control date','id'=>'dataentrada']) !!}
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="form-group">
                                    {!! Form::label('oficioentrada','Ofício de Entrada')  !!}
                                    {!! Form::text('oficioentrada', null, ['class' => 'form-control','id'=>'oficioentrada']) !!}
                                </div>
                            </div>


                            <div class="col-md-2">
                                <div class="form-group">
                                    {!! Form::label('classificacao_id','Classificação')  !!}
                                    {{ Form::select('classificacao_id', $classificacao, null, ['class' => 'form-control naoValidar']) }}
                                </div>
                            </div>

                            <div class="col-md-2">
                                <div class="form-group">
                                    {!! Form::label('presooriundo','Oriundo da Justiça?')  !!}
                                    {{ Form::select('presooriundo', App\Model\Apenado::$presooriundo, null, ['class' => 'form-control']) }}
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    {!! Form::label('unidade_id','Unidade Prisional')  !!}
                                    <select name="unidade_id" id="unidade_id" class="form-control">
                                        <!-- se perfil for Admin- mostra todas as unidades senão mostra somente a unidade do servidor -->
                                        <option value=""></option>
                                        @if(Auth::user()->perfil == 'Admin')
                                            @foreach($unidades as $unidade)
                                                <option value="{{ $unidade->id }}"> {{$unidade->nomeunidade}} </option>
                                            @endforeach
                                        @else
                                            <option value="{{ Auth::user()->unidade_id }}"> {{ Auth::user()->unidades->nomeunidade }} </option>
                                        @endif
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


    <script src={{asset('resources/assets/js/jquery.js')}}></script>




@endsection


@section('scripts')

    {{ HTML::script('resources/assets/js/selectGeral.js') }}

    {{ HTML::script('resources/assets/js/datepickerJS/bootstrap-datepicker.min.js') }}
    {{ HTML::script('resources/assets/js/datepickerJS/bootstrap-datepicker.pt-BR.min.js') }}

    {{ HTML::script('resources/assets/js/mask/maskedinput.min.js') }}
    {{ HTML::script('resources/assets/js/validacao/formatainput.js') }}
    {{ HTML::script('resources/assets/js/validacao/validacao.js') }}

@stop



