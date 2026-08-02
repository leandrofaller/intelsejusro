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
                        {{ Form::open( ['method' => 'get', 'route' =>  ['relatorios.buscaFaccionado'], 'id'=>'formulario' ]) }}
                           <fieldset>

                               <div class="col-md-8">
                                   <div class="form-group">
                                       {!! Form::label('parametro','Digite a informação para pesquisa')  !!}
                                       {!! Form::text('parametro', Request::get('parametro'), ['class' => 'form-control']) !!}
                                   </div>
                               </div>

                               <div class="col-md-4">
                                        <div class="form-group">
                                            {!! Form::label('tipo', 'Tipo / Local Pesquisa')  !!}
                                            <select name="tipo" id="tipo" class="form-control">
                                                <option value="Nome" {{ Request::get('tipo') == 'Nome' ? 'selected' : '' }} >Nome</option>
                                                <option value="Cpf" {{ Request::get('tipo') == 'Cpf' ? 'selected' : '' }} >Cpf</option>
                                                <option value="Alcunha/Vulgo" {{ Request::get('tipo') == 'Alcunha/Vulgo' ? 'selected' : '' }}>Alcunha/Vulgo</option>
                                                <option value="Batismo" {{ Request::get('tipo') == 'Batismo' ? 'selected' : '' }}>Batismo</option>
                                                <option value="Matricula" {{ Request::get('tipo') == 'Matricula' ? 'selected' : '' }}>Matricula</option>
                                                <option value="Telefone" {{ Request::get('tipo') == 'Telefone' ? 'selected' : '' }}>Telefone</option>
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

    <div class="widget-header widget-header-large">
        <h3 class="widget-title grey lighter">
            <i class="ace-icon fa fa-bar-chart"></i>
            RELATÓRIO / BUSCA POR: {!! strtoupper(Request::input('tipo')) !!}
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
                        <th>FACCAO</th>
                        <th>LOCALIZAÇÃO ATUAL</th>
                        <th>FOTO</th>
                    </tr>
                    </thead>
                    <tbody>
                        @forelse($presos as $preso)
                            <tr>
                                <th>{!! $preso->idApen !!}</th>
                                <td>{!! $preso->nomeapenado !!}</td>
                                <td>{!! \App\Model\Integrantes::mostraFaccao($preso->idApen) !!}</td>
                                <td>{!! \App\Model\Apenado::mostraunidadeAtual($preso->idApen) !!}</td>
                                <td class="hidden" data-foto="{!! asset('public/'.\App\Model\Apenado::mostraFotoPrincipal($preso->idApen)) !!}" > </td>
                                <td>
                                    @if((\App\Model\Apenado::mostraFotoPrincipal($preso->idApen)) != 'fotosPresos/semfoto.png')
                                        <a href="#" class="btn btn-xs btn-purple abrirModal" title="Mostrar Foto" > <i class="ace-icon fa fa-photo bigger-120"></i> </a>
                                    @endif
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

    @include('suportes.modalfoto')



@endsection

@section('scripts')

    {{ HTML::script('resources/assets/js/modalFotos/script.js') }}

    {{ HTML::script('resources/assets/js/datepickerJS/bootstrap-datepicker.min.js') }}
    {{ HTML::script('resources/assets/js/datepickerJS/bootstrap-datepicker.pt-BR.min.js') }}

    {{ HTML::script('resources/assets/js/mask/maskedinput.min.js') }}
    {{ HTML::script('resources/assets/js/validacao/formatainput.js') }}

@stop