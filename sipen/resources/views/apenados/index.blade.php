@extends('layouts.template')

@section('conteudo')
<?php
use App\Model\Apenado;
?>

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


        <!-- /.row -->
        <div class="row">
            <div class="col-xs-12">
                <div  style="width: 350px;">
                    {!!Form::open ( ['route'=>'apenados.index','method' => 'GET','id'=>'formulario'] ) !!}
                            {!! Form::Text('parametro',null, ['class' => 'form-control pull-right','maxlength'=> 100,'placeholder' => 'Digite o Nome ou Cpf e Tecle Enter para Pesquisar','id'=>'parametro']) !!}
                    {!! Form::close() !!}
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
                                <th>NOME DO APENADO</th>
                                <th class="col-md-2">CPF</th>
                                @if(Auth::user()->perfil == 'Admin')
                                <th>UNIDADE PRISIONAL ATUAL</th>
                                @endif
                                <th>CELA</th>
                                <th>SITUAÇÃO</th>
                                <th class="col-md-2"></th>
                            </tr>
                            </thead>
                            <tbody>

                                @forelse($apenados as $apenado)
                                    <?php
                                        $status = \App\Model\Apenado::situacaoAtual($apenado->id);
                                    ?>
                                    {{-- --}}
                                    <tr class="{!! \App\Model\MedidaDisciplinar::verificaMedidaDisciplinar($apenado->id) == 'md' ? 'danger' : ''!!}">
                                        <td data-apenado_id="{!! $apenado->id !!}"> {!! $apenado->id !!}</td>

                                        <td>{!! $apenado->nomeapenado !!}</td>
                                        <td>{!! $apenado->cpf !!}</td>
                                        @if(Auth::user()->perfil == 'Admin')
                                        <td>{!! \App\Model\Apenado::mostraunidadeAtual($apenado->id) !!}</td>
                                        @endif
                                        <td>{!! \App\Model\Apenado::mostracelaAtual($apenado->id) !!}</td>
                                        <td> {!! verificastatus($apenado->id) !!} </td>
                                        <td class="hidden" data-foto="{!! asset('public/'.\App\Model\Apenado::mostraFotoPrincipal($apenado->id)) !!}" > {!! asset('public/'.\App\Model\Apenado::mostraFotoPrincipal($apenado->id)) !!} </td>
                                        <td class="col-md-2">
                                            @if( $status  == 'Aguardando Recebimento')
                                                <a href="{{ route('apenados.recebimento', ['id'=>$apenado->id]) }}" class="btn btn-xs btn-warning" title="Recebimento de Apenado" > <i class="ace-icon fa fa-arrow-circle-right bigger-120"></i> </a>
                                            @elseif( ($status  == 'Apenado Preso') or ($status == 'Sinistro') )
                                            <a href="{{ route('apenados.selecionarOpcao', ['id'=>$apenado->id]) }}" class="btn btn-xs btn-danger" title="Editar Cadastro, Mudança de Cela, Alterar Foto e Registrar Saída, Etc..." > <i class="ace-icon fa fa-pencil-square bigger-120"></i> </a>
                                            @elseif( $status  == 'Sinistro' )
                                                <a href="{{ route('foragidos.recaptura', ['id'=>$apenado->id]) }}" class="btn btn-xs btn-danger" title="Apenado Recapturado" > <i class="ace-icon fa fa-paw bigger-120"></i> </a>
                                            @elseif(($status == 4) or ($status == 5) or ($status == 6))
                                                <a href="{{ route('apenados.novaentrada', ['id'=>$apenado->id]) }}" class="btn btn-xs btn-success" title="Registrar Nova Entrada" > <i class="ace-icon fa fa-unlock bigger-120"></i> </a>
                                            @endif

                                            @if((\App\Model\Apenado::mostraFotoPrincipal($apenado->id)) != 'fotosPresos/semfoto.png')
                                            <a href="#" class="btn btn-xs btn-purple abrirModal" title="Mostrar Foto" > <i class="ace-icon fa fa-photo bigger-120"></i> </a>
                                            @endif

                                            {{--<a href="#" class="btn btn-xs btn-default " id="btnFicha" name="btnFicha" title="Ficha Completa" > <i class="ace-icon fa fa-newspaper-o bigger-120"></i> </a>--}}

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
                    {!! $apenados->render() !!}
                </div>
                  
                <!-- /.box -->
            </div>
        </div>



<!-- Modal -->
{{--@include('suportes.modalficha')--}}
@include('suportes.modalfoto')

@endsection

@section('scripts')

    {{ HTML::script('resources/assets/js/modalFotos/script.js') }}
    {{ HTML::script('resources/assets/js/ficha/script.js') }}

@endsection