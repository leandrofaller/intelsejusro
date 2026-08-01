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



    <!-- Main content -->

    <div class="row">
        <div class="col-xs-12">
            <div class="widget-box widget-color-dark">
                <div class="widget-header">
                    <h4 class="widget-title">Editar</h4>
                </div>

                <div class="widget-body">
                    <div class="widget-main no-padding">

                    {!! Form::open(['route'=>['unidadesprisionais.update', $unidade->id], 'method'=>'put', 'id'=>'formulario']) !!}

                        <fieldset>

                            <div class="col-md-6">
                                <div class="form-group">
                                    {!! Form::label('nomeunidade','Nome da Unidade Prisional')  !!} <small class="red">*</small>
                                    {!! Form::text('nomeunidade', $unidade->nomeunidade, ['class' => 'form-control','id'=>'nomeunidade']) !!}
                                </div>
                            </div>

                            <div class="col-md-2">
                                <div class="form-group">
                                    {!! Form::label('siglaunidade','Sigla da Unidade')  !!}  <small class="red">*</small>
                                    {!! Form::text('siglaunidade', $unidade->siglaunidade, ['class' => 'form-control','id'=>'siglaunidade']) !!}
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    {!! Form::label('cnpj','CNPJ')  !!}  <small class="red">*</small>
                                    {!! Form::text('cnpj', $unidade->cnpj, ['class' => 'form-control cnpj','id'=>'cnpj']) !!}
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    {!! Form::label('recebeapenados','Recebe Apenados')  !!}  <small class="red">*</small>
                                    {{ Form::select('recebeapenados', \App\Model\Unidade::$recebeapenados, $unidade->recebeapenados, ['class' => 'form-control']) }}
                                </div>
                            </div>


                            <div class="col-md-3">
                                <div class="form-group">
                                    {!! Form::label('cidadeunidade','Cidade/Comarca')  !!}  <small class="red">*</small>
                                    {!! Form::text('cidadeunidade', $unidade->cidadeunidade, ['class' => 'form-control','id'=>'cidadeunidade']) !!}
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    {!! Form::label('nomediretorgeral','Nome do Diretor Geral')  !!}  <small class="red">*</small>
                                    {!! Form::text('nomediretorgeral', $unidade->nomediretorgeral, ['class' => 'form-control','id'=>'nomediretorgeral']) !!}
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    {!! Form::label('nomediretoradm','Nome do Diretor Administrativo')  !!}  <small class="red">*</small>
                                    {!! Form::text('nomediretoradm', $unidade->nomediretoradm, ['class' => 'form-control','id'=>'nomediretoradm']) !!}
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    {!! Form::label('nomediretorseg','Nome do Diretor de Segurança')  !!}  <small class="red">*</small>
                                    {!! Form::text('nomediretorseg', $unidade->nomediretorseg, ['class' => 'form-control','id'=>'nomediretorseg']) !!}
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    {!! Form::label('telefoneunidade','Telefone de Contato')  !!}  <small class="red">*</small>
                                    {!! Form::text('telefoneunidade', $unidade->telefoneunidade, ['class' => 'form-control','id'=>'telefoneunidade']) !!}
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    {!! Form::label('capacidade','Capacidade de Apenados')  !!}  <small class="red">*</small>
                                    {!! Form::text('capacidade', $unidade->capacidade, ['class' => 'form-control','id'=>'capacidade']) !!}
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    {!! Form::label('tipoestabelecimento','Tipo de Estabelecimento')  !!}  <small class="red">*</small>
                                    {{ Form::select('tipoestabelecimento', \App\Model\Unidade::$tipoestabelecimento, $unidade->tipoestabelecimento, ['class' => 'form-control']) }}
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    {!! Form::label('categoria','Categoria da Unidade')  !!}  <small class="red">*</small>
                                    {{ Form::select('categoria', \App\Model\Unidade::$categorias, $unidade->categoria, ['class' => 'form-control']) }}
                                </div>
                            </div>

                            <div class="col-md-5">
                                <div class="form-group">
                                    {!! Form::label('endereco','Endereço')  !!}  <small class="red">*</small>
                                    {!! Form::text('endereco', $unidade->endereco, ['class' => 'form-control','id'=>'endereco']) !!}
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    {!! Form::label('latitude','Latitude')  !!}
                                    {!! Form::text('latitude', $unidade->latitude, ['class' => 'form-control naoValidar','id'=>'latitude']) !!}
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    {!! Form::label('longitude','Longitude')  !!}
                                    {!! Form::text('longitude', $unidade->longitude, ['class' => 'form-control naoValidar','id'=>'longitude']) !!}
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    {!! Form::label('regiao_id','REGIÃO')  !!}
                                    {{ Form::select('regiao_id', $regioes, null, ['class' => 'form-control']) }}
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    {!! Form::label('obs','Informações Adicionais')  !!}
                                    {!! Form::textarea('obs', $unidade->obs, ['class' => 'form-control naoValidar','id'=>'obs',  'maxlength'=>'240', 'rows'=>'3']) !!}
                                </div>
                                <small>Máximo de 240 Caracteres</small>
                            </div>

                        </fieldset>



                        <div class="form-actions center">
                            <button type="submit" class="btn btn-sm btn-success " id="btnEnviar">
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