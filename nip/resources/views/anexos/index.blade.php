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
                        <input type="hidden" value="{{ $apenado->id }}" name="idapenado">
                        <div class="col-md-12">
                            <div class="form-group">
                                {!! Form::label('nomeapenado','Nome do Apenado')  !!}
                                {!! Form::text('nomeapenadoc', $apenado->nomeapenado, ['class' => 'form-control','id'=>'nomeapenado', 'readonly']) !!}
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                {!! Form::label('cpf','Cpf do Apenado')  !!}
                                {!! Form::text('cpfc', $apenado->cpf, ['class' => 'form-control cpf','id'=>'cpf','readonly']) !!}
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                {!! Form::label('datanascimento','Nascimento')  !!}
                                {!! Form::text('datanascimentoc', strftime('%d/%m/%Y',strtotime($apenado->datanascimento)) , ['class' => 'form-control', 'readonly']) !!}
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="form-group">
                                {!! Form::label('unidade_idc','Unidade Prisional')  !!}
                                {!! Form::text('unidade_idc', $apenado->nomeunidade, ['class' => 'form-control','id'=>'unidade_idc','readonly']) !!}
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
            <div class="widget-box widget-color-dark">
                <div class="widget-header">
                    <h4 class="widget-title">DOCUMENTOS VIRTUAIS</h4>
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
                                    <th>#</th>
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
                                        <td>{!! $anexo->id !!}</td>
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
                                            <a href="{{route('anexos.destroy', ['id'=>$anexo->id, 'idApen'=>$apenado->id]) }}" type="submit"
                                               onclick="return confirm('Deseja realmente excluir este Anexo?');"
                                               class="btn btn-danger btn-sm"><i class="fa fa-trash"></i> </a></td>

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

                {!!Form::open ( ['route'=>('anexos.gravar'), 'id'=>'formModalAnexar', 'enctype' => 'multipart/form-data']) !!}
                <fieldset>
                    <input type="hidden" name="idapenid" value="{{ $apenado->id }}">
                    <input type="hidden" name="idprocessoid" value="{{ $apenado->idProcesso }}">

                    <div class="col-md-12">
                        <div class="alert alert-info">
                            {!! $apenado->nomeapenado !!}
                        </div>
                    </div>
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


@endsection

@section('scripts')

    {{ HTML::script('resources/assets/js/anexos/script.js') }}

    <script src={{asset('resources/assets/js/jquery.colorbox.js')}}></script>

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