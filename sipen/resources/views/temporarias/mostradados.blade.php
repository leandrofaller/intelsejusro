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

        <div class="col-md-9">
            <div class="widget-box widget-color-blue2">
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
                                        {!! Form::label('alcunhaa','Alcunha')  !!}
                                        {!! Form::text('alcunhaa', $apenado->alcunha, ['class' => 'form-control','readonly']) !!}
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
                                    <img class="img-responsive" style="height: 225px;"  src="{!! asset($apenado->foto) !!}"/>
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
                    <h4 class="widget-title">LANÇAR TEMPORÁRIA</h4>
                </div>
                @if(count($temporarias) > 0)
                    <div class="widget-body">
                        <div class="widget-main no-padding">
                            <fieldset>
                                <div class="row container-fluid" >
                                    <div class="alert alert-danger"> JÁ POSSUI UMA SAÍDA TEMPORÁRIA PARA ESTE APENADO.</div>
                                </div>
                            </fieldset>
                        </div>
                    </div>
                @else
                {!! Form::open(['route'=>['temporarias.salvar'], 'id'=>'formulario' ]) !!}

                <div class="widget-body">
                    <div class="widget-main no-padding">
                        <fieldset>
                            <div class="row container-fluid" >
                                <div class="col-md-6">
                                    <div class="form-group">
                                        {!! Form::label('tipo', 'Tipo de Temporária')  !!}
                                        {{ Form::select('tipo', \App\Model\Temporaria::$tipo, 0, ['id'=>'tipo', 'class' => 'form-control']) }}
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        {!! Form::label('motivo','Motivo')  !!} <label class="red">*</label>
                                        <select name="motivo" id="motivo" class="form-control"> </select>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        {!! Form::label('documento','Documento')  !!}
                                        {{ Form::text('documento', null, ['id'=>'documento', 'class' => 'form-control']) }}
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        {!! Form::label('datasaida','Data da Saída') !!}
                                        {{ Form::text('datasaida', null, ['id'=>'documento', 'class' => 'form-control date']) }}
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <div class="form-group">
                                        {!! Form::label('horasaida','Hora da Saída') !!}
                                        {{ Form::text('horasaida', null, ['id'=>'horasaida', 'class' => 'form-control hora']) }}
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        {!! Form::label('escolta', 'Escolta?') !!}
                                        {{ Form::select('escolta', \App\Model\Temporaria::$escolta, 0, ['id'=>'escolta', 'class' => 'form-control']) }}
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="form-group">
                                        {!! Form::label('descricao','Descrição da Saída')  !!}
                                        {{ Form::textarea('descricao', null, ['id'=>'descricao', 'rows' => '3', 'class' => 'form-control']) }}
                                    </div>
                                </div>

                                <input name="apenado_id" id="apenado_id" type="hidden" value="{{$apenado->id}}">
                                <input name="movimentacao_id" id="movimentacao_id" type="hidden" value="{{$apenado->idMovimentacao}}">
                                <input name="processo_id" id="processo_id" type="hidden" value="{{$apenado->idProcesso}}">
                                <input name="unidade_id" id="unidade_id" type="hidden" value="{{$apenado->unidade_id}}">

                            </div>

                        </fieldset>
                    </div>
                </div>

                <div class="modal-footer">
                    <button class="btn btn-success" id="btnEnviar" type="submit"> SALVAR </button>
                </div>
                {{ Form::close() }}

            @endif
            </div>
        </div>



    </div>



@endsection

@section('scripts')

    {{ HTML::script('resources/assets/js/selectGeral.js') }}

    {{ HTML::script('resources/assets/chosen/chosen.jquery.js') }}
    {{ HTML::script('resources/assets/chosen/chosen.js') }}

    {{ HTML::script('resources/assets/js/datepickerJS/bootstrap-datepicker.min.js') }}
    {{ HTML::script('resources/assets/js/datepickerJS/bootstrap-datepicker.pt-BR.min.js') }}

    {{ HTML::script('resources/assets/js/mask/maskedinput.min.js') }}
    {{ HTML::script('resources/assets/js/validacao/formatainput.js') }}

    {{ HTML::script('resources/assets/js/validacao/validacao.js') }}

    {{ HTML::script('resources/assets/js/moment.js') }}

@stop

