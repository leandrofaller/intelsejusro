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
                        {{ Form::open( ['method' => 'get', 'route' =>  ['relatorios.movimentacoesAdmin'], 'id'=>'formulario' ]) }}
                           <fieldset>
                               <div class="col-md-6">
                                   <div class="form-group">
                                       {!! Form::label('unidade_id', 'Informe a Unidade Prisional') !!}
                                       <select name="unidade_id" id="unidade_id" class="form-control">
                                           <!-- se perfil for Admin- mostra todas as unidades senão mostra somente a unidade do servidor -->
                                           <option value=""></option>
                                           @foreach($unidades as $unidade)
                                               <option value="{{ $unidade->id }}" {!! Request::get('unidade_id') == $unidade->id ? 'selected' : ''  !!} > {{$unidade->nomeunidade}} </option>
                                           @endforeach
                                       </select>
                                   </div>
                               </div>

                                    <div class="col-md-2">
                                        <div class="form-group">
                                            {!! Form::label('tipo', 'Tipo')  !!}
                                            <select name="tipo" id="tipo" class="form-control">
                                                <option value=""></option>
                                                <option value="Entradas" {{ Request::get('tipo') == 'Entradas' ? 'selected' : '' }} >Entradas</option>
                                                <option value="Saídas" {{ Request::get('tipo') == 'Saídas' ? 'selected' : '' }}>Saídas</option>
                                            </select>
                                        </div>
                                    </div>
                                   <div class="col-md-2">
                                       <div class="form-group">
                                           {!! Form::label('datainicio','Data Início')  !!}
                                           {!! Form::text('datainicio', Request::get('datainicio'), ['class' => 'form-control date','id'=>'datainicio']) !!}
                                       </div>
                                   </div>
                                   <div class="col-md-2">
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
                        <th>DATA NASCIMENTO</th>
                        <th>{!! Request::input('tipo') == 'Entradas' ? 'UNIDADE DE ORIGEM' : ' UNIDADE DE DESTINO ' !!}</th>
                        <th>DATA ENTRADA</th>
                        <th>DATA SAÍDA</th>
                        <th>MOTIVO</th>
                        <th>ARTIGO</th>
                        <th>EXECUÇÃO</th>
                    </tr>
                    </thead>
                    <tbody>
                        @forelse($presos as $preso)
                            <tr>
                                <th>{!! $preso->idApen !!}</th>
                                <td>{!! $preso->nomeapenado !!}</td>
                                <td>{!! strftime('%d/%m/%Y',strtotime($preso->datanascimento)) !!}</td>
                                <th>{!! Request::input('tipo') == 'Entradas'
                                        ? \App\Model\Unidade::mostraNomeUnidade($preso->unidadeorigem)
                                        : \App\Model\Unidade::mostraNomeUnidade($preso->unidadedestino) !!}</th>
                                <td>{!! strftime('%d/%m/%Y',strtotime($preso->dataentrada)) !!}</td>
                                <td>{!! $preso->datasaida == NULL ? '' : strftime('%d/%m/%Y',strtotime($preso->datasaida)) !!}</td>
                                <td>{!! tiposaida($preso->motivosaida)  !!}</td>
                                <td>{!! $preso->artigos !!}</td>
                                <td>{!! $preso->numeroprocesso !!}</td>
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