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




    <div class="widget-body">
        <div class="widget-main no-padding">
            {{ Form::open( ['method' => 'get', 'route' =>  ['listagem.celas'], 'id'=>'formulario' ]) }}
            <fieldset>
                <div class="col-md-12">
                    <div class="form-group">
                        {!! Form::label('cela_id', 'Selecione uma Cela') !!}
                        <select name="cela_id" id="unidade_id" class="form-control">
                            <!-- se perfil for Admin- mostra todas as unidades senão mostra somente a unidade do servidor -->
                            <option value=""></option>
                            @foreach($celas as $cela)
                                <option value="{{ $cela->id }}" {!! Request::get('cela_id') == $cela->id ? 'selected' : ''  !!} >{{ $cela->nomecarceragem }} - {{$cela->nomecela}} </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </fieldset>

            <div class="form-actions center">
                <button type="submit" class="btn btn-sm btn-success">
                    <i class="ace-icon fa fa-search icon-on-right bigger-110"></i>
                    Pesquisar
                </button>
            </div>
            {!! Form::close() !!}

        </div>
    </div>



    @if($exibe)
        <br>

        <div class="widget-header widget-header-large">
            <h3 class="widget-title grey lighter">
                <i class="ace-icon fa fa-leaf green"></i>
               Apenados Encontrados
            </h3>

            <!-- #section:pages/invoice.info -->
            <div class="widget-toolbar no-border invoice-info">
                <span class="invoice-info-label">Total:</span>
                <span class="red"> {{ count($presos)  }}</span>

                <br>
                <span class="invoice-info-label">Data:</span>
                <span class="blue">{{ date('d/m/Y')  }}</span>
            </div>

            <div class="widget-toolbar">
                @if(count($presos) > 0)
                <a href="{!! route('listagem.fichaCela', Request::get('cela_id')) !!}" target="_blank">
                    <i class="ace-icon fa fa-print"></i>
                </a>
                @endif
            </div>

            <!-- /section:pages/invoice.info -->
        </div>


    <div class="row">
        <div class="col-xs-12">
            <div class="table-responsive">
                <table id="simple-table" class="table table-striped table-bordered table-hover">
                    <thead>
                        <tr class="">
                            <th>ORDEM</th>
                            <th>FOTO</th>
                            <th>NOME APENADO</th>
                            <th>CELA</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php $i = 1;?>
                    @forelse($presos as $preso)
                        <tr>
                            <th class="col-md-1">{!! $i++ !!}</th>
                            <td class="col-md-1"> <img style=" width: 85px; height: 90px; " src="{!! asset($preso->foto) !!}"/></td>
                            <td class="col-md-8">{!! $preso->nomeapenado !!}</td>
                            <td class="col-md-2">{!! $preso->nomecela !!}</td>
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
    @endif


@endsection

