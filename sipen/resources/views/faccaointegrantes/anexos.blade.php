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
              <a href="{!! route('faccaointegrantes.listar' ) !!}" class="btn btn-xs btn-light bigger"> <i class="ace-icon fa fa-arrow-left"></i> Voltar </a>
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
            <div class="widget-box widget-color-blue2 ">
                <div class="widget-header">
                    <h4 class="widget-title">DADOS PESSOAIS</h4>
                </div>

                <div class="widget-body">
                    <div class="widget-main no-padding">
                        <fieldset>
                            <div class="col-md-2">
                                <div class="form-group">
                                    {!! Form::label('idApenc','Código')  !!}
                                    {!! Form::text('idApenc',$apenado[0]->idApen, ['class' => 'form-control','id'=>'idApenc', 'readonly']) !!}
                                </div>
                            </div>
                                <div class="col-md-7">
                                    <div class="form-group">
                                        {!! Form::label('nomeapenado','Nome do Apenado')  !!}
                                        {!! Form::text('nomeapenadoc', $apenado[0]->nomeapenado, ['class' => 'form-control','id'=>'nomeapenado', 'readonly']) !!}
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        {!! Form::label('faccaof','FACÇÃO')  !!}
                                        {!! Form::text('faccaof', $apenado[0]->nomefaccao, ['class' => 'form-control','readonly']) !!}
                                    </div>
                                </div>

                        </fieldset>
                    </div>
                </div>
            </div>
        </div>




        <div class="col-md-6">
            <div class="widget-box widget-color-dark ">
                <div class="widget-header">
                    <h4 class="widget-title"> <i class="ace-icon fa fa-info-circle"></i> INFORMAÇÕES ADICIONAIS</h4>
                    <span class="pull-right">
                        <a class="btn btn-success bigger" name="btnInformacoes" > <i class="ace-icon fa fa-plus"></i> ADICIONAR INFORMAÇÕES</a>
                    </span>
                </div>

                <div class="widget-body">
                    <div class="widget-main no-padding">

                        @if(count($informacoes)> 0)
                            <div class="timeline-container">
                                <div class="timeline-items">

                                    @foreach($informacoes as $informacao)

                                        <div id="lista{!! $informacao->idInfo !!}" class="timeline-item clearfix">
                                            <div class="timeline-info">
                                                <i class="timeline-indicator ace-icon fa fa-rocket btn btn-primary no-hover green"></i>
                                            </div>

                                            <div class="widget-box transparent">
                                                <div class="widget-header widget-header-small">
                                                    <h5 class="widget-title smaller">{!! $informacao->nome !!}</h5>
                                                    <span class="widget-toolbar no-border">
                                                    <i class="ace-icon fa fa-clock-o bigger-110"></i> {!! strftime('%d/%m/%Y',strtotime($informacao->datacadastro)) !!}
                                                </span>
                                                    <span class="widget-toolbar">
                                                  <a href="{{route('faccaointegrantes.destroyInformacaoFaccao', ['idApen'=>$apenado[0]->idApen, 'idInfo'=>$informacao->idInfo]) }}" type="submit"
                                                     onclick="return confirm('Deseja realmente excluir esta Informação?');"
                                                     class="text-danger"><i class="fa fa-trash"></i> </a>
                                                    <a href="#" data-action="collapse"> <i class="ace-icon fa fa-chevron-up"></i> </a>
                                                </span>
                                                </div>

                                                <div class="widget-body">
                                                    <div class="widget-main">
                                                        {!! $informacao->descricaoinfo !!}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach

                                </div><!-- /.timeline-items -->
                            </div>
                        @else
                            <div class="well text-center ">
                                <h4 class="text-danger"> <i class="fa fa-warning"></i> Nenhuma Informação Adicional!</h4>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            </div>



        <div class="col-md-6">


            <div class="widget-box widget-color-dark ">
                <div class="widget-header">
                    <h4 class="widget-title"> <i class="ace-icon fa fa-paperclip"></i> DOCUMENTOS ANEXOS</h4>
                    <span class="pull-right">
                        <a class="btn btn-success bigger" name="btnAnexar"> <i class="ace-icon fa fa-plus"></i> ANEXAR DOCUMENTOS</a>
                    </span>
                </div>

                <div class="widget-body">
                    <div class="widget-main no-padding">

                        <div class="table-responsive">
                            <table id="simple-table" class="table table-striped table-bordered table-hover">
                                <thead>
                                <tr class="">
                                    {{--<th>#</th>--}}
                                    <th>TITULO</th>
                                    <th>TIPO DOCUMENTO</th>
                                    <th>DATA LANÇAMENTO</th>
                                    <th></th>
                                    <th></th>
                                </tr>
                                </thead>
                                <tbody>
                                @forelse($anexos as $anexo)
                                    <tr>
                                        {{--<td>{!! $anexo->idAnexo !!}</td>--}}
                                        <td>{!! $anexo->titulo !!}</td>
                                        <td>{!! $anexo->tipodocumento !!}</td>
                                        <td>{!! strftime('%d/%m/%Y',strtotime($anexo->datalancamento)) !!}</td>
                                        <td>
                                            <?php
                                            $tipo = '';
                                          //  $arquivo = $anexo->nomearquivo;
                                          //  $extensao = $anexo->nomearquivo;->getClientOriginalExtension();
                                            $extensao = pathinfo($anexo->nomearquivo, PATHINFO_EXTENSION);
                                            if($extensao != 'jpg' && $extensao != 'png'  && $extensao != 'bmp' && $extensao != 'jpeg'  && $extensao != 'gif')
                                            {
                                                $tipo = 'doc';
                                            }
                                            ?>
                                                <a href="{{ asset('public/'.$anexo->nomearquivo) }}" target="{{$tipo == 'doc' ? '' : '_blank' }}" class="{{$tipo == 'doc' ? '' : 'group1' }}" >
                                                    <img width="50" height="50" alt="Clique Para Abrir" src="{{ $tipo == 'doc' ? asset('public/documentos_Faccao/doc.png') : asset('public/'.$anexo->nomearquivo) }}" />
                                                </a>
                                            {{--<a href="#" class="btn btn-xs btn-danger" title="Excluir Documento" > <i class="ace-icon fa fa-times--}}
 {{--bigger-120"></i> </a>--}}
                                        </td>
                                        <td>
                                            <a href="{{route('faccaointegrantes.destroyAnexoFaccao', ['idApen'=>$apenado[0]->idApen, 'idInfo'=>$anexo->idAnexo]) }}" type="submit"
                                               onclick="return confirm('Deseja realmente excluir esta Informação?');"
                                               class="text-danger"><i class="fa fa-trash"></i> </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="12">
                                            <div class="well text-center ">
                                                <h4 class="text-danger"> <i class="fa fa-warning"></i> Nenhum Anexo Encontrado!</h4>
                                            </div>
                                    </tr>
                                @endforelse

                                </tbody>
                            </table>
                        </div>


                    </div>
                </div>

            </div>

        </div>









    <div class="modal fade" id="myModalAnexar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog modal-lg " role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title"> <i class="fa fa-paperclip" ></i> ANEXAR DOCUMENTOS</h4>
                </div>

                {!!Form::open ( ['route'=>('faccaointegrantes.anexos_salvar'), 'id'=>'formModalAnexar', 'enctype' => 'multipart/form-data']) !!}
                <fieldset>
                    <input type="hidden" name="idApen" value="{{ $apenado[0]->idApen }}">
                    <input type="hidden" name="idIntegrante" value="{{ $apenado[0]->id }}">
                    <div class="col-md-6">
                        <div class="form-group">
                            {!! Form::label('titulo','Titulo do Documento')  !!}
                            {!! Form::text('titulo',null, ['class' => 'form-control','id'=>'titulo']) !!}
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            {!! Form::label('foto','Buscar Documento / Imagem')  !!}
                            <input type="file" id="foto" name="foto" class="form-control"  >
                        </div>
                    </div>
                </fieldset>

                <div class="form-actions center">
                    <input  class="btn btn-success" type="submit" name="btnAnexarDados" id="btnAnexarDados" value="Anexar" >
                </div>

                {{ Form::close() }}
            </div>
        </div>
    </div>



    <div class="modal fade" id="myModalInformacoes" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog modal-lg " role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title"> <i class="fa fa-info-circle" ></i> INFORMAÇÕES ADICIONAIS</h4>
                </div>

                {!! Form::open(['route'=>['faccaointegrantes.informacoes_inserir'], 'id'=>'formModalInformacoes']) !!}
                <fieldset>
                    <input type="hidden" name="idapenid" id="idapenid" value="{!! $apenado[0]->idApen !!}">
                    <div class="col-md-12">
                        <div class="form-group">
                            {!! Form::label('descricaoinfo','Digite as Informações')  !!}
                            {{ Form::textarea('descricaoinfo', null, ['id'=>'descricaoinfo', 'rows'=>'6', 'class' => 'form-control']) }}
                        </div>
                    </div>
                </fieldset>

                <div class="form-actions center">
                        <input  class="btn btn-success" type="submit" name="btnInformaDados" id="btnInformaDados" value="Salvar" >
                </div>

                {{ Form::close() }}
            </div>
        </div>
    </div>





@endsection

@section('scripts')
    {{ HTML::script('resources/assets/js/faccao/script.js') }}
    <script src={{asset('resources/assets/js/jquery.colorbox.js')}}></script>
  {{ HTML::script('resources/assets/js/validacao/validacao.js') }}

    <script>
        $(document).ready(function(){
            //Examples of how to assign the Colorbox event to elements
            $(".group1").colorbox({rel:'group1'});
            $(".group2").colorbox({rel:'group2', transition:"fade"});

            $(".callbacks").colorbox({
                onOpen:function(){ alert('onOpen: colorbox is about to open'); },
                onLoad:function(){ alert('onLoad: colorbox has started to load the targeted content'); },
                onComplete:function(){ alert('onComplete: colorbox has displayed the loaded content'); },
                onCleanup:function(){ alert('onCleanup: colorbox has begun the close process'); },
                onClosed:function(){ alert('onClosed: colorbox has completely closed'); }
            });

            $('.non-retina').colorbox({rel:'group5', transition:'none'})
            $('.retina').colorbox({rel:'group5', transition:'none', retinaImage:true, retinaUrl:true});

            //Example of preserving a JavaScript event for inline calls.
            $("#click").click(function(){
                $('#click').css({"background-color":"#f00", "color":"#fff", "cursor":"inherit"}).text("Open this window again and this message will still be here.");
                return false;
            });
        });
    </script>


@stop