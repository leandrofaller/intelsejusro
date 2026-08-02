@extends('layouts.template')

@section('titulo', 'SRDA')

@section('conteudo')

    @include('flash.message')

    <?php
        use Cornford\Googlmapper\Facades\MapperFacade;
    ?>

    <!--
https://github.com/bradcornford/Googlmapper
    -->

    <!-- /section:settings.box -->
    <div class="page-header">
        <h1>
            MAPA
        </h1>
    </div><!-- /.page-header -->

    <!-- /.row -->
    <div class="row">
        <div class="col-xs-12">
            <div class="widget-header widget-header-large">
                <h3 class="widget-title grey lighter">
                    <i class="ace-icon fa fa-street-view"></i>
                   Unidades Prisionais Cadastradas
                </h3>

                <!-- #section:pages/invoice.info -->
                <div class="widget-toolbar no-border invoice-info">
                    <span class="invoice-info-label">Total:</span>
                    <span class="red"> {{ count($collection)  }}</span>

                    <br>
                    <span class="invoice-info-label">Data:</span>
                    <span class="blue">{{ date('d/m/Y')  }}</span>
                </div>


                <!-- /section:pages/invoice.info -->
            </div>


            <div style="height: 600px; width: 100%;">{!! Mapper::render() !!}</div>

        </div>
    </div>


@endsection

