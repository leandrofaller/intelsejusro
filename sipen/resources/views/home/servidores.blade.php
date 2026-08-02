
<h4 class="widget-title smaller">
    <i class="ace-icon fa fa-puzzle-piece smaller-80"></i>
    Facção Geral
    </h4>
    <hr/>
    
    

    
    
    <div class="row">
    <div class="col-sm-12 ">
        <!-- #section:pages/dashboard.infobox -->
        @foreach($faccoes as $faccoe)
            <div class="infobox infobox-red">
                <div class="infobox-icon"> <i class="ace-icon fa fa-puzzle-piece"></i> </div>
                <div class="infobox-data">
                    <span class="infobox-data-number"> {!! $faccoe->sigla !!} </span>
                    <div class="infobox-content">Total: {!! \App\Model\Integrantes::contaIntegrantes($faccoe->id)[0] !!}</div>
                </div>
            </div>
        @endforeach
    
        <div class="infobox infobox-blue2">
            <div class="infobox-icon"> <i class="ace-icon fa fa-users"></i> </div>
            <div class="infobox-data">
                <span class="infobox-data-number"> {!! empty($totalGeralFaccionados[0]) ? '0' : $totalGeralFaccionados[0] !!}  </span>
                <div class="infobox-content">Total Geral </div>
            </div>
        </div>
    
    </div>
    </div>
    
    
    <div class="col-md-12"></div>
    <hr/>
    
    
    
    <div class="col-md-12"></div>
    
    <hr/>
    
    
    
    <div class="row">
    
    <div class="col-sm-12">
        <div class="widget-box widget-color-blue2">
            <div class="widget-header widget-header-flat">
                <h4 class="widget-title lighter">
                    <i class="ace-icon fa fa-star orange"></i>
                    Resumo por Unidades da Regional
                </h4>
    
                <div class="widget-toolbar">
                    <a href="#" data-action="collapse">
                        <i class="ace-icon fa fa-chevron-up"></i>
                    </a>
                </div>
            </div>
    
            <div class="widget-body">
                <div class="widget-main no-padding">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped" id="myTable">
                            <thead class="thin-border-bottom">
                            <tr>
                                <th>Nome Unidade</th>
                                <th>Cidade</th>
                                <th>Categoria</th>
                                @foreach($faccoes as $fac)
                                    <th>
                                        <span class="bold">
                                        {!! $fac->sigla !!}
                                        </span>
                                    </th>
                                @endforeach
                                <th>QTD Apenados</th>
                                <th>QTD Faccionados</th>
                                <th>% Faccionados</th>
                                <th>Possíveis Faccionados </th>
                                <th>Faccção Predominante</th>
                            </tr>
                            </thead>
    
                            <tbody>
                            @foreach($unidades as $unidade)
                                <?php
                                $totalPreso =  \App\Model\Apenado::contaApenadoUnidade($unidade->id)[0];
                               // $totalPreso =  $unidade->capacidade;
                                $totalFaccionado = \App\Model\Apenado::contaFaccionadosUnidade($unidade->id)[0];
                                $totalPossivel = \App\Model\Apenado::contaPossiveisFaccionadosUnidade($unidade->id)[0];
    
                                if($totalPreso == 0)
                                {
                                    $percFaccionado = 0;
                                }
                                else
                                {
                                    $percFaccionado = (($totalFaccionado / $totalPreso) * 100);
                                }
                                ?>
    
                                <tr>
                                    <td>{!! $unidade->nomeunidade !!}</td>
                                    <td>{!! $unidade->cidadeunidade !!}</td>
                                    <td>{!! $unidade->categoria !!}</td>
                                    @foreach($faccoes as $fac)
                                        <th>
                                        <span class="bold">
                                        {!! \App\Model\Integrantes::contaIntegrantesUnidadePorFaccao($unidade->id, $fac->id)[0] !!}
                                        </span>
                                        </th>
                                    @endforeach
                                    <td class="hidden-480"> <b class="red"> {!! $totalPreso   !!} </b> </td>
                                    <td>
                                                           <span class="label label-sm label-warning">
                                                                {!!  $totalFaccionado  !!}
                                                           </span>
                                    </td>
                                    <td>
                                            <span class="label label-sm label-success">
                                                                {!!  number_format(($percFaccionado),2) !!}%
                                            </span>
                                    </td>
                                    <td>
                                            <span class="label label-sm label-grey">
                                                {!!  $totalPossivel !!}
                                            </span>
                                    </td>
                                    <td>
    
                                            <span class="label label-{!! corPorSiglaFaccaoHelper(\App\Model\Apenado::contaFaccaoPredominante($unidade->id)) !!} arrowed-right arrowed-in">
                                              {!! \App\Model\Apenado::contaFaccaoPredominante($unidade->id) !!}
                                            </span>
                                    </td>
    
                                </tr>
                            @endforeach
    
                            </tbody>
                        </table>
                    </div>
                </div><!-- /.widget-main -->
            </div><!-- /.widget-body -->
        </div><!-- /.widget-box -->
    </div><!-- /.col -->
    
    
    </div>
    
    
    
    <div class="col-md-6"></div>
    <div class="col-md-6"></div>
    <div class="col-md-6"></div>
    <div class="col-md-6"></div>
    
    
    {{--{!! $chartTodasFaccoesUnidades->render() !!}--}}
    
    <div class="col-md-6"></div>
    <div class="col-md-6"></div>
    <div class="col-md-6"></div>
    <div class="col-md-6"></div>
    <br><br>
    
    {{--{!! $chartFaccoes->render() !!}--}}
    
    <div class="col-md-6"></div>
    <div class="col-md-6"></div>
    <div class="col-md-6"></div>
    <div class="col-md-6"></div>
    <br><br>
    {{--{!! $chartFaccoesPossiveis->render() !!}--}}
    
    <div class="col-md-6"></div>
    <div class="col-md-6"></div>
    <div class="col-md-6"></div>
    <div class="col-md-6"></div>
    <br><br>
    
    
    {{--{!! $chartFaccoesUnidades->render() !!}--}}
    
    
    <div class="col-md-6"></div>
    <div class="col-md-6"></div>
    <div class="col-md-6"></div>
    <div class="col-md-6"></div>
    
    
    {{--{!! $chartUnidade->render() !!}--}}
    
    <br>
    <br>
    
    {{--<a href="{!! route('listagem.exportarBaseTodos', 'geral' ) !!}" title="GERAR EXCEL" class="btn btn-danger btn-block">--}}
    {{--<i class="ace-icon fa fa-file-excel-o"></i> EXPORTAR BASE GERAL PARA MIGRAÇÃO INFOPEN - ES--}}
    {{--</a>--}}
    
    <br>
    <hr/>
            {{--{!! $chart->render() !!}--}}
    
    @section('scripts')
    
    {{--{{ HTML::script('js/dataTables/jquery.dataTables.bootstrap.js') }}--}}
    {{ HTML::script('resources/assets/js/dataTables/jquery.dataTables.js') }}
    
    <script>
        $(document).ready(function () {
            $('#myTable').DataTable({
                "paging":   false,
                "info":     false,
                "bFilter": false
    
            });
        });
    </script>
    
    @stop