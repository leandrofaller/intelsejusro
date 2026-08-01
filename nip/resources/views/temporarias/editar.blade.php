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
              <a href="{!! route('listagem.temporarias', $temporaria->tipo) !!}" class="btn btn-xs btn-light bigger"> <i class="ace-icon fa fa-arrow-left"></i> Voltar </a>
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
            <div class="widget-box widget-color-blue2">
                <div class="widget-header">
                    <h4 class="widget-title">FOTO DO APENADO</h4>
                </div>

                <div class="widget-body">
                    <div class="widget-main no-padding">
                        <fieldset>
                            <div>
                                 <img class="img-responsive" style="height: 152px;"  src="{!! asset($apenado->foto) !!}"/>
                            </div>
                        </fieldset>
                    </div>
                </div>
            </div>
        </div>



        <div class="col-md-9">
            <div class="widget-box widget-color-blue2">
                <div class="widget-header">
                    <h4 class="widget-title">INFORMAÇÃO DA TEMPORÁRIA</h4>
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
                                    {!! Form::label('tipo', 'Tipo de Temporária')  !!}
                                    {!! Form::text('tipo', TipoTemporarias($temporaria->tipo) , ['class' => 'form-control', 'readonly']) !!}
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    {!! Form::label('motivo','Motivo')  !!} <label class="red">*</label>
                                    {!! Form::text('motivo', MotivoTemporarias($temporaria->motivo) , ['class' => 'form-control', 'readonly']) !!}
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    {!! Form::label('documento','Documento')  !!}
                                    {{ Form::text('documento', $temporaria->documento, ['id'=>'documento', 'class' => 'form-control', 'readonly']) }}
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    {!! Form::label('datasaida','Data da Saída') !!}
                                    {{ Form::text('datasaida', dataFormat($temporaria->datasaida), ['id'=>'datasaida', 'class' => 'form-control', 'readonly']) }}
                                </div>
                            </div>

                            <div class="col-md-2">
                                <div class="form-group">
                                    {!! Form::label('horasaida','Hora da Saída') !!}
                                    {{ Form::text('horasaida', $temporaria->horasaida, ['id'=>'horasaida', 'class' => 'form-control hora', 'readonly']) }}
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    {!! Form::label('escolta', 'Escolta?') !!}
                                    {{ Form::text('escolta', $temporaria->escolta, ['id'=>'escolta', 'class' => 'form-control', 'readonly']) }}
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    {!! Form::label('descricao','Descrição da Saída')  !!}
                                    {{ Form::textarea('descricao', $temporaria->descricao, ['id'=>'descricao', 'rows' => '3', 'class' => 'form-control', 'readonly']) }}
                                </div>
                            </div>

                        </fieldset>
                    </div>
                </div>
            </div>
        </div>


        <div class="col-md-12">
            <div class="widget-box widget-color-red">
                <div class="widget-header">
                    <h4 class="widget-title">INFORMAÇÃO DA BAIXA</h4>
                </div>
                <div class="widget-body">
                    <div class="widget-main no-padding">

                        {!! Form::open(['route'=>['temporarias.update', $temporaria->id], 'id'=>'formulario', 'method'=>'post' ]) !!}
                        <fieldset>

                            <div class="col-md-3">
                                <div class="form-group">
                                    {!! Form::label('dataretorno','Data da Retorno') !!}
                                    {{ Form::text('dataretorno', null, ['id'=>'dataretorno', 'class' => 'form-control date']) }}
                                </div>
                            </div>

                            <div class="col-md-2">
                                <div class="form-group">
                                    {!! Form::label('horaretorno','Hora do Retorno') !!}
                                    {{ Form::text('horaretorno', $temporaria->horaretorno, ['id'=>'horaretorno', 'class' => 'form-control hora' ]) }}
                                </div>
                            </div>


                            <div class="col-md-12">
                                <div class="form-group">
                                    {!! Form::label('descricaoretorno','Descrição do retorno')  !!}
                                    {{ Form::textarea('descricaoretorno', null, ['id'=>'descricaoretorno', 'rows' => '3', 'class' => 'form-control', '']) }}
                                </div>
                            </div>

                            <input name="id_temporaria" id="id_temporaria" type="hidden" value="{{$temporaria->id}}">
                            <input name="apenado_id" id="apenado_id" type="hidden" value="{{$temporaria->apenado_id}}">
                            <input name="movimentacao_id" id="movimentacao_id" type="hidden" value="{{$temporaria->idMovimentacao}}">
                            <input name="processo_id" id="processo_id" type="hidden" value="{{$temporaria->idProcesso}}">
                            <input name="unidade_id" id="unidade_id" type="hidden" value="{{$temporaria->unidade_id}}">

                        </fieldset>
                        <div class="modal-footer">
                            <button class="btn btn-success" id="btnModalsalvar" type="submit">SALVAR</button>
                        </div>
                        {{ Form::close() }}
                    </div>
                </div>
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

