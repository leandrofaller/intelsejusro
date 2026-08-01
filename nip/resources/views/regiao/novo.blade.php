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
              <a href="{{ route('regioes.index') }}" class="btn btn-xs btn-light bigger"> <i class="ace-icon fa fa-arrow-left"></i> Voltar </a>
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

                    {!!Form::open ( ['route'=>('regioes.salvar'),'id'=>'formulario' ]) !!}
                            <!-- <legend>Form</legend> -->
                            <fieldset>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        {!! Form::label('nomeregiao','Nome da Região')  !!}  <small class="red">*</small>
                                        {!! Form::text('nomeregiao', null, ['class' => 'form-control','id'=>'nomeregiao']) !!}
                                    </div>
                                </div>
                            </fieldset>


                            <div class="form-actions center">
                                {{--<input  class="btn btn-success" type="submit" id="btnEnviar" value="Salvar" >--}}
                                <button type="submit" class="btn btn-sm btn-success"  id="btnEnviar">
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
    {{ HTML::script('resources/assets/js/mask/maskedinput.min.js') }}
    {{ HTML::script('resources/assets/js/validacao/formatainput.js') }}

@stop