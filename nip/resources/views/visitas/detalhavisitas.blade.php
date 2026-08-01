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
              <a href="{!! route('visitas.listarvisitantes' ) !!}" class="btn btn-xs btn-light bigger"> <i class="ace-icon fa fa-arrow-left"></i> Voltar </a>
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


    <div class="page-header">
        <h1>
          <i class="fa fa-cloud"></i>  Informações da (o) Visitante
        </h1>
    </div>



    <div class="row">

        <div class="col-md-12">
                <div class="well">
            <div id="user-profile-1" class="user-profile row">
                    <div class="col-xs-12 col-sm-3 col-md-3 center">
                            <span class="profile-picture">
                                 @if($visita->fotovisita != 'N')
                                        <img class="img-responsive editable-empty" style="height: 200px;" src="{!! asset($visita->fotovisita) !!}"/>
                                    @endif
                            </span>

                        <div class="space-6"></div>

                        <!-- #section:pages/profile.contact -->
                        <div class="profile-contact-info">
                            <div class="profile-contact-links align-left">

                            </div>
                        </div>
                        <div class="hr hr16 dotted"></div>

                    </div>

                    <div class="col-xs-12 col-sm-9 col-md-9">

                        <!-- #section:pages/profile.info -->
                        <div class="profile-user-info profile-user-info-striped">
                            <div class="profile-info-row">
                                <div class="profile-info-name"> Código </div>
                                <div class="profile-info-value">{!! $visita->idVisita !!}</div>
                            </div>
                            <div class="profile-info-row">
                                <div class="profile-info-name"> Nome da Visitante </div>
                                <div class="profile-info-value">{!! $visita->nomevisita !!}</div>
                            </div>
                            <div class="profile-info-row">
                                <div class="profile-info-name"> Cpf </div>
                                <div class="profile-info-value">{!! $visita->cpfvisita !!}</div>
                            </div>
                            <div class="profile-info-row">
                                <div class="profile-info-name"> Rg </div>
                                <div class="profile-info-value">{!! $visita->rgvisita !!}</div>
                            </div>
                            <div class="profile-info-row">
                                <div class="profile-info-name"> Data Nascimento </div>
                                <div class="profile-info-value">{!! strftime('%d/%m/%Y',strtotime($visita->datanascimentovisita)) !!}</div>
                            </div>
                            <div class="profile-info-row">
                                <div class="profile-info-name"> Endereço </div>
                                <div class="profile-info-value">
                                    <i class="fa fa-map-marker light-orange bigger-110"></i>
                                    {!! $visita->enderecovisita !!}
                                </div>
                            </div>
                            <div class="profile-info-row">
                                <div class="profile-info-name"> Localidade </div>
                                <div class="profile-info-value"> {!! $visita->cidadevisita !!} - {!! $visita->ufvisita !!}</div>
                            </div>
                            <div class="profile-info-row">
                                <div class="profile-info-name"> Telefone de Contato </div>
                                <div class="profile-info-value">{!! $visita->telefonecontato !!}</div>
                            </div>
                            <div class="profile-info-row">
                                <div class="profile-info-name"> Data Carteirinha </div>
                                <div class="profile-info-value">{!! strftime('%d/%m/%Y',strtotime($visita->dataemicaocarteirinha)) !!}</div>
                            </div>

                        </div>

                    </div>
            </div>
                </div>


            <div class="page-header">
                <h1>
                    <i class="fa fa-users"></i>
                   Apenados Visitados
                </h1>
            </div>

            <div class="table-responsive">
                @forelse($apenados as $apenado)
                <table id="simple-table" class="table table-striped table-bordered table-hover">
                    <thead>
                    <tr>
                        <td style="width: 220px;">
                             <span class="">
                                <div>
                                    <img class="img-responsive editable-empty" style="height: 250px;" src="{!! asset($apenado->foto) !!}"/>
                                </div>
                            </span>
                            {{--<div class="hr hr16 dotted"></div>--}}
                            {{--<div class="profile-contact-info">--}}
                                {{--<div class="profile-contact-links align-left">--}}
                                    {{--<span class="label label-danger arrowed">INFORMAR SE O PRESO PERTENCE A ALGUMA FACÇÃO</span>--}}
                                {{--</div>--}}
                            {{--</div>--}}
                            <div class="hr hr16 dotted"></div>
                            <div class="profile-contact-info">
                                <div class="profile-contact-links align-left">
                                    Situação da Visita:
                                    @if($apenado->datacancelamento == null)
                                        <span class="label label-success arrowed">ATIVA</span>
                                        @else
                                        <span class="label label-danger arrowed">CANCELADA</span>
                                    @endif
                                </div>
                            </div>
                            </td>

                            <td>
                                <dl>
                                    <h4>Informações do Apenado</h4>
                                    <div class="hr hr16 dotted"></div>
                                    <dt>Nome Apenado<dd>{!! $apenado->nomeapenado !!}</dd> </dt>
                                    <dt>Alcunha<dd>{!! $apenado->alcunha !!}</dd> </dt>
                                    <dt>Cpf <dd>{!! $apenado->rg !!}</dd> </dt>
                                    <dt>Data Nascimento <dd>{!! strftime('%d/%m/%Y',strtotime($apenado->datanascimento)) !!}</dd> </dt>
                                    <div class="hr hr16 dotted"></div>
                                    <dt>Grau Parentesco Visita <dd>{!! $apenado->parentescovisita !!}</dd> </dt>
                                </dl>
                            </td>

                            <td>
                                <dl>
                                    <h4>Informação Prisional</h4>
                                    <div class="hr hr16 dotted"></div>
                                    <dt>Unidade Prisional<dd>{!! $apenado->nomeunidade !!}</dd> </dt>
                                    <dt>Cela<dd>{!! $apenado->nomecela !!}</dd> </dt>
                                    <dt>Processo <dd>{!! $apenado->numeroprocesso !!}</dd> </dt>
                                    <dt>Artigos <dd>{!! $apenado->artigos !!}</dd> </dt>
                                    <dt>Tempo de Pena<dd>{!! $apenado->tempodepena !!}</dd> </dt>
                                </dl>
                            </td>
                    </tr>
                    </thead>
                </table>

                @empty
                    <tr>
                        <td colspan="12">
                            <div class="well text-center ">
                                <h2 class="text-danger"> <i class="fa fa-warning"></i> Nenhum Registro Encontrado!</h2>
                            </div>
                    </tr>
                @endforelse
            </div>




        </div>
    </div>


@endsection

@section('scripts')


    {{ HTML::script('js/datepickerJS/bootstrap-datepicker.min.js') }}
    {{ HTML::script('js/datepickerJS/bootstrap-datepicker.pt-BR.min.js') }}

    {{ HTML::script('js/mask/maskedinput.min.js') }}
    {{ HTML::script('js/validacao/formatainput.js') }}

@stop