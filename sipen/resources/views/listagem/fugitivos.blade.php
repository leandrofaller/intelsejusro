@extends('layouts.template')

@section('titulo', 'SRDA')

@section('conteudo')
    {{ HTML::style('resources/assets/css/ficha-print.css') }}
    <div class="page-header">
        <h1>
            {{ $titulo }}
            <small>
                <i class="ace-icon fa fa-angle-double-right"></i>
                {{ $subtitulo }}
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

    <div class="widget-header widget-header-large">
        <h3 class="widget-title grey lighter">
            <i class="ace-icon fa fa-bomb red"></i>
            Fugitivos - {{ Auth::user()->unidades->nomeunidade}}
        </h3>

        <!-- #section:pages/invoice.info -->
        <div class="widget-toolbar no-border invoice-info">
            <span class="invoice-info-label">Total:</span>
            <span class="red"> {{ count($presos)  }}</span>

            <br>
            <span class="invoice-info-label">Data:</span>
            <span class="blue">{{ date('d/m/Y')  }}</span>
        </div>

        <div class="widget-toolbar hidden-480">
            <a href="#">
                <i class="ace-icon fa fa-print"></i>
            </a>
        </div>

        <!-- /section:pages/invoice.info -->
    </div>


<br>


    @forelse($presos as $preso)

        <div class="col-md-4  pricing-box">
            <div class="widget-box widget-color-dark">
                <div class="widget-header">
                    <h5 class="widget-title bigger lighter">{!! $preso->nomeapenado !!}</h5>
                </div>

                <div class="widget-body">
                    <div class="widget-main">
                        <ul class="list-unstyled spaced2">

                            <img src="{{ asset($preso->foto) }}" alt="" class="img-responsive"  style="height: 280px" >


                            <li>
                                <i class="ace-icon fa fa-check green"></i>
                                Data da Fuga: {!! strftime('%d/%m/%Y',strtotime($preso->datafuga)) !!}
                            </li>
                        </ul>

                        <hr>
                    </div>

                    <div class="widget-header">
                        <h5 class="widget-title bigger lighter">
                        @if($preso->datarecaptura == NULL)
                                <span class="label label-danger arrowed-in arrowed-in-right">FORAGIDO</span>
                        @else
                                <span class="label label-success arrowed-in arrowed-in-right">RECAPTURADO</span>
                        @endif

                        </h5>
                    </div>

                </div>

            </div>
        </div>
    @empty
        <tr>
            <td colspan="12">
                <div class="well text-center ">
                    <h2 class="text-danger"> <i class="fa fa-warning"></i> Nenhum Registro Encontrado!</h2>
                </div>
        </tr>
    @endforelse


    <br>


    <div class="row">
        <div class="col-xs-12">
            <div class="table-responsive">
                <table id="simple-table" class="table table-striped table-bordered table-hover">
                    <thead>
                        <tr class="">
                            <th>#</th>
                            <th>NOME</th>
                            <th>DATA ENTRADA</th>
                            <th>DATA FUGA</th>
                            <th>DATA RECAPTURA</th>
                            <th>TIPO</th>
                            <th>ARTIGO</th>
                            <th>EXECUÇÃO</th>
                        </tr>
                    </thead>
                    <tbody>
                    @forelse($presos as $preso)
                        <tr>
                            <th>{!! $preso->id !!}</th>
                            <td>{!! $preso->nomeapenado !!}</td>
                            <td>{!! strftime('%d/%m/%Y',strtotime($preso->dataentrada)) !!}</td>
                            <td>{!! strftime('%d/%m/%Y',strtotime($preso->datafuga)) !!}</td>
                            <td>{!! $preso->datarecaptura == NULL ? '' : strftime('%d/%m/%Y',strtotime($preso->datarecaptura)) !!}</td>
                            <td>{!! tiposaida($preso->tipo) !!}</td>
                            <td>{!! $preso->artigos !!}</td>
                            <td>{!! $preso->numeroprocesso !!}</td>
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
            </div>
            <!-- /.box -->
        </div>
    </div>



@endsection

