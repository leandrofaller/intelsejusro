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
              <a href="{{ route('carceragens.index', $idUnidade ) }}" class="btn btn-xs btn-light bigger"> <i class="ace-icon fa fa-arrow-left"></i> Voltar </a>
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

                        {!! Form::open(['route'=>['carceragens.update', $carceragem->id, $idUnidade], 'id'=>'formulario', 'method'=>'put']) !!}

                        <fieldset>

                            <div class="col-md-12">
                                <div class="form-group">
                                    {!! Form::label('unidade_id','Nome Unidade Prisional')  !!}
                                    {{ Form::select('unidade_id', $unidade, $idUnidade, ['class' => 'form-control']) }}
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    {!! Form::label('nomecarceragem','Nome da Carceragem')  !!} <small class="red">*</small>
                                    {!! Form::text('nomecarceragem', $carceragem->nomecarceragem, ['class' => 'form-control','id'=>'nomecarceragem']) !!}
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    {!! Form::label('faccao','Pertence a faccção')  !!} <small class="red">*</small>
                                    {{ Form::select('faccao', $faccoes, $carceragem->faccao, ['class' => 'form-control']) }}
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    {!! Form::label('tipocarceragem','Tipo')  !!} <small class="red">*</small>
                                    {{ Form::select('tipocarceragem', App\Model\Carceragem::$tipo,  $carceragem->tipocarceragem, ['class' => 'form-control']) }}
                                </div>
                            </div>



                            <div class="col-md-3">
                                <div class="form-group">
                                    {!! Form::label('status', 'Situação')  !!} <small class="red">*</small>
                                    <select name="status" id="status" class="form-control">
                                        @if($carceragem->status == 'Ativo')
                                            <option selected value="Ativo">Ativo</option>
                                            <option value="Inativo">Inativo</option>
                                        @else
                                            <option value="Ativo">Ativo</option>
                                            <option selected value="Inativo">Inativo</option>
                                        @endif
                                    </select>
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