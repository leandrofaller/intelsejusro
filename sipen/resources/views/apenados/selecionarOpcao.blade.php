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
              <a href="{!! route('apenados.index') !!}" class="btn btn-xs btn-light bigger"> <i class="ace-icon fa fa-arrow-left"></i> Voltar </a>
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
        <div class="col-md-9">
            <div class="widget-box widget-color-dark">
                <div class="widget-header">
                    <h4 class="widget-title">DADOS PESSOAIS</h4>
                </div>

                <div class="widget-body">
                    <div class="widget-main no-padding">
                        <fieldset>
                            <div class="col-md-2">
                                <div class="form-group">
                                    {!! Form::label('idApen','Código ')  !!}
                                    {!! Form::text('idApen', $apenado->idApen, ['class' => 'form-control','id'=>'idApen', 'readonly']) !!}
                                </div>
                            </div>

                            <div class="col-md-10">
                                <div class="form-group">
                                    {!! Form::label('nomeapenado','Nome do Apenado')  !!} <label class="red">*</label>
                                    {!! Form::text('nomeapenado', $apenado->nomeapenado, ['class' => 'form-control','id'=>'nomeapenado', 'readonly']) !!}
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    {!! Form::label('alcunha','Alcunha')  !!} <label class="red">*</label><br>
                                    @foreach(\App\Model\Integrantes::mostraAlcunhas($apenado->idApen) as $alcunha)
                                        <span class="label label-info">{{ $alcunha->nome_alcunha }}</span>
                                    @endforeach
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    {!! Form::label('rg','RG do Apenado')  !!}
                                    {!! Form::text('rg', $apenado->rg, ['class' => 'form-control naoValidar','id'=>'rg',  'readonly']) !!}
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    {!! Form::label('cpf','Cpf do Apenado')  !!}
                                    {!! Form::text('cpf', $apenado->cpf, ['class' => 'form-control cpf naoValidar','id'=>'cpf' , 'readonly']) !!}
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    {!! Form::label('datanascimento','Data de Nascimento')  !!} <label class="red">*</label>
                                    {!! Form::text('datanascimento', $apenado->datanascimento ? dataFormat($apenado->datanascimento) : null , ['class' => 'form-control date' , 'readonly']) !!}
                                </div>
                            </div>
                            <!-- /.row -->
                        </fieldset>

                    </div>
                </div>
            </div>

        </div>

        <div class="col-md-3">
            <div class="widget-box widget-color-dark">
                <div class="widget-header">
                    <h4 class="widget-title">FOTO DO APENADO</h4>
                </div>
                        <fieldset>
                            <div class="col-md-12">
                                    <div>
                                        <img class="img-responsive editable-empty" style="height: 150px;" src="{!! asset('public/'.\App\Model\Apenado::mostraFotoPrincipal($apenado->idApen)) !!}"/>
                                    </div>
                            </div>
                        </fieldset>
            </div>
        </div>


    </div>



    <div class="col-xs-12">
        <h3 class="header smaller lighter green">Selecione a Opçao</h3>
        <p></p>
        <a href="{!! route('apenados.editar', $apenado->idApen) !!}" class="btn btn-default btn-app radius-4">
            <i class="ace-icon fa fa-pencil-square bigger-230"></i>
            EDITAR <br> CADASTRO
            {{--<span class="badge badge-pink">+3</span>--}}
        </a>
        <a href="{!! route('apenados.mudarcela', $apenado->idApen) !!}" class="btn btn-light btn-app radius-4">
            <i class="ace-icon fa fa-building-o bigger-230"></i>
            MUDANÇA DE <br> CELAS
        </a>
        <a href="{!! route('apenados.informacoes', $apenado->idApen) !!}" class="btn btn-grey btn-app radius-4">
            <i class="ace-icon fa fa-info-circle bigger-230"></i>
            INFORMAÇÕES <br> ADICIONAIS
        </a>
        <a href="{!! route('anexos.index', $apenado->idApen) !!}" class="btn btn-info btn-app radius-4">
            <i class="ace-icon fa fa-upload bigger-230"></i>
            ANEXAR <br> DOCUMENTOS
        </a>

        <a href="{!! route('apenados.alcunhas', $apenado->idApen) !!}" class="btn btn-warning btn-app radius-4">
            <i class="ace-icon fa fa-comment bigger-230"></i>
            INCLUIR <br> ALCUNHAS
        </a>
        <a href="{!! route('apenados.enderecos', $apenado->idApen) !!}" class="btn btn-purple btn-app radius-4">
            <i class="ace-icon fa fa-cogs bigger-230"></i>
            INCLUIR <br> ENDEREÇOS
        </a>
        <a href="{!! route('apenados.fotos', $apenado->idApen) !!}" class="btn btn-info btn-app radius-4">
            <i class="ace-icon fa fa-photo bigger-230"></i>
            INCLUIR <br> FOTOS
         </a>

        <?php $situacao = \App\Model\Apenado::situacaoAtual($apenado->idApen); ?>

        @if ($situacao == 'Sinistro')
            <h4 class="text-danger"> <i class="fa fa-warning"></i> APENADO FUGITIVO</h4>
        @else


                <a href="{!! route('apenados.registrarSaida', $apenado->idApen) !!}" class="btn btn-success btn-app radius-4">
                    <i class="ace-icon fa fa-ban bigger-230"></i>
                    REGISTRAR <br> SAÍDA
                </a>

                <a href="{!! route('apenados.incluirProcessos', $apenado->idApen) !!}" class="btn btn-warning btn-app radius-4">
                    <i class="ace-icon fa fa-balance-scale bigger-230"></i>
                    ADICIONAR <br> PROCESSOS
                </a>
                <a href="{!! route('pad.mostradados', $apenado->idApen) !!}" class="btn btn-purple btn-app radius-4">
                    <i class="ace-icon fa fa-life-bouy bigger-230"></i>
                   LANÇAR <BR> PAD
                </a>
                <a href="{!! route('medidadisciplinar.mostradados', $apenado->idApen) !!}" class="btn btn-danger btn-app radius-4">
                    <i class="ace-icon fa fa-bomb bigger-230"></i>
                    MEDIDA <BR> DISCIPLINAR
                </a>
                <a href="{!! route('apenados.triagem', $apenado->idApen) !!}" class="btn btn-primary btn-app radius-4">
                    <i class="ace-icon fa fa-slack bigger-230"></i>
                    LANÇAR <BR> TRIAGEM
                </a>
                <a href="{!! route('temporarias.mostradados', $apenado->idApen) !!}" class="btn btn-yellow btn-app radius-4">
                    <i class="ace-icon fa fa-taxi bigger-230"></i>
                    LANÇAR <BR> TEMPORÁRIAS
                </a>

        @endif

        @if(Auth::user()->perfil == 'Admin')
            <a class="btn btn-danger" href="{!! route('apenados.destroyApenado', $apenado->idApen) !!}">
                <i class="ace-icon fa fa-trash align-top bigger-125"></i>
                EXCLUIR
            </a>
        @endif


    </div>






    {{--<div class="col-md-12">--}}
        {{--<h3 class="header smaller lighter red">Periculosidade</h3>--}}
    {{--</div>--}}

    {{--<div class="col-md-12 col-sm-6 widget-container-col ui-sortable" id="widget-container-col-2">--}}
        {{--<div class="widget-box widget-color-blue ui-sortable-handle" id="widget-box-2">--}}
            {{--<div class="widget-header">--}}
                {{--<h5 class="widget-title bigger lighter">--}}
                    {{--<i class="ace-icon fa fa-table"></i>--}}
                    {{--RESUMO--}}
                {{--</h5>--}}
            {{--</div>--}}

            {{--<div class="widget-body">--}}
                {{--<div class="widget-main no-padding">--}}
                    {{--<table class="table table-striped table-bordered table-hover">--}}
                        {{--<thead class="thin-border-bottom">--}}
                            {{--<tr>--}}
                                {{--<th>Informação</th>--}}
                                {{--<th>Qtd</th>--}}
                            {{--</tr>--}}
                        {{--</thead>--}}

                        {{--<tbody>--}}
                            {{--<tr>--}}
                                {{--<td class="">Fuga</td>--}}
                                {{--<td>0</td>--}}
                            {{--</tr>--}}
                            {{--<tr>--}}
                                {{--<td class="">Tentativa de Fuga</td>--}}
                                {{--<td>0</td>--}}
                            {{--</tr>--}}
                            {{--<tr>--}}
                                {{--<td class="">Presídio Federal</td>--}}
                                {{--<td>0</td>--}}
                            {{--</tr>--}}
                       {{--</tbody>--}}
                    {{--</table>--}}
                {{--</div>--}}
            {{--</div>--}}
        {{--</div>--}}
    {{--</div>--}}

@endsection


@section('scripts')

    {{ HTML::script('resources/assets/js/selectGeral.js') }}

    {{ HTML::script('resources/assets/js/datepickerJS/bootstrap-datepicker.min.js') }}
    {{ HTML::script('resources/assets/js/datepickerJS/bootstrap-datepicker.pt-BR.min.js') }}

    {{ HTML::script('resources/assets/js/mask/maskedinput.min.js') }}
    {{ HTML::script('resources/assets/js/validacao/formatainput.js') }}

    {{ HTML::script('resources/assets/js/validacao/validacao.js') }}

@stop



