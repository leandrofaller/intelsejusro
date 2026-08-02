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




        <div class="col-md-12">
            <div class="widget-box widget-color-dark">
                <div class="widget-header">
                    <h4 class="widget-title">Informe a Unidade Prisional</h4>
                </div>

                <div class="widget-body">
                    <div class="widget-main no-padding">
                        {{ Form::open( ['method' => 'get', 'route' =>  ['relatorios.capacidadeCelas'], 'id'=>'formulario' ]) }}
                           <fieldset>
                                    <div class="col-md-12">
                                        <div class="form-group">

                                            <select name="unidade_id" id="unidade_id" class="form-control">
                                                <!-- se perfil for Admin- mostra todas as unidades senão mostra somente a unidade do servidor -->
                                                <option value=""></option>
                                                @foreach($unidades as $unidade)
                                                    <option value="{{ $unidade->id }}" {!! Request::get('unidade_id') == $unidade->id ? 'selected' : ''  !!} > {{$unidade->nomeunidade}} </option>
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
            </div>
        </div>

        <div class="col-md-12">

            @if($exibe)

                    <div class="widget-box transparent">
                        <div class="widget-header widget-header-flat">
                            <h4 class="widget-title lighter">
                                <i class="ace-icon fa fa-star orange"></i>
                                Resultado da Pesquisa
                            </h4>
                        </div>

                        <div class="widget-body">
                            <div class="widget-main no-padding">
                                <table class="table table-bordered table-striped">
                                    <thead class="thin-border-bottom">
                                    <tr>
                                        {{--<th> # </th>--}}
                                        <th> DESCRIÇÃO CELA</th>
                                        <th> VAGAS</th>
                                        <th> QTD PRESOS</th>
                                        <th><span class="red">DEFÍCIT</span>/<span class="blue">SUPERAVIT</span></th>
                                    </tr>
                                    </thead>

                                    <tbody>
                                        <?php $totC = 0; $qtdP = 0;?>
                                    @forelse($celas as $cela)
                                        <?php
                                        $capacidade = $cela->capacidade;
                                        $qtdpreso = \App\Model\Apenado::contaApenadoCela($cela->id)[0];
                                        $deficit = $capacidade - $qtdpreso;
                                        $totC = $capacidade + $totC;
                                        $qtdP = $qtdpreso + $qtdP;
                                        ?>
                                        <tr>
                                            {{--<td>{!! $cela->id !!}</td>--}}
                                            <td>{!! $cela->nomecarceragem !!} - {!! $cela->nomecela !!}</td>
                                            <td><b class="green">{!! $capacidade !!}</b> </td>
                                            <td><b class="red"> {!! $qtdpreso !!} </b> </td>
                                            <td><b class="{!! $deficit >= $capacidade ? 'blue' : 'red' !!}"> {!! $deficit !!} </b> </td>
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
                                    <tr class="">
                                        {{--<td>{!! $cela->id !!}</td>--}}
                                        <td class="right">Total Geral</td>
                                        <td><b class="green">{!! $totC !!}</b> </td>
                                        <td><b class="red"> {!! $qtdP !!} </b> </td>
                                        <td><b class=" "> {!! $totC - $qtdP  !!} </b> </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div><!-- /.widget-main -->
                        </div><!-- /.widget-body -->
                    </div><!-- /.widget-box -->





            @endif



        </div>



    <br>



@endsection

@section('scripts')


    {{ HTML::script('resources/assets/js/datepickerJS/bootstrap-datepicker.min.js') }}
    {{ HTML::script('resources/assets/js/datepickerJS/bootstrap-datepicker.pt-BR.min.js') }}

    {{ HTML::script('resources/assets/js/mask/maskedinput.min.js') }}
    {{ HTML::script('resources/assets/js/validacao/formatainput.js') }}

@stop