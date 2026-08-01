@extends('layouts.template')

@section('titulo', 'SRDA')

@section('conteudo')
    {{ HTML::style('resources/assets/css/ficha-print.css') }}
    <div class="page-header">
        <h1>
            {{ $titulo }}
            <small>
                <i class="ace-icon fa fa-angle-double-right"></i>
                {{ $subtitulo }} - <?php echo date('d/m/Y');?>
            </small>
            <span class="pull-right">
              <a href="{!! route('home') !!}" class="btn btn-xs btn-light bigger"> <i class="ace-icon fa fa-arrow-left"></i> Voltar </a>
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

@foreach($carceragens as $carc)
    <div class="col-xs-2 col-sm-2 widget-container-col ui-sortable">
        <div class="widget-box widget-color-blue ui-sortable-handle">
            <!-- #section:custom/widget-box.options -->
            <div class="widget-header">
                <h5 class="widget-title bigger lighter">
                    <i class="ace-icon fa fa-table"></i>
                    {!! $carc->nomecarceragem !!}
                </h5>
            </div>

            <!-- /section:custom/widget-box.options -->
            <div class="widget-body">
                <div class="widget-main no-padding">

                    <table class="table table-striped table-bordered">
                        <thead>
                        <tr>
                            <td>CELA/ALA </td>
                            <td>Qtd</td>
                        </tr>
                        </thead>

                        <tbody>
                        <?php $totalPav = 0; ?>

                        @foreach($celas as $cela)
                            @if($carc->id == $cela->carceragem_id)
                            <tr>
                                <td class="">{!! $cela->nomecela !!}</td>
                                <td>
                                    {!! \App\Model\Apenado::contaApenadoCela($cela->id)[0] !!}
                                </td>
                            </tr>
                            <?php $totalPav = $totalPav + \App\Model\Apenado::contaApenadoCela($cela->id)[0]; ?>
                           @endif

                        @endforeach
                        <tr>
                            <td class="">Total </td>
                            <td class="bg-primary">
                               {!! $totalPav !!}
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endforeach



        <div class="col-xs-2 col-sm-2 widget-container-col ui-sortable">
            <div class="widget-box widget-color-dark ui-sortable-handle">
                <!-- #section:custom/widget-box.options -->
                <div class="widget-header">
                    <h5 class="widget-title bigger lighter">
                        <i class="ace-icon fa fa-table"></i>
                            RESUMO GERAL
                    </h5>
                </div>

                <!-- /section:custom/widget-box.options -->
                <div class="widget-body">
                    <div class="widget-main no-padding">

                        <table class="table table-striped table-bordered">
                            <thead>
                            <tr>
                                <td>CELA/ALA </td>
                                <td>Qtd</td>
                            </tr>
                            </thead>

                            <tbody>
                            <?php $total = 0; ?>
                            @foreach($carceragens as $carc)
                                    <tr>
                                        <td class="">{!! $carc->nomecarceragem !!}</td>
                                        <td>
                                            {!! \App\Model\Unidade::contaPresosCarceragem($carc->id) !!}
                                        </td>
                                    </tr>
                                <?php $total = $total + \App\Model\Unidade::contaPresosCarceragem($carc->id); ?>
                            @endforeach
                            <tr>
                                <td class="bg-primary">Total Geral</td>
                                <td class="bg-primary">
                                    {!! $total !!}
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>




@endsection

