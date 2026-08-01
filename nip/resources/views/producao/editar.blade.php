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
              <a href="{!! route('producao.index') !!}" class="btn btn-xs btn-light bigger"> <i class="ace-icon fa fa-arrow-left"></i> Voltar </a>
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



    {!! Form::model($producao, ['route'=>['producao.update', $producao->id], 'id'=>'formulario', 'method'=>'put', 'enctype' => 'multipart/form-data'   ]) !!}

    <div class="row">
        <div class="col-md-12">
            <div class="widget-box widget-color-dark">
                <div class="widget-header">
                    <h4 class="widget-title">DADOS PESSOAIS</h4>
                </div>

                <div class="widget-body">
                    <div class="widget-main no-padding">
                        <fieldset>
                            <div class="col-md-2">
                                <div class="form-group">
                                    {!! Form::label('numb','Número') !!}
                                    {!! Form::text('numb', $producao->numero, ['class' => 'form-control','id'=>'numb', 'readonly']) !!}
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    {!! Form::label('seguranca','Segurança') !!}
                                    {!! Form::select('seguranca', \App\Model\Producao::$seguranca , null, ['class' => 'form-control naoValidar','id'=>'seguranca']) !!}
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    {!! Form::label('tipo_id','Tipo de Relatório') !!}
                                    {!! Form::select('tipo_id', $tipo, null, ['class' => 'form-control naoValidar','id'=>'tipo_id']) !!}
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    {!! Form::label('origem','Origem') !!}
                                    {!! Form::text('origem', null, ['class' => 'form-control naoValidar ','id'=>'origem', ]) !!}
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    {!! Form::label('datarelatorio','Data') !!}
                                    {!! Form::text('datarelatorio', dataFormat($producao->datarelatorio), ['class' => 'form-control naoValidar date','id'=>'datarelatorio']) !!}
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    {!! Form::label('assunto','Assunto') !!}
                                    {!! Form::text('assunto', null, ['class' => 'form-control naoValidar','id'=>'assunto']) !!}
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    {!! Form::label('difusao','Difusão') !!}
                                    {!! Form::text('difusao', null, ['class' => 'form-control naoValidar','id'=>'difusao']) !!}
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    {!! Form::label('difusaoanterior','Difusão Anterior') !!}
                                    {!! Form::text('difusaoanterior', null, ['class' => 'form-control naoValidar','id'=>'difusaoanterior']) !!}
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    {!! Form::label('referencia','Referência') !!}
                                    {!! Form::text('referencia', null, ['class' => 'form-control naoValidar','id'=>'referencia']) !!}
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    {!! Form::label('anexo','Anexo') !!}
                                    {!! Form::text('anexo', null, ['class' => 'form-control naoValidar','id'=>'anexo']) !!}
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    {!! Form::label('unidade_id','Unidade Prisional')  !!} <label class="red">*</label>
                                    {!! Form::select('unidade_id', $unidades, null, ['class' => 'form-control naoValidar','id'=>'unidade_id']) !!}
                                </div>
                            </div>

                            <!-- /.row -->
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
                    <h4 class="widget-title">DESCRIÇÃO DO RELATÓRIO</h4>
                </div>
                <div class="widget-body">
                    <div class="widget-main no-padding">
                        <fieldset>
                            <textarea name="conteudo" style="min-height: 600px;" class="form-control my-editor naoValidar">{!! old('conteudo', $producao->conteudo) !!}</textarea>
                        </fieldset>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if($producao->status_id <> 2)
    <div class="row">
        <div class="col-md-12">
            <div class="widget-box widget-color-dark">
                <div class="widget-header">
                    <h4 class="widget-title">SITUAÇÃO</h4>
                </div>
                <div class="widget-body">
                    <div class="widget-main no-padding">
                        <fieldset>
                            <div class="col-md-4">
                                <div class="form-group">
                                    {!! Form::label('status_id','Selecione a Situação do Relatório') !!}
                                    {!! Form::select('status_id', $status, $producao->status_id, ['class' => 'form-control','id'=>'status_id']) !!}
                                </div>
                            </div>
                        </fieldset>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="widget-box widget-color-dark">
        <div class="form-actions center">

                <button type="submit" class="btn btn-sm btn-success" id="btnEnviar">
                    <i class="ace-icon fa fa-save icon-on-right bigger-110"></i>
                    Salvar
                </button>

        </div>
    </div>

    @else
        <div class="alert-success"><h2>Somente Visualização</h2></div>
    @endif
    {!! Form::close() !!}





@endsection


@section('scripts')

    <script src="//cdn.tinymce.com/4/tinymce.min.js"></script>
    <script>
        var editor_config = {
            path_absolute : "/",
            selector: "textarea.my-editor",
            plugins: [
                "advlist autolink lists link image charmap print preview hr anchor pagebreak",
                "searchreplace wordcount visualblocks visualchars code fullscreen",
                "insertdatetime media nonbreaking save table contextmenu directionality",
                "emoticons template paste textcolor colorpicker textpattern"
            ],
            toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image media",
            relative_urls: false,
            file_browser_callback : function(field_name, url, type, win) {
                var x = window.innerWidth || document.documentElement.clientWidth || document.getElementsByTagName('body')[0].clientWidth;
                var y = window.innerHeight|| document.documentElement.clientHeight|| document.getElementsByTagName('body')[0].clientHeight;

                var cmsURL = editor_config.path_absolute + 'sipen/public/fileproducao?field_name=' + field_name;
                if (type == 'image') {
                    cmsURL = cmsURL + "&type=Images";
                } else {
                    cmsURL = cmsURL + "&type=Files";
                }

                tinyMCE.activeEditor.windowManager.open({
                    file : cmsURL,
                    title : 'Filemanager',
                    width : x * 0.8,
                    height : y * 0.8,
                    resizable : "yes",
                    close_previous : "no"
                });
            }
        };

        tinymce.init(editor_config);
    </script>

    {{ HTML::script('resources/assets/js/datepickerJS/bootstrap-datepicker.min.js') }}
    {{ HTML::script('resources/assets/js/datepickerJS/bootstrap-datepicker.pt-BR.min.js') }}
    {{ HTML::script('resources/assets/js/mask/maskedinput.min.js') }}
    {{ HTML::script('resources/assets/js/validacao/formatainput.js') }}
    {{ HTML::script('resources/assets/js/validacao/validacao.js') }}
    {{ HTML::script('resources/assets/js/validacao/confirme.js') }}

@stop



