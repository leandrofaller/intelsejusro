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
                        {{ Form::open( ['method' => 'get', 'route' =>  ['relatorios.faccionados'], 'id'=>'formulario' ]) }}
                           <fieldset>
                               <div class="col-md-6">
                                   <div class="form-group">
                                       {!! Form::label('unidade_id', 'Informe a Unidade Prisional') !!}
                                       <select name="nomeunidade" id="nomeunidade" class="form-control">
                                           <!-- se perfil for Admin- mostra todas as unidades senão mostra somente a unidade do servidor -->
                                           <option value=""></option>
                                           @foreach($unidades as $unidade)
                                               <option value="{{ $unidade->id }}" {!! Request::get('nomeunidade') == $unidade->id ? 'selected' : ''  !!} > {{$unidade->nomeunidade}} </option>
                                           @endforeach
                                       </select>
                                   </div>
                               </div>

                               <div class="col-md-6">
                                   <div class="form-group">
                                       {!! Form::label('cidadeunidade', 'Cidade') !!}
                                       <select name="cidadeunidade" id="cidadeunidade" class="form-control">
                                           <option value=""></option>
                                           @foreach($cidades as $cidade)
                                               <option value="{{ $cidade->cidadeunidade }}" {!! Request::get('cidadeunidade') == $cidade->cidadeunidade ? 'selected' : ''  !!} > {{$cidade->cidadeunidade}} </option>
                                           @endforeach
                                       </select>
                                   </div>
                               </div>


                               <div class="col-md-4">
                                   <div class="form-group">
                                       {!! Form::label('nomecargo', 'Cargo') !!}
                                       <select name="nomecargo" id="nomecargo" class="form-control">
                                           <option value=""></option>
                                           @foreach($cargos as $cargo)
                                               <option value="{{ $cargo->id }}" {!! Request::get('nomecargo') == $cargo->id ? 'selected' : ''  !!} > {{$cargo->nomecargo}} </option>
                                           @endforeach
                                       </select>
                                   </div>
                               </div>

                               <div class="col-md-4">
                                   <div class="form-group">
                                       {!! Form::label('nomeregiao', 'Sinpe') !!}
                                       <select name="nomeregiao" id="nomeregiao" class="form-control">
                                           <option value=""></option>
                                           @foreach($sinpes as $sinpe)
                                               <option value="{{ $sinpe->id }}" {!! Request::get('nomeregiao') == $sinpe->id ? 'selected' : ''  !!} > {{$sinpe->nomeregiao}} </option>
                                           @endforeach
                                       </select>
                                   </div>
                               </div>

                               <div class="col-md-4">
                                   <div class="form-group">
                                       {!! Form::label('visualizacao', 'Modo de Visualização') !!}
                                       <select name="visualizacao" id="visualizacao" class="form-control">
                                           <option value="Lista" {!! Request::get('visualizacao') == "Lista" ? 'selected' : '' !!}> Lista </option>
                                           <option value="Grade" {!! Request::get('visualizacao') == "Grade" ? 'selected' : '' !!}> Grade </option>
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
            </div>
        </div>
    </div>


    <br>

    @if($exibe)

        @if($visualizacao == 'Grade')

            @forelse($presos as $preso)
                <div class="col-xs-6 col-sm-3 pricing-box">
                <div class="widget-box widget-color-dark">
                    <div class="widget-header">
                        <h5 class="widget-title bigger lighter">{!! $preso->nomeapenado !!}</h5>
                    </div>

                    <div class="widget-body">
                        <div class="widget-main">
                            <ul class="list-unstyled spaced1">

                                <li>
                                    <img class="img-responsive editable-empty" style="width: 100%; height: 280px;" src="{!! asset('public/'.\App\Model\Apenado::mostraFotoPrincipal($preso->idApen)) !!}"/>
                                </li>

                                <li>
                                    <i class="ace-icon fa fa-check green"></i>
                                    <b>Batismo: {!! \App\Model\Nomebatismo::nomeBatismo($preso->idIntegrante) !!} </b>
                                </li>


                                <li>
                                    <i class="ace-icon fa fa-check green"></i>
                                    <b>Cidade: {!! $preso->cidadeunidade !!} </b>
                                </li>

                                <li>
                                    <i class="ace-icon fa fa-check green"></i>
                                    <b>Facção: {!! \App\Model\Faccao::mostraSiglaFaccao($preso->faccao_id) !!} </b>
                                </li>

                                <li>
                                    <i class="ace-icon fa fa-check green"></i>
                                    <b>Cargo: {!! \App\Model\Cargos::nomeCargo($preso->idIntegrante) !!} </b>
                                </li>

                                <li>
                                    <i class="ace-icon fa fa-check green"></i>
                                    <b>Situação: {!! \App\Model\Integrantes::mostraClassificacao($preso->faccao_classificacao_id) !!} </b>
                                </li>

                            </ul>

                        </div>

                        <div>
                            <a href="#" class="btn btn-block btn-inverse">
                                {{--<i class="ace-icon fa fa-shopping-cart bigger-110"></i>--}}
                                <span></span>
                            </a>
                        </div>
                    </div>
                </div>
                </div>
            @empty
                    <td colspan="12">
                        <div class="well text-center ">
                            <h2 class="text-danger"> <i class="fa fa-warning"></i> Nenhum Registro Encontrado!</h2>
                        </div>
                    </td>
            @endforelse

        @else

            <div class="row">
                <div class="col-xs-12">
                    <div class="table-responsive">
                        <table id="simple-table" class="table table-striped table-bordered table-hover">
                            <thead>
                            <tr class="">
                                <th>#</th>
                                <th>NOME APENADO</th>
                                <th>CIDADE</th>
                                <th>BATISMO</th>
                                <th>SITUAÇÃO</th>
                                <th>FACÇÃO</th>
                                <th>CARGO</th>
                            </tr>
                            </thead>
                            <tbody>
                                @forelse($presos as $preso)
                                    <tr>
                                        <th>{!! $preso->id !!}</th>
                                        <td>{!! $preso->nomeapenado !!}</td>
                                        <th>{!! $preso->cidadeunidade !!}</th>
                                        <td>{!! \App\Model\Nomebatismo::nomeBatismo($preso->idIntegrante) !!}</td>
                                        <td>{!! \App\Model\Integrantes::mostraClassificacao($preso->faccao_classificacao_id) !!}</td>
                                        <td>{!! \App\Model\Faccao::mostraSiglaFaccao($preso->faccao_id) !!}</td>
                                        <td>{!! \App\Model\Cargos::nomeCargo($preso->idIntegrante) !!}</td>
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


@endif




@endsection

@section('scripts')


    {{ HTML::script('resources/assets/js/datepickerJS/bootstrap-datepicker.min.js') }}
    {{ HTML::script('resources/assets/js/datepickerJS/bootstrap-datepicker.pt-BR.min.js') }}

    {{ HTML::script('resources/assets/js/mask/maskedinput.min.js') }}
    {{ HTML::script('resources/assets/js/validacao/formatainput.js') }}

@stop