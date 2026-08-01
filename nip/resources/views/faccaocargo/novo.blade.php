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
              <a href="{{ route('faccaocargo.index') }}" class="btn btn-xs btn-light bigger"> <i class="ace-icon fa fa-arrow-left"></i> Voltar </a>
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

                    {!!Form::open ( ['route'=>('faccaocargo.salvar')] ) !!}
                            <!-- <legend>Form</legend> -->
                            <fieldset>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        {!! Form::label('faccao_id','Informe a que facção Pertence o Cargo')  !!}
                                        {!! Form::select('faccao_id', $faccoes, null, ['class' => 'form-control','id'=>'faccao_id']) !!}
                                    </div>
                                </div>


                                <div class="col-md-8">
                                    <div class="form-group">
                                        {!! Form::label('nomecargo','Nome do Cargo')  !!}
                                        {!! Form::text('nomecargo', null, ['class' => 'form-control','id'=>'nomecargo']) !!}
                                    </div>
                                </div>

                                <div class="col-md-8">
                                    <div class="form-group">
                                        {!! Form::label('descricao','Descrição')  !!}
                                        {!! Form::text('descricao', null, ['class' => 'form-control','id'=>'descricao']) !!}
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        {!! Form::label('nivel','Nível')  !!}
                                        {!! Form::select('nivel', \App\Model\CargosFaccao::$niveis, null, ['class' => 'form-control','id'=>'nivel']) !!}
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
