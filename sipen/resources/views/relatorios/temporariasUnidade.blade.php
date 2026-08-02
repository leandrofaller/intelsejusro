@extends('layouts.template')

@section('conteudo')

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


    <!-- Main content -->


    <div class="row">
        <div class="col-xs-12">
            <div class="widget-box widget-color-dark">
                <div class="widget-header">
                    <h4 class="widget-title">Informações para Pesquisa</h4>
                </div>

                <div class="widget-body">
                    <div class="widget-main no-padding">
                        {{ Form::open( ['method' => 'get', 'route' =>  ['relatorios.temporariasUnidade'], 'id'=>'formulario' ]) }}
                           <fieldset>
                                   <div class="col-md-4">
                                       <div class="form-group">
                                           {!! Form::label('datainicio','Data Início')  !!}
                                           {!! Form::text('datainicio', Request::get('datainicio'), ['class' => 'form-control date','id'=>'datainicio']) !!}
                                       </div>
                                   </div>
                                   <div class="col-md-4">
                                       <div class="form-group">
                                           {!! Form::label('datafim','Data Fim')  !!}
                                           {!! Form::text('datafim', Request::get('datafim'), ['class' => 'form-control date','id'=>'datafim']) !!}
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
            </div>
        </div>
    </div>


    <br>

@if($exibe)

    <div class="widget-header widget-header-large">
        <h3 class="widget-title grey lighter">
            <i class="ace-icon fa fa-bar-chart"></i>
            RELATÓRIO DE {!! strtoupper(Request::input('tipo')) !!}
        </h3>

        <!-- #section:pages/invoice.info -->
        <div class="widget-toolbar no-border invoice-info">
            <span class="invoice-info-label">Total:</span>
            <span class="red"> {{ count($presos)  }}</span>
            <br>
            <span class="invoice-info-label">Data:</span>
            <span class="blue">{{ date('d/m/Y')  }}</span>
        </div>
    </div>



    <div class="row">
        <div class="col-xs-12">
            <div class="table-responsive">
                <table id="simple-table" class="table table-striped table-bordered table-hover">
                    <thead>
                    <tr class="">
                        <th>#</th>
                        <th>NOME APENADO</th>
                        <th>TIPO TEMPORÁRIA</th>
                        <th>MOTIVO</th>
                        <th>DATA SAÍDA</th>
                        <th>DATA RETORNO</th>
                    </tr>
                    </thead>
                    <tbody>
                        @forelse($presos as $preso)
                            <tr>
                                <th>{!! $preso->idApen !!}</th>
                                <td>{!! $preso->nomeapenado !!}</td>
                                <td>{!! TipoTemporarias($preso->tipo) !!}</td>
                                <td>{!! MotivoTemporarias($preso->motivo) !!}</td>
                                <td>{!! dataFormat($preso->datasaida) !!} <span class="badge"> {!! $preso->horasaida !!}</span> </td>
                                <td>
                                    {!! $preso->dataretorno ? dataFormat($preso->dataretorno) : '' !!}
                                        {!! $preso->horaretorno ? '<span class="badge">'. $preso->horaretorno . '</span>' : '' !!}
                                </td>

                            </tr>

                        @empty
                            <tr>
                                <td colspan="12">
                                    <div class="well text-center ">
                                        <h2 class="text-danger"> <i class="fa fa-warning"></i> Nenhum Registro Encontrado!</h2>
                                    </div>
                                </td>
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

@section('scripts')


    {{ HTML::script('resources/assets/js/datepickerJS/bootstrap-datepicker.min.js') }}
    {{ HTML::script('resources/assets/js/datepickerJS/bootstrap-datepicker.pt-BR.min.js') }}

    {{ HTML::script('resources/assets/js/mask/maskedinput.min.js') }}
    {{ HTML::script('resources/assets/js/validacao/formatainput.js') }}

@stop