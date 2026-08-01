@extends('layouts.template')

@section('conteudo')
<?php
use App\Model\Apenado;
use App\Model\Integrantes;
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
            <div class="col-md-12">
                <div  style="width: 350px;">
                    {!!Form::open ( ['route'=>'apenados.localizacao','method' => 'GET','id'=>'formulario'] ) !!}
                            {!! Form::Text('parametro',null, ['class' => 'form-control pull-right','id'=>'parametro','placeholder' => 'Digite o Nome ou Cpf e Tecle Enter para Pesquisar','id'=>'parametro']) !!}
                    {!! Form::close() !!}
                </div>
            </div>
        </div>

        <div class="row">
            @if(!empty($apenados))
            <div class="col-xs-12">
                <div class="table-responsive">
                   <table id="simple-table" class="table table-striped table-bordered table-hover">
                        <thead>
                            <tr class="">
                                <th>#</th>
                                <th>NOME DO APENADO</th>
                                <th>CPF</th>
                                <th>UNIDADE PRISIONAL ATUAL</th>
                                <th>CELA</th>
                                <th>SITUAÇÃO</th>
                               <th></th>
                            </tr>
                            </thead>
                            <tbody>    
                            @forelse($apenados as $apenado)
                                <?php
                                $status = \App\Model\Apenado::situacaoAtual($apenado->id);
                                if($status == 'Apenado Preso'){
                                    $legenda = "<span class=\"label label-grey arrowed\">Apenado Preso</span>";
                                }elseif($status == 'Aguardando Recebimento'){
                                    $legenda = "<span class=\"label label-warning arrowed\">Aguardando Recebimento da Unidade</span>";
                                }elseif($status == 'Sinistro'){
                                    $legenda1 = \App\Model\Apenado::mostraSinistro($apenado->id);
                                    $legenda = "<span class=\"label label-danger arrowed\"> $legenda1 </span>";

                                }else{
                                    $legenda2 = tiposaida($status);
                                    if(($status == 4) or ($status == 5) or ($status == 6)){
                                        $legenda = "<span class=\"label label-success arrowed\"> $legenda2 </span>";
                                    }else{
                                        $legenda = "<span class=\"label label-purple arrowed\"> $legenda2 </span>";
                                    }
                                }
                                ?>
                                <tr>
                                    <td data-apenado_id="{!! $apenado->id !!}"> {!! $apenado->id !!}</td>
                                    <td>{!! $apenado->nomeapenado !!}</td>
                                    <td>{!! $apenado->cpf !!}</td>
                                    <td>{!! Apenado::mostraunidadeAtual($apenado->id) !!}</td>
                                    <td>{!! Apenado::mostracelaAtual($apenado->id) !!}</td>
                                    <td>{!! $legenda !!}</td>

                                    <td>
                                        @if(($status == 4) or ($status == 5) or ($status == 6) or ($status == 16))
                                            <a href="{{ route('apenados.novaentrada', ['id'=>$apenado->id]) }}" class="btn btn-xs btn-success" title="Registrar Nova Entrada" > <i class="ace-icon fa fa-unlock bigger-120"></i> </a>
                                        @endif
                                            <a href="#" class="btn btn-xs btn-default " id="btnFicha" name="btnFicha" title="Ficha Completa" > <i class="ace-icon fa fa-newspaper-o bigger-120"></i> </a>
                                        @if(Apenado::mostraunidadeAtual($apenado->id) == 'TRÂNSITO')
                                            <a href="{{ route('apenados.recebimento', ['id'=>$apenado->id]) }}" class="btn btn-xs btn-success" title="Registrar Entrada de Apenado em Trânsito." > <i class="ace-icon fa fa-cab bigger-120"></i> </a>
                                        @endif

                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="12">
                                        <div class="well text-center ">
                                            <h2 class="text-danger"> <i class="fa fa-warning"></i> Nenhum Apenado Encontrado com este Nome.!</h2>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse

                            </tbody>
                   </table>



                </div>
                <!-- /.box -->
            </div>


                <span class="center">
                    @if(Auth::user()->perfil != 'Externo')
                 <a href="{!! route('apenados.novo') !!}" class="btn btn-success rounded-s"><i class="fa fa-user"></i> NOVO CADASTRO </a>
                    @endif
            </span>
            @else
                <div class="col-md-12">
                    <div class="well text-center ">
                        <h2 class="text-info"> <i class="fa fa-warning"></i> Informe o nome do Apenado para sua Localização</h2>
                    </div>
                </div>
            @endif

        </div>

@include('suportes.modalficha')

@endsection


@section('scripts')
    {{ HTML::script('resources/assets/js/ficha/script.js') }}

    {{ HTML::script('resources/assets/js/apenados/wizard.js') }}
    {{ HTML::script('resources/assets/js/jquery-ui.js') }}



    <script type="text/javascript">
        $(document).ready(function() {
            src = "{{ route('apenados.autocomplete') }}";
            $("#parametro").autocomplete({
                source: function(request, response) {
                    $.ajax({
                        url: src,
                        dataType: "json",
                        data: {
                            term : request.term
                        },
                        success: function(data) {
                            response(data);
                        }
                    });
                },
                minLength: 3,
            });
        });
    </script>

@stop