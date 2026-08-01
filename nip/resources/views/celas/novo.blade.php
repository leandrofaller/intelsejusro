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
              <a href="{{ route('celas.index', $carceragem->id) }}" class="btn btn-xs btn-light bigger"> <i class="ace-icon fa fa-arrow-left"></i> Voltar </a>
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
            <div class="widget-box widget-color-dark">
                <div class="widget-header">
                    <h4 class="widget-title">Novo</h4>
                </div>

                <div class="widget-body">
                    <div class="widget-main no-padding">

                        {!!Form::open ( ['route'=>('celas.salvar'), 'id'=>'formulario'] ) !!}
                            <fieldset>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        {!! Form::label('carceragem_id','Nome Carceragem')  !!}
                                        <select name="carceragem_id" id="carceragem_id" class="form-control naoValidar" readonly >
                                            <option value="{{$carceragem->id}}">{{$carceragem->nomecarceragem}}</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        {!! Form::label('nomecela','Nome')  !!} <small class="red" >*</small>
                                        {!! Form::text('nomecela', null, ['class' => 'form-control','id'=>'nomecela']) !!}
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        {!! Form::label('capacidade','Capacidade de Apenados')  !!} <small class="red" >*</small>
                                        {!! Form::text('capacidade', null, ['class' => 'form-control','id'=>'capacidade']) !!}
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        {!! Form::label('tipocela','Tipo')  !!} <small class="red" >*</small>
                                        {{ Form::select('tipocela', App\Model\Cela::$tipo, null, ['class' => 'form-control']) }}
                                    </div>
                                </div>

                            </fieldset>

                            <div class="form-actions center">
                                <button type="submit" class="btn btn-sm btn-success" id="btnEnviar">
                                    <i class="ace-icon fa fa-save icon-on-right bigger-110"></i>
                                    Salvar
                                </button>
                            </div>

                        {!! Form::close() !!}

                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('scripts')
    {{ HTML::script('resources/assets/js/validacao/validacao.js') }}
@stop