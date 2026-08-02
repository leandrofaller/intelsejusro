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

                <div class="alert alert-danger">
                    <h1> <i class="fa fa-info"></i> Atenção! Esta ação é irreversível.</h1>
                    <h1>{!! $apenado->nomeapenado !!}</h1>
                </div>




                    <div class="infobox infobox-{!! count($apenado) > 0 ? 'green' : 'grey' !!} infobox-small infobox-dark">
                        <div class="infobox-data">
                            <div class="infobox-content">Apenado</div>
                            <div class="infobox-content">{!! count($apenado) !!}</div>
                        </div>
                     </div>




                    <div class="infobox infobox-{!! count($processos) > 0 ? 'green' : 'grey' !!} infobox-small infobox-dark">
                        <div class="infobox-data">
                            <div class="infobox-content">Processos</div>
                            <div class="infobox-content">{!! count($processos) !!}</div>
                        </div>
                    </div>



                <div class="infobox infobox-{!! count($movimentacoes) > 0 ? 'green' : 'grey' !!} infobox-small infobox-dark">
                    <div class="infobox-data">
                        <div class="infobox-content">Movimentações</div>
                        <div class="infobox-content">{!! count($movimentacoes) !!}</div>
                    </div>

                </div>


                    <div class="infobox infobox-{!! count($informacoes) > 0 ? 'green' : 'grey' !!} infobox-small infobox-dark">
                        <div class="infobox-data">
                            <div class="infobox-content">Informações</div>
                            <div class="infobox-content">{!! count($informacoes) !!}</div>
                        </div>

                    </div>



                    <div class="infobox infobox-{!! count($anexos) > 0 ? 'green' : 'grey' !!} infobox-small infobox-dark">
                        <div class="infobox-data">
                            <div class="infobox-content">Anexos</div>
                            <div class="infobox-content">{!! count($anexos) !!}</div>
                        </div>

                    </div>



                    <div class="infobox infobox-{!! count($visitas) > 0 ? 'green' : 'grey' !!} infobox-small infobox-dark">
                        <div class="infobox-data">
                            <div class="infobox-content">Visitas</div>
                            <div class="infobox-content">{!! count($visitas) !!}</div>
                        </div>

                    </div>



                    <div class="infobox infobox-{!! count($advogados) > 0 ? 'green' : 'grey' !!} infobox-small infobox-dark">
                        <div class="infobox-data">
                            <div class="infobox-content">Advogados</div>
                            <div class="infobox-content">{!! count($advogados) !!}</div>
                        </div>

                    </div>

                    <div class="infobox infobox-{!! count($fugas) > 0 ? 'green' : 'grey' !!} infobox-small infobox-dark">
                        <div class="infobox-data">
                            <div class="infobox-content">Fugas</div>
                            <div class="infobox-content">{!! count($fugas) !!}</div>
                        </div>

                    </div>

                    <div class="infobox infobox-{!! count($pads) > 0 ? 'green' : 'grey' !!} infobox-small infobox-dark">
                        <div class="infobox-data">
                            <div class="infobox-content">PAD</div>
                            <div class="infobox-content">{!! count($pads) !!}</div>
                        </div>

                    </div>

                <div class="infobox infobox-{!! count($integrantes) > 0 ? 'green' : 'grey' !!} infobox-small infobox-dark">
                    <div class="infobox-data">
                        <div class="infobox-content">Integrantes</div>
                        <div class="infobox-content">{!! count($integrantes) !!}</div>
                    </div>
                </div>


                <div class="infobox infobox-{!! count($medidadisciplinar) > 0 ? 'green' : 'grey' !!} infobox-small infobox-dark">
                    <div class="infobox-data">
                        <div class="infobox-content">Med. Disc.</div>
                        <div class="infobox-content">{!! count($medidadisciplinar) !!}</div>
                    </div>
                </div>
                <!-- /.box -->

            </div>
        </div>
<br>
<br>

<p>

    <a href="{{route('apenados.destroy', ['id'=>$apenado->id, 'idAcao'=>'Todos']) }}" type="submit"
       onclick="return confirm('Deseja realmente excluir este Apenado?');"
       class="btn btn-danger btn-block"><i class="fa fa-trash"></i> Excluir Agora </a>
</p>

@endsection

@section('scripts')
    {{ HTML::script('resources/assets/js/modalFotos/script.js') }}
@endsection