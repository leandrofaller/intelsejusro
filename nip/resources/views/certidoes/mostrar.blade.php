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
              <a href="{!! route('certidoes.listar' ) !!}" class="btn btn-xs btn-light bigger"> <i class="ace-icon fa fa-arrow-left"></i> Voltar </a>
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
                    <h4 class="widget-title">INFORMAÇÕES DA CERTIDÃO</h4>
                </div>

                <div class="widget-body">
                    <div class="widget-main no-padding">
                        <fieldset>

                            <div class="col-md-12">
                                <!-- PAGE CONTENT BEGINS -->
                                <div class="center">
                                    <h1> {!! $certidao->chavevalidacao !!} </h1>
                                </div>

                                <div class="hr dotted"></div>

                                <div class="">
                                    <div id="user-profile-1" class="user-profile row">
                                        <div class="col-xs-12 col-sm-3 center">
                                            <div>
												<span class="profile-picture">
													<img id="avatar" class="editable img-responsive editable-click editable-empty" alt="" src="{!! asset($certidao->foto) !!}">
												</span>
                                            </div>
                                        </div>

                                        <div class="col-md-9">

                                            {!! $certidao->texto !!}
                                            <div class="profile-user-info profile-user-info-striped">
                                                <div class="profile-info-row">
                                                    <div class="profile-info-name"> Código Apenado </div>
                                                    <div class="profile-info-value">
                                                        {!! $certidao->codigoapenado !!}
                                                    </div>
                                                </div>

                                                <div class="profile-info-row">
                                                    <div class="profile-info-name"> Nome </div>
                                                    <div class="profile-info-value">
                                                        {!! $certidao->nome !!}
                                                    </div>
                                                </div>
                                                <div class="profile-info-row">
                                                    <div class="profile-info-name"> Execução </div>
                                                    <div class="profile-info-value">
                                                        {!! $certidao->execucao !!}
                                                    </div>
                                                </div>

                                                <div class="profile-info-row">
                                                    <div class="profile-info-name"> Filiação </div>
                                                    <div class="profile-info-value">
                                                        <span>  {!! $certidao->mae !!}</span>
                                                        <span>  {!! $certidao->pai !!}</span>
                                                    </div>
                                                </div>

                                                <div class="profile-info-row">
                                                    <div class="profile-info-name"> Nascimento </div>
                                                    <div class="profile-info-value">
                                                        <span>{!! dataFormat($certidao->nascimento) !!}</span>
                                                    </div>
                                                </div>

                                                <div class="profile-info-row">
                                                    <div class="profile-info-name"> Endereço </div>
                                                    <div class="profile-info-value">
                                                        <span>{!! $certidao->endereco !!} </span>
                                                    </div>
                                                </div>

                                                <div class="profile-info-row">
                                                    <div class="profile-info-name"> Documentos </div>
                                                    <div class="profile-info-value">
                                                        <span> RG: {!! $certidao->rg !!} </span>
                                                        <span> CPF: {!! $certidao->cpf !!} </span>
                                                    </div>
                                                </div>

                                                <div class="profile-info-row">
                                                    <div class="profile-info-name"> Regime </div>
                                                    <div class="profile-info-value">
                                                        <span>{!! $certidao->regime !!}</span>
                                                    </div>
                                                </div>

                                                <div class="profile-info-row">
                                                    <div class="profile-info-name"> Tipo Certidão </div>
                                                    <div class="profile-info-value">
                                                        <span>{!! $certidao->tipocertidao !!}</span>
                                                    </div>
                                                </div>

                                                <div class="profile-info-row">
                                                    <div class="profile-info-name"> Unidade Prisional </div>
                                                    <div class="profile-info-value">
                                                        <span>{!!  \App\Model\Unidade::mostraNomeUnidade($certidao->unidade_id) !!} </span>
                                                    </div>
                                                </div>

                                                <div class="profile-info-row">
                                                    <div class="profile-info-name"> Entrada / Saída </div>
                                                    <div class="profile-info-value">
                                                        <span>Entrada: {!! dataFormat($certidao->dataentrada) !!}
                                                            {!! $certidao->datasaida ? ' Saída: '. dataFormat($certidao->datasaida) : '' !!}
                                                        </span>
                                                    </div>
                                                </div>

                                                <div class="profile-info-row">
                                                    <div class="profile-info-name"> Comportamento </div>
                                                    <div class="profile-info-value">
                                                        <span>{!! $certidao->comportamento !!}</span>
                                                    </div>
                                                </div>
                                                <div class="profile-info-row">
                                                    <div class="profile-info-name"> Comarca </div>
                                                    <div class="profile-info-value">
                                                        <span>{!! $certidao->comarca !!}</span>
                                                    </div>
                                                </div>

                                                <div class="profile-info-row">
                                                    <div class="profile-info-name"> Solicitante </div>
                                                    <div class="profile-info-value">
                                                        <span>{!! $certidao->solicitante !!}</span>
                                                    </div>
                                                </div>

                                            </div>


                                            <div class="widget-box transparent">
                                                <div class="widget-header widget-header-small">
                                                    <h4 class="widget-title blue smaller">
                                                        <i class="ace-icon fa fa-rss orange"></i>
                                                        Dados da Certidão
                                                    </h4>


                                                </div>

                                                <div class="widget-body">
                                                    <div class="widget-main padding-8">
                                                        <div id="profile-feed-1" class="profile-feed ace-scroll" style="position: relative;">
                                                            <div class="scroll-track scroll-active" style="display: block; height: 200px;">
                                                            </div>
                                                            <div class="" style="">
                                                            <div class="profile-activity clearfix">
                                                                    <div>
                                                                        <div class="time">
                                                                            <span>{!! $certidao->relatorios ? $certidao->relatorios : '' !!}</span>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="time">
                                                                    <span>Data do Processamento {!! dataFormat($certidao->created_at, true) !!}</span>
                                                                </div>
                                                                <div class="time">
                                                                    <span>Servidor : {!! \App\Model\User::NomeServidor($certidao->user_id) !!}</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="hr hr2 hr-double"></div>

                                            <div class="space-6"></div>


                                        </div>
                                    </div>
                                </div>





                                <!-- PAGE CONTENT ENDS -->
                            </div>

                        </fieldset>
                    </div>
                </div>
            </div>
        </div>





@endsection

@section('scripts')


@stop