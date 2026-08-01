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
              <a href="{!! route('apenados.selecionarOpcao', $apenado->id) !!}" class="btn btn-xs btn-light bigger"> <i class="ace-icon fa fa-arrow-left"></i> Voltar </a>
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
        <div class="col-xs-12">
            <div class="widget-box widget-color-red3 ">
                <div class="widget-header">
                    <h4 class="widget-title">DADOS PESSOAIS</h4>
                </div>

                <div class="widget-body">
                    <div class="widget-main no-padding">
                        <fieldset>

                            <div class="col-md-2">
                                <div class="form-group">
                                    {!! Form::label('capen','Código Apenado')  !!}
                                    {!! Form::text('capen', $apenado->id, ['class' => 'form-control','id'=>'nomeapenado', 'readonly']) !!}
                                </div>
                            </div>
                            <div class="col-md-10">
                                <div class="form-group">
                                    {!! Form::label('nomeapenado','Nome do Apenado')  !!}
                                    {!! Form::text('nomeapenadoc', $apenado->nomeapenado, ['class' => 'form-control','id'=>'nomeapenado', 'readonly']) !!}
                                </div>
                            </div>

                            <div class="col-md-2">
                                <div class="form-group">
                                    {!! Form::label('cpf','Cpf do Apenado')  !!}
                                    {!! Form::text('cpfc', $apenado->cpf, ['class' => 'form-control cpf','id'=>'cpf','readonly']) !!}
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    {!! Form::label('numprocesso','Processo / Execução')  !!}
                                    {!! Form::text('numprocesso', $apenado->numeroprocesso, ['class' => 'form-control','id'=>'nummmm','readonly']) !!}
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
                                    {!! Form::label('unidade','Unidade Prisional')  !!}
                                    {!! Form::text('unidade', $apenado->nomeunidade , ['class' => 'form-control', 'readonly']) !!}
                                </div>
                            </div>

                            <div class="col-md-2">
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


        <div class="col-xs-12">
            <div class="widget-box widget-color-red3 ">
                <div class="widget-header">
                    <h4 class="widget-title">REGISTRAR SAÍDA / TRANSFERÊNCIA</h4>
                </div>

                <div class="widget-body">
                    <div class="widget-main no-padding">
                        {!! Form::open(['route'=>['apenados.registrarSaidaSalvar', $apenado->idMovimentacao], 'id'=>'formulario' ]) !!}

                        @if( \App\Model\MedidaDisciplinar::verificaMedidaDisciplinar($apenado->id) == 'md')
                            <div class="well text-center">
                                <h3 class="text-danger"> <i class="fa fa-warning"></i> Atenção! Este apenado encontra-se em Medida Disciplinar. <br> Efetue a Baixa para depois executar esta ação!</h3>
                            </div>
                        @elseif( \App\Model\Temporaria::verificaTemporaria($apenado->id) == 't')
                            <div class="well text-center">
                                <h3 class="text-danger"> <i class="fa fa-warning"></i> Atenção! Este apenado encontra-se em Saída Temporária. <br> Efetue a Baixa para depois executar esta ação!</h3>
                            </div>
                        @else
                        <fieldset>
                            <input type="hidden" value="{{ $apenado->id }}" name="idApen">
                            <input type="hidden" value="{{ $apenado->idProcesso }}" name="idProc">
                            <input type="hidden" value="{{ $apenado->idMovimentacao }}" name="idMov">

                            <div class="col-md-4">
                                <div class="form-group">
                                    {!! Form::label('motivosaida','Motivo da Saída')  !!}
                                    {{ Form::select('motivosaida', App\Model\Apenado::$motivosaida, null, ['class' => 'form-control', 'id' => 'motivosaida']) }}                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    {!! Form::label('documentosaida','Ofício / Documento que Originou a Saída / Descrição')  !!}
                                    {!! Form::text('documentosaida', null, ['class' => 'form-control ']) !!}
                                </div>
                            </div>

                            <div class="col-md-2">
                                <div class="form-group">
                                    {!! Form::label('datasaida','Data de Saída')  !!}
                                    {!! Form::text('datasaida', null, ['class' => 'form-control date']) !!}
                                </div>
                            </div>
                            <!-- ********************************************************** -->
                            <div id="ufRecambiamento" hidden>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        {!! Form::label('unidadeRecamb_id','Estado de Destino')  !!}
                                        <select name="unidadeRecamb_id" id="unidadeRecamb_id" class="form-control chosen-select">
                                            <option value=""></option>
                                            @foreach($unidadesRecambiamentos as $unidader)
                                                <option value="{{ $unidader->id }}"> {{$unidader->nomeunidade}} </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <!-- ********************************************************** -->
                            <!-- ********************************************************** -->
                            <div id="unidadeDestino" hidden>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        {!! Form::label('unidade_id','Unidade Prisional')  !!}
                                        <select name="unidade_id" id="unidade_id" class="form-control chosen-select">
                                            <option value=""></option>
                                            @foreach($unidades as $unidade)
                                                <option value="{{ $unidade->id }}"> {{$unidade->nomeunidade}} </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <!-- ********************************************************** -->
                            <!-- ********************************************************** -->
                            <div id="unidadeObservacao" hidden>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        {!! Form::label('observacao','Descreva o Motivo / Observação')  !!}
                                        {!! Form::text('observacao', null, ['class' => 'form-control']) !!}
                                    </div>
                                </div>
                            </div>
                            <!-- ********************************************************** -->
                        </fieldset>
                        <div class="form-actions center">
                            <input  class="btn btn-success" type="submit" id="btnEnviar" value="Salvar" >
                        </div>

                    @endif

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

    {{ HTML::script('resources/assets/js/apenados/saida.js') }}

    {{ HTML::script('resources/assets/js/validacao/validacao.js') }}
    {{ HTML::script('resources/assets/chosen/chosen.jquery.js') }}
    {{ HTML::script('resources/assets/chosen/chosen.js') }}

    {{ HTML::script('resources/assets/js/datepickerJS/bootstrap-datepicker.min.js') }}
    {{ HTML::script('resources/assets/js/datepickerJS/bootstrap-datepicker.pt-BR.min.js') }}

    {{ HTML::script('resources/assets/js/mask/maskedinput.min.js') }}
    {{ HTML::script('resources/assets/js/validacao/formatainput.js') }}

@stop




