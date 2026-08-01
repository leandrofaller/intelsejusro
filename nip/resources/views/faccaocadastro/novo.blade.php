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
              <a href="{{ route('faccaocadastro.index') }}" class="btn btn-xs btn-light bigger"> <i class="ace-icon fa fa-arrow-left"></i> Voltar </a>
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

                    {!!Form::open ( ['route'=>('faccaocadastro.salvar')] ) !!}
                            <!-- <legend>Form</legend> -->
                            <fieldset>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        {!! Form::label('nomefaccao','Nome da Facção')  !!}
                                        {!! Form::text('nomefaccao', null, ['class' => 'form-control','id'=>'nomefaccao']) !!}
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        {!! Form::label('sigla','SIGLA')  !!}
                                        {!! Form::text('sigla', null, ['class' => 'form-control','id'=>'sigla']) !!}
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        {!! Form::label('cor','COR DE REFERÊNCIA')  !!}
                                        {!! Form::select('cor', \App\Model\Faccao::$cores, null, ['class' => 'form-control','id'=>'cor']) !!}
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        {!! Form::label('anofundacao','Ano de fundação')  !!}
                                        {!! Form::text('anofundacao', null, ['class' => 'form-control','id'=>'anofundacao']) !!}
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        {!! Form::label('origem','Origem')  !!}
                                        {!! Form::text('origem', null, ['class' => 'form-control','id'=>'origem']) !!}
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        {!! Form::label('historico','Histórico da Fundação')  !!}
                                        {!! Form::text('historico', null, ['class' => 'form-control','id'=>'historico']) !!}
                                    </div>
                                </div>


                            </fieldset>



                            <div class="form-actions center">
                                <button type="submit" class="btn btn-sm btn-success">
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
