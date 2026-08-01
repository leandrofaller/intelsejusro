<h4 class="widget-title smaller">
    <i class="ace-icon fa fa-puzzle-piece smaller-80"></i>
    Resumo da População Carcerária da Unidade
</h4>
<hr/>
<div class="row">
    <div class="col-md-12">


        <!-- #section:pages/dashboard.infobox -->
        @foreach($carceragens as $carc)
            <a href="{{route('listagem.carceragem',$carc->id)}}">
                <div class="infobox infobox-green2 ">
                    <div class="infobox-icon"> <i class="ace-icon fa fa-user"></i> </div>
                    <div class="infobox-data ">
                        <span class="infobox-data-number"> {!! \App\Model\Unidade::contaPresosCarceragem($carc->id) !!} </span>
                        <div class="infobox-content"> {!! $carc->nomecarceragem !!}</div>
                    </div>
                </div>
            </a>
        @endforeach
        <a href="">
        <a href="{!! route('listagem.recebimento')!!}">
            <div class="infobox infobox-orange">
                <div class="infobox-icon"> <i class="ace-icon fa fa-arrow-circle-right"></i> </div>
                <div class="infobox-data">
                    <span class="infobox-data-number"> {!! count($recebimento) !!}  </span>
                    <div class="infobox-content">Aguardando Recebimento </div>
                </div>
            </div>
        <a/>

        <a href="{{route('listagem.geral')}}">
            <div class="infobox infobox-blue2">
                    <div class="infobox-icon"> <i class="ace-icon fa fa-users"></i> </div>
                    <div class="infobox-data">
                        <span class="infobox-data-number"> {!! $totalGeral[0] !!}  </span>
                        <div class="infobox-content">Total Geral </div>
                    </div>
            </div>
        </a>

            <div class="col-md-12"></div>
            <div class="hr hr8 hr-double"></div>
            <a href="{{route('listagem.fugitivos')}}">
                <div class="infobox infobox-red">
                    <div class="infobox-icon"> <i class="ace-icon fa fa-bomb"></i> </div>
                    <div class="infobox-data">
                        <span class="infobox-data-number"> {!! count($fugas) !!}  </span>
                        <div class="infobox-content">Fugas </div>
                    </div>
                </div>
            </a>

            <a href="{{route('listagem.triagem')}}">
                <div class="infobox infobox-blue3">
                    <div class="infobox-icon"> <i class="ace-icon fa fa-slack"></i> </div>
                    <div class="infobox-data">
                        <span class="infobox-data-number"> {!! $totalTriagem !!}  </span>
                        <div class="infobox-content">Triagem </div>
                    </div>
                </div>
            </a>

            <a href="{{route('listagem.transito')}}">
                <div class="infobox infobox-green">
                    <div class="infobox-icon"> <i class="ace-icon fa fa-ambulance"></i> </div>
                    <div class="infobox-data">
                        <span class="infobox-data-number"> {!! $totalTransito !!} </span>
                        <div class="infobox-content">Presos em Trânsito </div>
                    </div>
                </div>
            </a>

            <div class="col-md-12"></div>
            <div class="hr hr8 hr-double"></div>


            <a href="{!! route('listagem.temporarias', 01) !!}">
                <div class="infobox infobox-black">
                    <div class="infobox-icon"> <i class="ace-icon fa fa-taxi"></i> </div>
                    <div class="infobox-data">
                        <span class="infobox-data-number"> {!! $totalPermissaoSaida !!} </span>
                        <div class="infobox-content">Permissão de Saída </div>
                    </div>
                </div>
            </a>

            <a href="{!! route('listagem.temporarias', 02) !!}">
                <div class="infobox infobox-black">
                    <div class="infobox-icon"> <i class="ace-icon fa fa-taxi"></i> </div>
                    <div class="infobox-data">
                        <span class="infobox-data-number"> {!! $totalSaidaTemporaria !!} </span>
                        <div class="infobox-content">Saída Temporária</div>
                    </div>
                </div>
            </a>

            <div class="col-md-12"></div>
            <div class="hr hr8 hr-double"></div>


            <div class="col-md-6">
                <div class="widget-box">
                    <div class="widget-header widget-header-flat widget-header-small">
                        <h5 class="widget-title">
                            <i class="ace-icon fa fa-fire"></i>
                            <b>MEDIDAS DISCIPLINAR DA UNIDADE</b>
                        </h5>
                        <a href="{!! route('listagem.medidadisciplinar', '01') !!}" class="btn btn-minier btn-info pull-right">Visualizar</a>
                    </div>

                    <div class="widget-body">
                        <div class="widget-main">
                            <!-- #section:plugins/charts.flotchart -->
                            <div id="piechart-placeholder"></div>
                            <!-- /section:plugins/charts.flotchart -->
                            <div class="hr hr8 hr-double"></div>
                            <div class="clearfix">
                                <!-- #section:custom/extra.grid -->
                                <div class="grid3">
                                        <span class="grey">
                                        <i class="ace-icon fa fa-sun-o fa-2x blue"></i>
                                        &nbsp; Total Geral
                                        </span>
                                    <h4 class="bigger pull-right">{!! $medidadisciplinar[0] !!}</h4>
                                </div>

                                <div class="grid3">
                                        <span class="grey">
                                        <i class="ace-icon fa fa-thumbs-up fa-2x purple"></i>
                                        &nbsp; Vence Hoje
                                        </span>
                                    <h4 class="bigger pull-right">
                                        {!! \App\Model\MedidaDisciplinar::contaMDUnidVenceHoje(date('Y-m-d')) !!}
                                    </h4>
                                </div>

                                <div class="grid3">
                                        <span class="grey">
                                        <i class="ace-icon fa fa-thumbs-down fa-2x red"></i>
                                        &nbsp; Vencidos
                                        </span>
                                    <h4 class="bigger pull-right">
                                        {!! \App\Model\MedidaDisciplinar::contaMDUnidVencido(date('Y-m-d')) !!}
                                    </h4>
                                </div>
                                <!-- /section:custom/extra.grid -->
                            </div>
                        </div><!-- /.widget-main -->
                    </div><!-- /.widget-body -->
                </div><!-- /.widget-box -->
            </div>




            <div class="col-md-6">
                <div class="widget-box">
                    <div class="widget-header widget-header-flat widget-header-small">
                        <h5 class="widget-title">
                            <i class="ace-icon fa fa-fire"></i>
                            Medida Disciplinar recebidos de <b>OUTRAS UNIDADES</b>
                        </h5>
                        <a href="{!! route('listagem.medidadisciplinar', '02') !!}" class="btn btn-minier btn-info pull-right">Visualizar</a>

                    </div>

                    <div class="widget-body">
                        <div class="widget-main">
                            <!-- #section:plugins/charts.flotchart -->
                            <div id="piechart-placeholder"></div>
                            <!-- /section:plugins/charts.flotchart -->
                            <div class="hr hr8 hr-double"></div>
                            <div class="clearfix">
                                <!-- #section:custom/extra.grid -->
                                <div class="grid3">
                                        <span class="grey">
                                        <i class="ace-icon fa fa-sun-o fa-2x blue"></i>
                                        &nbsp; Total Geral
                                        </span>
                                    <h4 class="bigger pull-right">{!! $outrasunidades[0] !!}</h4>
                                </div>

                                <div class="grid3">
                                        <span class="grey">
                                        <i class="ace-icon fa fa-thumbs-up fa-2x purple"></i>
                                        &nbsp; Vence Hoje
                                        </span>
                                    <h4 class="bigger pull-right">
                                        {!! \App\Model\MedidaDisciplinar::contaMDUnidVenceHojeOutras(date('Y-m-d')) !!}

                                    </h4>
                                </div>

                                <div class="grid3">
                                        <span class="grey">
                                        <i class="ace-icon fa fa-thumbs-down fa-2x red"></i>
                                        &nbsp; Vencidos
                                        </span>
                                    <h4 class="bigger pull-right">
                                        {!! \App\Model\MedidaDisciplinar::contaMDUnidVencidoOutras(date('Y-m-d')) !!}
                                    </h4>
                                </div>
                                <!-- /section:custom/extra.grid -->
                            </div>
                        </div><!-- /.widget-main -->
                    </div><!-- /.widget-body -->
                </div><!-- /.widget-box -->
            </div>


    </div>
</div>
