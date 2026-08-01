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
              <a href="{!! route('apenados.index') !!}" class="btn btn-xs btn-light bigger"> <i
                          class="ace-icon fa fa-arrow-left"></i> Voltar </a>
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
    <!-- Main content -->

    {!!Form::open ( ['route'=>('apenados.salvar'),'id'=>'formulario', 'enctype' => 'multipart/form-data'] ) !!}

    <div class="row">
        <div class="col-md-12">
            <div class="widget-box widget-color-dark">
                <div class="widget-header">
                    <h4 class="widget-title">DADOS PESSOAIS</h4>
                </div>

                <div class="widget-body">
                    <div class="widget-main no-padding">
                        <fieldset>
                            <div class="col-md-8">
                                <div class="form-group">
                                    {!! Form::label('nomeapenado','Nome do Apenado')  !!} <label class="red">*</label>
                                    {!! Form::text('nomeapenado', null, ['class' => 'form-control','id'=>'nome']) !!}
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    {!! Form::label('foto','Buscar Foto')  !!}
                                    <input type="file" id="foto" name="foto" class="form-control naoValidar">
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    {!! Form::label('alcunha','Alcunha')  !!} <label class="red">*</label>
                                    {!! Form::text('alcunha', null, ['class' => 'form-control naoValidar','id'=>'alcunha', ]) !!}
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    {!! Form::label('rg','RG do Apenado') !!}
                                    {!! Form::text('rg', null, ['class' => 'form-control naoValidar','id'=>'rg']) !!}
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    {!! Form::label('cpf','Cpf do Apenado')  !!}
                                    {!! Form::text('cpf', null, ['class' => 'form-control cpf naoValidar','id'=>'cpf']) !!}
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    {!! Form::label('datanascimento','Data de Nascimento')  !!} <label
                                            class="red">*</label>
                                    {!! Form::text('datanascimento', null, ['class' => 'form-control date naoValidar']) !!}
                                </div>
                            </div>


                            <div class="col-md-3">
                                <div class="form-group">
                                    {!! Form::label('sexo', 'Sexo')  !!} <label class="red">*</label>
                                    <select name="sexo" id="sexo" class="form-control naoValidar">
                                        <option value="Masculino" selected >Masculino</option>
                                        <option value="Feminino">Feminino</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    {!! Form::label('etnia','Etnia')  !!} <label class="red">*</label>
                                    {{ Form::select('etnia', App\Model\Apenado::$etnia, null, ['class' => 'form-control naoValidar']) }}
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    {!! Form::label('escolaridade','Grau de Instrução')  !!} <label class="red">*</label>
                                    {{ Form::select('escolaridade', App\Model\Apenado::$escolaridade, null, ['class' => 'form-control naoValidar']) }}
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    {!! Form::label('naturalidade','Naturalidade')  !!}
                                    {!! Form::text('naturalidade', null, ['class' => 'form-control naoValidar','id'=>'naturalidade']) !!}
                                </div>
                            </div>


                            <div class="col-md-6">
                                <div class="form-group">
                                    {!! Form::label('nomemae','Nome da Mãe')  !!} <label class="red">*</label>
                                    {!! Form::text('nomemae', null, ['class' => 'form-control naoValidar','id'=>'nomemae']) !!}
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    {!! Form::label('nomepai','Nome do Pai')  !!} <label class="red">*</label>
                                    {!! Form::text('nomepai', null, ['class' => 'form-control naoValidar','id'=>'nomepai']) !!}
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
                    <h4 class="widget-title">ENDEREÇO</h4>
                </div>

                <div class="widget-body">
                    <div class="widget-main no-padding">
                        <fieldset>

                            <div class="col-md-3">
                                <div class="form-group">
                                    {!! Form::label('rua','Rua')  !!}
                                    {!! Form::text('rua', null, ['class' => 'form-control naoValidar','id'=>'rua']) !!}
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    {!! Form::label('numero','Número Casa') !!}
                                    {!! Form::text('numero', null, ['class' => 'form-control naoValidar','id'=>'numero']) !!}
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    {!! Form::label('bairro','Bairro') !!}
                                    {!! Form::text('bairro', null, ['class' => 'form-control naoValidar','id'=>'bairro']) !!}
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    {!! Form::label('estado','Estado') !!}
                                    {!! Form::select('estado', $estados, 0, ['class' => 'form-control naoValidar','id'=>'estado']) !!}
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    {!! Form::label('cidade','Cidade') !!}
                                    {!! Form::text('cidade', null, ['class' => 'form-control naoValidar','id'=>'cidade']) !!}
                                </div>
                            </div>
                            <!-- /.row -->
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
                    <h4 class="widget-title">INFORMAÇÃO PROCESSUAL (PRINCIPAL)</h4>
                </div>
                <div class="widget-body">
                    <div class="widget-main no-padding">

                        <fieldset>

                            <div class="col-md-4">
                                <div class="form-group">
                                    {!! Form::label('numeroprocesso','Processo - Execução Penal')  !!} <label class="red">*</label>
                                    {!! Form::text('numeroprocesso', null, ['class' => 'form-control naoValidar','id'=>'numeroprocesso']) !!}
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    {!! Form::label('vara','Vara')  !!} <label class="red">*</label>
                                    {!! Form::select('vara', \App\Model\Apenado::$varas, null, ['class' => 'form-control naoValidar','id'=>'vara']) !!}
                                </div>
                            </div>


                            <div class="col-md-4">
                                <div class="form-group">
                                    {!! Form::label('artigos','Tipificação')  !!} <label class="red">*</label>
                                    {!! Form::text('artigos', null, ['class' => 'form-control naoValidar','id'=>'artigos']) !!}
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    {!! Form::label('datacondenacao','Data Condenação')  !!}
                                    {!! Form::text('datacondenacao', null, ['class' => 'form-control date naoValidar','id'=>'datacondenacao ']) !!}
                                </div>
                            </div>

                            <div class="col-md-2">
                                <div class="form-group">
                                    {!! Form::label('tempodepena','Tempo Total da Pena') !!}
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
                                    {!! Form::label('databeneficio','Data do Benefício Semiaberto')  !!}
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
                            <div class="col-md-6">
                                <div class="form-group">
                                    {!! Form::label('unidade_id','Unidade Prisional')  !!} <label class="red">*</label>
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
                                    {!! Form::label('carceragem_id','Carceragem')  !!} <label class="red">*</label>
                                    <select name="carceragem_id" id="carceragem_id" class="form-control">
                                        <option value=""></option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    {!! Form::label('cela_id','Cela')  !!} <label class="red">*</label>
                                    <select name="cela_id" id="cela_id" class="form-control">
                                        <option value=""></option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    {!! Form::label('regime', 'Regime da Pena')  !!} <label class="red">*</label>
                                    {{ Form::select('regime', App\Model\Apenado::$regimepena, null, ['id'=>'regime', 'class' => 'form-control naoValidar']) }}
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    {!! Form::label('situacao','Situação')  !!} <label class="red">*</label>
                                    {{ Form::select('situacao', App\Model\Apenado::$situacao, null, ['id'=>'situacao', 'class' => 'form-control naoValidar']) }}
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    {!! Form::label('monitorado','Apenado Monitorado')  !!} <label class="red">*</label>
                                    {!! Form::select('monitorado', \App\Model\Apenado::$monitorado, null, ['class' => 'form-control naoValidar']) !!}
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    {!! Form::label('dataentrada','Data de Entrada')  !!} <label class="red">*</label>
                                    {!! Form::text('dataentrada', null, ['class' => 'form-control date naoValidar','id'=>'dataentrada']) !!}
                                </div>
                            </div>


                            <div class="col-md-8">
                                <div class="form-group">
                                    {!! Form::label('oficioentrada','Documento de Entrada')  !!} <label
                                            class="red">*</label>
                                    {!! Form::text('oficioentrada', null, ['class' => 'form-control naoValidar','id'=>'oficioentrada']) !!}
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
                                    {!! Form::label('presooriundo','Oriundo da Justiça?')  !!} <label
                                            class="red">*</label>
                                    {{ Form::select('presooriundo', App\Model\Apenado::$presooriundo, null, ['class' => 'form-control naoValidar']) }}
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




    {{--<script src={{asset('js/jquery.js')}}></script>--}}

@endsection

@section('scripts')
    {{ HTML::script('resources/assets/js/selectGeral.js') }}

    {{ HTML::script('resources/assets/js/datepickerJS/bootstrap-datepicker.min.js') }}
    {{ HTML::script('resources/assets/js/datepickerJS/bootstrap-datepicker.pt-BR.min.js') }}

    {{ HTML::script('resources/assets/js/mask/maskedinput.min.js') }}
    {{ HTML::script('resources/assets/js/validacao/formatainput.js') }}
    {{ HTML::script('resources/assets/js/validacao/validacao.js') }}

@stop