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
              <a href="{!! route('apenados.selecionarOpcao', $apenado->id) !!}" class="btn btn-xs btn-light bigger"> <i class="ace-icon fa fa-arrow-left"></i> Voltar </a>
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
            <div class="widget-box widget-color-dark ">
                <div class="widget-header">
                    <h4 class="widget-title">DADOS PESSOAIS</h4>
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
                                        {!! Form::label('cpf','Cpf')  !!}
                                        {!! Form::text('cpfc', $apenado->cpf, ['class' => 'form-control cpf','id'=>'cpf','readonly']) !!}
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        {!! Form::label('numprocesso','Processo / Execução')  !!}
                                        {!! Form::text('numprocesso', $apenado->numeroprocesso, ['class' => 'form-control cpf','id'=>'cpf','readonly']) !!}
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        {!! Form::label('datanascimento','Nascimento')  !!}
                                        {!! Form::text('datanascimentoc', $apenado->datanascimento ? strftime('%d/%m/%Y',strtotime($apenado->datanascimento)) : null , ['class' => 'form-control', 'readonly']) !!}
                                    </div>
                                </div>
                                <div class="col-md-5">
                                    <div class="form-group">
                                        {!! Form::label('unidade','Unidade Prisional')  !!}
                                        {!! Form::text('unidade', $apenado->nomeunidade , ['class' => 'form-control', 'readonly']) !!}
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        {!! Form::label('cela','Cela Atual')  !!}
                                        {!! Form::text('celac', $apenado->nomecela , ['class' => 'form-control', 'readonly']) !!}
                                    </div>
                                </div>

                        </fieldset>
                    </div>
                </div>
            </div>
        </div>


        <div class="col-md-12">
            <div class="widget-box widget-color-blue ">
                <div class="widget-header">
                    <h4 class="widget-title">INCLUIR FOTOS</h4>
                </div>

                <div class="widget-body">
                    <div class="widget-main no-padding">
                        {!! Form::open(['route'=>['apenados.fotosSalvar', $apenado->id ], 'id'=>'formulario', 'enctype' => 'multipart/form-data' ]) !!}
                            <fieldset>
                                <input type="hidden" value="{{ $apenado->id }}" name="idApenado">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        {!! Form::label('descricao_foto','Descrição Foto')  !!} <label class="red">*</label>
                                        {!! Form::text('descricao_foto', 'Nada Informado', ['class' => 'form-control naoValidar','id'=>'descricao_foto', ]) !!}
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        {!! Form::label('arquivo_foto','Buscar Foto')  !!}
                                        <input type="file" id="arquivo_foto" name="arquivo_foto" class="form-control">
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


        <div class="col-md-12">
            <div class="widget-box widget-color-dark ">
                <div class="widget-header">
                    <h4 class="widget-title">FOTOS CADASTRADAS</h4>
                </div>

                <div class="widget-body">
                    <div class="widget-main no-padding">



                        <!--  INÍCIO  -->
                        <ul class="ace-thumbnails clearfix">
                            <!-- #section:pages/gallery -->

                            @forelse($fotos as $dado)

                                <li>

                                    @if($dado->arquivo_foto != 'fotosPresos/semfoto.png')
                                        <a href="{!! asset('public/'.$dado->arquivo_foto) !!}" title="Fotos Apenados" data-rel="colorbox" class="cboxElement">
                                            <img width="150" height="150" alt="150x150" src="{!! asset('public/'.$dado->arquivo_foto) !!}">
                                        </a>



                                        <div class="tags">
                                            <span class="label-holder">
                                                @if($dado->atual_foto == 'S')
                                                <span class="label label-success">PRINCIPAL</span>
                                                @endif
                                             </span>
                                        </div>

                                    @endif

                                        <div class="tools">

                                            <a href="{{route('apenados.fotoPrincipal', [$dado->id, $dado->apenado_id ]) }}" type="submit"
                                            onclick="return confirm('Deseja realmente executar esta ação?');"
                                            ><i class="ace-icon fa fa-link"></i> </a>


                                            <a href="#">
                                                <a href="{{route('apenados.fotoExcluir', ['id'=>$dado->id ]) }}" type="submit"
                                                   onclick="return confirm('Deseja realmente excluir esta Foto?');"
                                                ><i class="ace-icon fa fa-times red"></i> </a>
                                            </a>

                                        </div>


                                </li>
                            @empty
                                  <h4 class="text-danger"> <i class="fa fa-warning"></i> Nenhuma Foto!</h4>
                        @endforelse

                        </ul>
                        <!--  FIM  -->

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

    {{ HTML::script('resources/assets/js/jquery.colorbox.js') }}

    <script type="text/javascript">
        jQuery(function($) {
            var $overflow = '';
            var colorbox_params = {
                rel: 'colorbox',
                reposition:true,
                scalePhotos:true,
                scrolling:false,
                previous:'<i class="ace-icon fa fa-arrow-left"></i>',
                next:'<i class="ace-icon fa fa-arrow-right"></i>',
                close:'&times;',
                current:'{current} of {total}',
                maxWidth:'100%',
                maxHeight:'100%',
                onOpen:function(){
                    $overflow = document.body.style.overflow;
                    document.body.style.overflow = 'hidden';
                },
                onClosed:function(){
                    document.body.style.overflow = $overflow;
                },
                onComplete:function(){
                    $.colorbox.resize();
                }
            };

            $('.ace-thumbnails [data-rel="colorbox"]').colorbox(colorbox_params);
            $("#cboxLoadingGraphic").html("<i class='ace-icon fa fa-spinner orange fa-spin'></i>");//let's add a custom loading icon


            $(document).one('ajaxloadstart.page', function(e) {
                $('#colorbox, #cboxOverlay').remove();
            });
        })
    </script>


@stop