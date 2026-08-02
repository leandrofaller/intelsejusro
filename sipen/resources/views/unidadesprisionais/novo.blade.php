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
              <a href="{{ route('unidadesprisionais.index') }}" class="btn btn-xs btn-light bigger"> <i class="ace-icon fa fa-arrow-left"></i> Voltar </a>
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

                    {!!Form::open ( ['route'=>('unidadesprisionais.salvar'),'id'=>'formulario' ]) !!}
                            <!-- <legend>Form</legend> -->
                            <fieldset>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        {!! Form::label('nomeunidade','Nome da Unidade Prisional')  !!}  <small class="red">*</small>
                                        {!! Form::text('nomeunidade', null, ['class' => 'form-control','id'=>'nomeunidade']) !!}
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <div class="form-group">
                                        {!! Form::label('siglaunidade','Sigla da Unidade')  !!}  <small class="red">*</small>
                                        {!! Form::text('siglaunidade', null, ['class' => 'form-control','id'=>'siglaunidade']) !!}
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        {!! Form::label('cnpj','CNPJ')  !!}  <small class="red">*</small>
                                        {!! Form::text('cnpj', null, ['class' => 'form-control cnpj','id'=>'cnpj']) !!}
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        {!! Form::label('recebeapenados','Recebe Apenados')  !!}  <small class="red">*</small>
                                        {{ Form::select('recebeapenados', \App\Model\Unidade::$recebeapenados, null, ['class' => 'form-control']) }}
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        {!! Form::label('cidadeunidade','Cidade/Comarca')  !!}  <small class="red">*</small>
                                        {!! Form::text('cidadeunidade', null, ['class' => 'form-control','id'=>'cidadeunidade']) !!}
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        {!! Form::label('nomediretorgeral','Nome do Diretor Geral')  !!}  <small class="red">*</small>
                                        {!! Form::text('nomediretorgeral', null, ['class' => 'form-control','id'=>'nomediretorgeral']) !!}
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        {!! Form::label('nomediretoradm','Nome do Diretor Administrativo')  !!}  <small class="red">*</small>
                                        {!! Form::text('nomediretoradm', null, ['class' => 'form-control','id'=>'nomediretoradm']) !!}
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        {!! Form::label('nomediretorseg','Nome do Diretor de Segurança')  !!}  <small class="red">*</small>
                                        {!! Form::text('nomediretorseg', null, ['class' => 'form-control','id'=>'nomediretorseg']) !!}
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        {!! Form::label('telefoneunidade','Telefone de Contato')  !!}  <small class="red">*</small>
                                        {!! Form::text('telefoneunidade', null, ['class' => 'form-control','id'=>'telefoneunidade']) !!}
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <div class="form-group">
                                        {!! Form::label('capacidade','Capacidade de Apenados')  !!}  <small class="red">*</small>
                                        {!! Form::text('capacidade', null, ['class' => 'form-control','id'=>'capacidade']) !!}
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        {!! Form::label('tipoestabelecimento','Tipo de Estabelecimento')  !!}  <small class="red">*</small>
                                        {{ Form::select('tipoestabelecimento', \App\Model\Unidade::$tipoestabelecimento, null, ['class' => 'form-control']) }}
                                    </div>
                                </div>


                                <div class="col-md-3">
                                    <div class="form-group">
                                        {!! Form::label('categoria','Categoria da Unidade')  !!}  <small class="red">*</small>
                                        {{ Form::select('categoria', \App\Model\Unidade::$categorias, null, ['class' => 'form-control']) }}
                                    </div>
                                </div>

                                <div class="col-md-5">
                                    <div class="form-group">
                                        {!! Form::label('endereco','Endereço')  !!}  <small class="red">*</small>
                                        {!! Form::text('endereco', null, ['class' => 'form-control','id'=>'endereco']) !!}
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        {!! Form::label('latitude','Latitude')  !!}
                                        {!! Form::text('latitude', null, ['class' => 'form-control naoValidar','id'=>'latitude']) !!}
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        {!! Form::label('longitude','Longitude')  !!}
                                        {!! Form::text('longitude', null, ['class' => 'form-control naoValidar','id'=>'longitude']) !!}
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        {!! Form::label('regiao_id','REGIÃO')  !!}
                                        {{--{{ Form::select('regiao_id', $regioes, null, ['class' => 'form-control']) }}--}}

                                        <select name="regiao_id" id="regiao_id" class="form-control">
                                            <option value=""></option>
                                            @foreach($regioes as $regiao)
                                                <option value="{{ $regiao->id }}"> {{$regiao->nomeregiao}} </option>
                                            @endforeach
                                        </select>


                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        {!! Form::label('obs','Informações Adicionais')  !!}
                                        {!! Form::textarea('obs', null, ['class' => 'form-control naoValidar','id'=>'obs',  'maxlength'=>'240', 'rows'=>'3']) !!}
                                    </div>
                                    <small>Máximo de 240 Caracteres</small>
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