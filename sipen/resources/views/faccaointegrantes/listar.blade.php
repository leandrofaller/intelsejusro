@extends('layouts.template')

@section('conteudo')
<?php
use App\Model\Apenado;
use App\Model\Integrantes;
?>

    <div class="page-header">
        <h1>
            {{ $titulo }}
            <small>
                <i class="ace-icon fa fa-angle-double-right"></i>
                {{ $subtitulo }}
            </small>

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


        <!-- /.row -->
        <div class="row">
            <div class="col-md-12">
                <div  style="width: 350px;">
                    {!!Form::open ( ['route'=>'faccaointegrantes.listar','method' => 'GET','id'=>'formulario'] ) !!}
                            {!! Form::Text('parametro',null, ['class' => 'form-control pull-right','maxlength'=> 100,'placeholder' => 'Pesquise por Nome/Cpf ou Alcunha ','id'=>'parametro']) !!}
                    {!! Form::close() !!}
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="table-responsive">
                   <table id="simple-table" class="table table-striped table-bordered table-hover">
                        <thead>
                            <tr class="">
                                <th>#</th>
                                <td>NOME DO APENADO</td>
                                <td>UNIDADE PRISIONAL ATUAL</td>
                                <td>SITUAÇÃO</td>
                                <td>CLASSIFICAÇÃO</td>
                                <td><b><span data-rel="popover" data-trigger="hover" data-content="Informa qual facção predomina na carceragem." data-original-title="CELA"> CELA <i class="fa fa-info-circle"></i></b>  </span> </td>
                                <td><b><span data-rel="popover" data-trigger="hover" data-content="Facção Atual do Apenado" title="" data-original-title="FACÇÃO" > FACÇÃO  <i class="fa fa-info-circle"></i>  </span>  </b> </td>
                                <td><b><span data-rel="popover" data-trigger="hover" data-content="Atenção para a mensagem informada pelo sistema" title="" data-original-title="ALERTA" > ALERTA <i class="fa fa-info-circle"></i>  </span>  </b> </td>
                                <td></td>
                            </tr>
                            </thead>
                            <tbody>    
                            @forelse($apenados as $apenado)
                                <?php
                                $status = \App\Model\Apenado::situacaoAtual($apenado->idApen);
                                if($status == 'Apenado Preso'){
                                    $legenda = "<span class=\"label label-grey arrowed\">Apenado Preso</span>";
                                }elseif($status == 'Aguardando Recebimento da Unidade'){
                                    $legenda = "<span class=\"label label-warning arrowed\">Aguardando Recebimento da Unidade</span>";
                                }elseif($status == 'Sinistro'){
                                    $legenda1 = \App\Model\Apenado::mostraSinistro($apenado->idApen);
                                    $legenda = "<span class=\"label label-danger arrowed\"> $legenda1 </span>";

                                }else{
                                    $legenda2 = tiposaida($status);
                                    if(($status == 4) or ($status == 5) or ($status == 6)){
                                        $legenda = "<span class=\"label label-success arrowed\"> $legenda2 </span>";
                                    }else{
                                        $legenda = "<span class=\"label label-purple arrowed\"> $legenda2 </span>";
                                    }
                                }
                                ?>
                                <tr>
                                    <td data-id={!! $apenado->idIntegrante !!}>{!! $apenado->idIntegrante !!}</td>
                                    <td class="hidden" data-apenado_id="{{$apenado->idApen}}"> {!! $apenado->idApen !!}</td>
                                    <td class="col-md-4" data-nomeapenado="{!! $apenado->nomeapenado !!}" >{!! $apenado->nomeapenado !!}</td>
                                    <td class="col-md-3">{!! \App\Model\Apenado::mostraunidadeAtual($apenado->idApen) !!}</td>
                                    <td>{!! $legenda !!} </td>
                                    <td>{!! \App\Model\FaccaoPossiveis::nomepossivel($apenado->faccao_possiveis_id) !!} </td>

                                    <td>{!! \App\Model\Apenado::mostracelaAtual($apenado->idApen) !!}
                                        <?php
                                            $faccaoSiglaCarceragem = \App\Model\Apenado::mostraFaccaoCarceragem($apenado->idApen);
                                            $corFaccao = \App\Model\Faccao::mostraCorFaccao($faccaoSiglaCarceragem);
                                        ?>
                                        @if($faccaoSiglaCarceragem)
                                            <span  class="text-center" style="color: {!! $corFaccao == '' ? '' : $corFaccao !!};"   >
                                                <i class="fa fa-circle fa-1x"> {!! $faccaoSiglaCarceragem !!} </i>
                                            </span>
                                        @endif
                                    </td>

                                    <td data-sigla="{!! $apenado->sigla !!}"><span class="text-center" style="color: {!! $apenado->cor !!};"> <i class="fa fa-circle fa-1x"></i> {!! $apenado->sigla !!}  </span></td>

                                    <td >
                                        @if( ($faccaoSiglaCarceragem != $apenado->sigla) and ($faccaoSiglaCarceragem) )
                                            <span  data-rel="tooltip" data-trigger="hover" style="color: black;" data-original-title="Apenado está em Local que não pertence ao seu grupo."  ><i class="fa fa-circle fa-3x"></i> </span>
                                        @elseif(($faccaoSiglaCarceragem == $apenado->sigla) and $faccaoSiglaCarceragem)
                                            <span data-rel="tooltip" data-trigger="hover" style="color: green;"  data-original-title="Grupo Correto.."><i class="fa fa-circle fa-3x"></i> </span>
                                        @else
                                            <span data-rel="tooltip" data-trigger="hover" style="color: #FFA24D;"  data-original-title="Atenção, é necessário uma avaliação. !!!" ><i class="fa fa-circle fa-3x"></i> </span>
                                        @endif
                                    </td>

                                    <td class="col-md-2">
                                        <div class="btn-group">
                                            @if(Auth::user()->perfil != 'Externo')
                                            <a href="{{ route('faccaointegrantes.incluirDados', $apenado->idApen) }}" class="btn btn-xs btn-info" title="Editar Dados de Faccionado" > <i class="ace-icon fa fa-edit
 bigger-120"></i> </a>
                                            <a href="{{ route('faccaointegrantes.anexos', $apenado->idApen) }}" class="btn btn-xs btn-success" title="Anexar Documentos / Informações Adicionais" > <i class="ace-icon fa fa-paperclip
 bigger-120"></i> | <i class="ace-icon fa fa-info-circle bigger-120"></i> </a>
                                            <a href="#" id="btnCancelar" name="btnCancelar" class="btn btn-xs btn-danger" title="Retirada " > <i class="ace-icon fa fa-times bigger-120"></i> </a>
                                            <a href="#" class="btn btn-xs btn-default " id="btnFichaFaccionado" name="btnFichFaccionadoa" title="Ficha Completa do Faccionado" > <i class="ace-icon fa fa-newspaper-o bigger-120"></i> </a>
                                            @else
                                            <a href="#" class="btn btn-xs btn-default " id="btnFichaFaccionado" name="btnFichFaccionadoa" title="Ficha Completa do Faccionado" > <i class="ace-icon fa fa-newspaper-o bigger-120"></i> </a>
                                            @endif
                                        </div>

                                    </td>

                                </tr>

                            @empty
                                <tr>
                                    <td colspan="12">
                                        <div class="well text-center ">
                                            <h2 class="text-danger"> <i class="fa fa-warning"></i> Nenhum Registro Encontrado!</h2>
                                        </div>
                                </tr>
                            @endforelse

                            </tbody>
                   </table>
                    {!! $apenados->render() !!}
                </div>
                <!-- /.box -->
            </div>
        </div>


@include('suportes.modalfichaFaccionado')



<div class="modal fade" id="myModalCancelar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-lg " role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">DESVINCULAR APENADO DE FACÇÃO</h4>
            </div>
            {!! Form::open(['route'=>['faccaointegrantes.cancelar'], 'id'=>'formModalCancelar' ]) !!}
            <div class="modal-body" id="modalbody">
                Informações Pessoais
                <div class="widget-box widget-color-dark ">

                    <div class="widget-body">
                        <div class="widget-main no-padding">
                            <fieldset>
                                <div class="col-md-9">
                                    <div class="form-group">
                                        {!! Form::label('nomeapenado','Nome do Apenado')  !!}
                                        {{ Form::text('nomeapenado', null, ['id'=>'nomeapenado', 'class' => 'form-control', 'readonly']) }}
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        {!! Form::label('sigla', 'Facção')  !!}
                                        {{ Form::text('sigla', null, ['id'=>'sigla','class' => 'form-control', 'readonly']) }}
                                    </div>
                                </div>

                                <hr>

                            </fieldset>
                        </div>
                    </div>
                </div>
                Informações do Cancelamento
                <div class="widget-box widget-color-dark ">

                    <div class="widget-body">
                        <div class="widget-main no-padding">
                            <fieldset>
                                <input type="hidden" id="id" name="id" value="">
                                <input type="hidden" name="apenado_id" id="apenado_id"  value="">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        {!! Form::label('datasaida','Data de Saída')  !!}
                                        {{ Form::text('datasaida', null, ['id'=>'datasaida', 'class' => 'form-control date']) }}
                                    </div>
                                </div>
                                <div class="col-md-9">
                                    <div class="form-group">
                                        {!! Form::label('motivosaidafaccao', 'Motivo da Saída')  !!}
                                        {{ Form::text('motivosaidafaccao', null, ['id'=>'motivo','class' => 'form-control naoValidar' ]) }}
                                    </div>
                                </div>
                                <hr>
                            </fieldset>
                        </div>
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button class="btn btn-danger" id="btnModalCancelar" type="submit"> SALVAR</button>
            </div>
            {{ Form::close() }}
        </div>
    </div>
</div>



@endsection


@section('scripts')


    <script>
        $(document).ready(function(){
            $('[data-toggle="tooltip"]').tooltip();
        });
    </script>


    {{ HTML::script('resources/assets/js/faccao/script.js') }}
    {{ HTML::script('resources/assets/js/ficha/script.js') }}

    {{ HTML::script('resources/assets/js/datepickerJS/bootstrap-datepicker.min.js') }}
    {{ HTML::script('resources/assets/js/datepickerJS/bootstrap-datepicker.pt-BR.min.js') }}

    {{ HTML::script('resources/assets/js/mask/maskedinput.min.js') }}
    {{ HTML::script('resources/assets/js/validacao/formatainput.js') }}

@stop