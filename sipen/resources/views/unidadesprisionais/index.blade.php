@extends('layouts.template')

@section('conteudo')

@section('css')
    {{ HTML::style('resources/assets/js/dataTables/jquery.dataTables.min.css') }}

@stop

    <div class="page-header">
        <h1>
            {{ $titulo }}
            <small>
                <i class="ace-icon fa fa-angle-double-right"></i>
                {{ $subtitulo }}
            </small>
            <div class="pull-right"> <a href="{{ route('unidadesprisionais.novo')  }}" class="btn btn-grey"> Nova Unidade Prisional</a> </div>

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

        <div class="row">
            <div class="col-md-12">
                    <!-- /.box-header -->
                    <div class="table-responsive">
                        <table id="example" class="display">
                            <thead class="thin-border-bottom">

                            <tr>
                                <th>#</th>
                                <th>REGIÃO</th>
                                <th>NOME UNIDADE</th>
                                <th>CIDADE / COMARCA</th>
                                <th>TIPO DE ESTABELECIMENTO</th>
                                <th>APENADOS</th>
                                <th>CARCERAGEM</th>
                                <th>CELAS</th>
                                <th></th>
                            </tr>
                            </thead>

                            <tbody>
                            @foreach($unidades as $unidade)
                                <tr>
                                    <th>{!! $unidade->id !!}</th>
                                    <td>{!! \App\Model\Regioes::nomeRegiao($unidade->regiao_id) !!}</td>
                                    <td>{!! $unidade->nomeunidade !!}</td>
                                    <td>{!! $unidade->cidadeunidade !!}</td>
                                    <td>{!! $unidade->tipoestabelecimento !!}</td>
                                    <td>
                                        @if($unidade->recebeapenados == 'Sim')
                                            <span class="badge badge-success"> Sim </span>
                                        @elseif($unidade->recebeapenados == 'Não')
                                            <span class="badge badge-danger"> Não </span>
                                        @else
                                            Pendente
                                        @endif

                                    </td>
                                    <td>{!! \App\Model\Unidade::contaQtdCarceragem($unidade->id) !!}</td>
                                    <td>{!! \App\Model\Unidade::contaQtdCela($unidade->id) !!}</td>
                                    <td>
                                        <div class="hidden-sm hidden-md btn-group">
                                            <a href="{{ route('unidadesprisionais.editar', ['id'=>$unidade->id]) }}" title="Editar Unidade "  class="btn btn-xs btn-info">
                                                <i class="ace-icon fa fa-pencil bigger-120"></i>
                                            </a>

                                            <a href="{{ route('carceragens.index', ['idUnidade'=>$unidade->id]) }}" title="Listar Carceragens" class="btn btn-xs btn-warning">
                                                <i class="ace-icon fa fa-list-ul bigger-120"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>

                        </table>
                    </div>

            </div>
        </div>

@section('scripts')

    {{ HTML::script('resources/assets/js/dataTables/jquery.dataTables.bootstrap.js') }}
    {{ HTML::script('resources/assets/js/dataTables/jquery.dataTables.js') }}

    <script>
        $(document).ready(function() {
            $('#example').DataTable({
                "paging":   false,
                "info":     false
            });
        } );

    </script>

@stop

@endsection

