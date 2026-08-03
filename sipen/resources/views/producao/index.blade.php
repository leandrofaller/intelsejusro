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


        <!-- /.row -->
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    {!!Form::open ( ['route'=>'producao.index','method' => 'GET','id'=>'formulario'] ) !!}
                    <div class="input-group">
                        {!! Form::Text('parametro',null, ['class' => 'form-control naoValidar','maxlength'=> 100,'placeholder' => 'Digite o parametro de Pesquisa e tecle enter','id'=>'parametro']) !!}
                        <div class="input-group-btn">
                            <button type="submit" class="btn btn-default"> <i class="fa fa-search"></i> </button>
                        </div>
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
            <div class="col-md-6">
                    <a href="{!! route('producao.novo') !!}" class="btn btn-info" ><i class="fa fa-user-secret"></i> NOVO RELATÓRIO</a>
                    <div class="btn-group">
                        <button data-toggle="dropdown" class="btn btn-success dropdown-toggle">
                            <i class="ace-icon fa fa-download"></i> DOWNLOAD PDFs (ZIP)
                            <i class="ace-icon fa fa-angle-down icon-on-right"></i>
                        </button>
                        <ul class="dropdown-menu dropdown-success">
                            @php
                                $total = count($producoes);
                                $lote = 150;
                                $partes = ceil($total / $lote);
                            @endphp
                            
                            @if($total <= $lote)
                                <li>
                                    <a href="{!! route('producao.exportarZip', ['offset' => 0, 'limit' => $lote, 'parametro' => $parametro]) !!}">
                                        Baixar Todos ({!! $total !!} relatórios)
                                    </a>
                                </li>
                            @else
                                @for($i = 0; $i < $partes; $i++)
                                    @php
                                        $inicio = ($i * $lote) + 1;
                                        $fim = min((($i + 1) * $lote), $total);
                                    @endphp
                                    <li>
                                        <a href="{!! route('producao.exportarZip', ['offset' => ($i * $lote), 'limit' => $lote, 'parametro' => $parametro, 'parte' => ($i + 1)]) !!}">
                                            Parte {!! $i + 1 !!} (Relatórios {!! $inicio !!} a {!! $fim !!})
                                        </a>
                                    </li>
                                @endfor
                            @endif
                        </ul>
                    </div>
            </div>

        </div>

        <div class="row">
            <div class="col-xs-12">
                <div class="table-responsive">
                   <table id="simple-table" class="table table-striped table-bordered table-hover">
                        <thead>
                            <tr class="">
                                <th>#</th>
                                <th>SEGURANÇA</th>
                                <th>NUMERO RELATÓRIO</th>
                                <th>TIPO</th>
                                <th>DATA</th>
                                <th>CHAVE</th>
                                <th>ASSUNTO</th>
                                <th>UNIDADE</th>
                                <th>DIFUSÃO</th>
                                <th>SITUACÃO</th>
                                <th class="col-md-2"></th>
                            </tr>
                            </thead>
                            <tbody>

                                @forelse($producoes as $producao)
                                    <tr class="">
                                        <td>{!! $producao->id !!}</td>
                                        <td>{!! $producao->seguranca !!}</td>
                                        <td>{!! $producao->numero !!}</td>
                                        <td>{!! $producao->descricao !!}</td>
                                        <td>{!! dataFormat($producao->datarelatorio) !!}</td>
                                        <td>{!! $producao->chave !!}</td>
                                        <td>{!! $producao->assunto !!}</td>
                                        <td>{!! \App\Model\Unidade::mostraNomeUnidade($producao->unidade_id) !!}</td>
                                        <td>{!! $producao->difusao !!}</td>
                                        <td>
                                            <span class="label label-{!! statusRelatorio($producao->status_id) !!} ">{!! $producao->nomestatus !!}</span>
                                        </td>

                                        <td class="col-md-2">

                                           <a href="{!! route('producao.editar', $producao->id) !!}" class="btn btn-xs btn-success" title="Editar Cadastro" > <i class="ace-icon fa fa-pencil-square bigger-120"></i> </a>

                                           {{--<a href="{!! route('producao.imprimir', $producao->id) !!}" class="btn btn-xs btn-light" title="Imprimir" > <i class="ace-icon fa fa-print bigger-120"></i> </a>--}}

                                            <a href="{!! route('producao.visualizar', $producao->id) !!}" class="btn btn-xs btn-danger" title="Visualizar Impressão" > <i class="ace-icon fa fa-print bigger-120"></i> </a>
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



<!-- Modal -->

@endsection

@section('scripts')


@endsection