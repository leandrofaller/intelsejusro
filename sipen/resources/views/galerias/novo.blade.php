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
              <a href="{!! route('galerias') !!}" class="btn btn-xs btn-light bigger"> <i class="ace-icon fa fa-arrow-left"></i> Voltar </a>
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





        <div class="col-md-12">
            <div class="widget-box widget-color-blue ">
                <div class="widget-header">
                    <h4 class="widget-title">INCLUIR FOTOS</h4>
                </div>

                <div class="widget-body">
                    <div class="widget-main no-padding">
                        {!! Form::open(['route'=>['galerias.salvar'], 'id'=>'formulario', 'enctype' => 'multipart/form-data' ]) !!}
                            <fieldset>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        {!! Form::label('categoria','Categoria')  !!} <label class="red">*</label>
                                        {!! Form::select('categoria', $categorias, 0, ['class' => 'form-control','id'=>'categoria']) !!}
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        {!! Form::label('restricao','Arquivo')  !!} <label class="red">*</label>
                                        {!! Form::select('restricao', \App\Model\Galerias::$restricao, 0, ['class' => 'form-control','id'=>'restricao']) !!}
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        {!! Form::label('titulo','Titulo') !!}
                                        {!! Form::text('titulo', null, ['class' => 'form-control naoValidar','id'=>'titulo' ]) !!}
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        {!! Form::label('descricao','Descrição') !!}
                                        {!! Form::text('descricao', '', ['class' => 'form-control naoValidar','id'=>'descricao','maxlength'=>'300' ]) !!}
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="form-group">
                                        {!! Form::label('arquivo_foto','Buscar Foto')  !!}
                                        <input type="file" id="imagem" name="imagem" class="form-control">
                                    </div>
                                </div>

                            </fieldset>
                        <div class="form-actions center">
                            <input  class="btn btn-success" type="submit" id="btnEnviar" value="Salvar" >
                        </div>
                    {!! Form::close() !!}
                        <!-- /.row -->
                    </div>
                    <!-- /.box-body -->
                </div>
            </div>
        </div>


    <script src={{asset('resources/assets/js/jquery.js')}}></script>


@endsection

@section('scripts')

    {{ HTML::script('resources/assets/js/selectGeral.js') }}
    {{ HTML::script('resources/assets/js/apenados/script.js') }}

    {{ HTML::script('resources/assets/js/datepickerJS/bootstrap-datepicker.min.js') }}
    {{ HTML::script('resources/assets/js/datepickerJS/bootstrap-datepicker.pt-BR.min.js') }}

    {{ HTML::script('resources/assets/js/mask/maskedinput.min.js') }}
    {{ HTML::script('resources/assets/js/validacao/formatainput.js') }}
    {{ HTML::script('resources/assets/js/validacao/validacao.js') }}




@stop