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
                {!!Form::open ( ['route'=>'visitas.listarvisitantes','method' => 'GET','id'=>'formulario'] ) !!}
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
                        <th>NOME DO VISITANTE</th>
                        <th>CPF</th>
                        <th>DATA NASCIMENTO</th>
                        <th>ENDERECO VISITA</th>
                        <th>TELEFONE CONTATO</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($visitas as $visita)
                        <tr>

                            <td data-id={{$visita->idVisita}}> {!! $visita->idVisita !!}</td>
                            <td data-nomevisita="{{$visita->nomevisita}}" >{!! $visita->nomevisita !!}</td>
                            <td data-cpfvisita="{{$visita->cpfvisita}}" >{!! $visita->cpfvisita !!}</td>
                            <td data-datanascimentovisita="{{strftime('%d/%m/%Y',strtotime($visita->datanascimentovisita))}}" >{!! strftime('%d/%m/%Y',strtotime($visita->datanascimentovisita)) !!}</td>
                            <td data-enderecovisita="{{$visita->enderecovisita}}" >{!! $visita->enderecovisita !!}</td>
                            <td data-telefonecontato="{{$visita->telefonecontato}}" >{!! $visita->telefonecontato !!}</td>

                            <td class="hidden" data-rgvisita="{{$visita->rgvisita}}"> {!! $visita->rgvisita !!}</td>
                            <td class="hidden" data-fotovisita="{{asset($visita->fotovisita)}}"> {!! $visita->fotovisita !!}</td>
                            <td class="hidden" data-ufvisita="{{$visita->ufvisita}}"> {!! $visita->ufvisita !!}</td>
                            <td class="hidden" data-cidadevisita="{{$visita->cidadevisita}}"> {!! $visita->cidadevisita !!}</td>
                            <td class="hidden" data-telefonecontato="{{$visita->telefonecontato}}"> {!! $visita->telefonecontato !!}</td>
                            <td class="hidden" data-dataemicaocarteirinha="{{strftime('%d/%m/%Y',strtotime($visita->dataemicaocarteirinha))}}"> {!! $visita->dataemicaocarteirinha !!}</td>

                            <td>
                                <a href="#" title="Alterar Cadastro de Visitante" name="btnEditar" class="btn btn-xs btn-info"> <i class="ace-icon fa fa-pencil-square bigger-120"></i> </a>
                                <a href="{{ route('visitas.detalhavisitas', $visita->id) }}" title="Mostrar Apenados Visitados" class="btn btn-xs btn-warning"> <i class="ace-icon fa fa-bars bigger-120"></i> </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="12">
                                <div class="well text-center ">
                                    <h2 class="text-danger"> <i class="fa fa-warning"></i> Nenhum Registro Encontrado!</h2>
                                </div>
                        </tr>
                    @endforelse


                    </tbody>
                </table>
                {!! $visitas->render() !!}
            </div>

            <!-- /.box -->
        </div>
    </div>









    <div class="modal fade" id="myModalEditar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog modal-lg " role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">CADASTRO DE VISITANTES</h4>
                </div>
                {!! Form::open(['route'=>['visitas.visitas_update'], 'id'=>'formModalAtualizar', 'enctype' => 'multipart/form-data' ]) !!}
                <div class="modal-body" id="modalbody">
                    Informações Pessoais
                    <div class="widget-box widget-color-dark ">


                        <div class="widget-body">
                            <div class="widget-main no-padding">
                                <fieldset>

                                        <div class="col-md-3">
                                            <div class="form-group">
                                                {!! Form::label('id','Código do Visitante')  !!}
                                                {{ Form::text('id', null, ['id'=>'id', 'class' => 'form-control', 'readonly']) }}
                                            </div>
                                        </div>

                                        <div class="col-md-9">
                                            <div class="form-group">
                                                {!! Form::label('nomevisita','Nome do (a) Visitante')  !!}
                                                {{ Form::text('nomevisita', null, ['id'=>'nomevisita', 'class' => 'form-control']) }}
                                            </div>
                                        </div>


                                        <div class="col-md-4">
                                            <div class="form-group">
                                                {!! Form::label('cpfvisita','CPF')  !!}
                                                {{ Form::text('cpfvisita', null, ['id'=>'cpfvisita','class' => 'form-control cpf']) }}
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="form-group">
                                                {!! Form::label('rgvisita', 'RG')  !!}
                                                {{ Form::text('rgvisita', null, ['id'=>'rgvisita','class' => 'form-control']) }}

                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="form-group">
                                                {!! Form::label('datanascimentovisita', 'Data de Nascimento')  !!}
                                                {{ Form::text('datanascimentovisita', null, ['id'=>'datanascimentovisita','class' => 'form-control date naoValidar']) }}
                                            </div>
                                        </div>


                                        <div class="col-md-6">
                                            <div class="form-group">
                                                {!! Form::label('enderecovisita', 'Logradouro')  !!} <small class="text-danger">Ex: Rua Olavo Bilac, 5888 - Centro</small>
                                                {{ Form::text('enderecovisita', null, ['id'=>'enderecovisita','class' => 'form-control']) }}
                                            </div>
                                        </div>

                                        <div class="col-md-2">
                                            <div class="form-group">
                                                {!! Form::label('ufvisita', 'UF')  !!}
                                                {{ Form::select('ufvisita', \App\Model\Visita::$ufs, null, ['id'=>'ufvisita','class' => 'form-control']) }}
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                {!! Form::label('cidadevisita', 'Cidade da Visitante')  !!}
                                                {{ Form::text('cidadevisita', null, ['id'=>'cidadevisita','class' => 'form-control']) }}
                                            </div>
                                        </div>

                                        <div class="col-md-3">
                                            <div class="form-group">
                                                {!! Form::label('dataemicaocarteirinha', 'Data da Carteirinha')  !!}
                                                {{ Form::text('dataemicaocarteirinha', null, ['id'=>'dataemicaocarteirinha','class' => 'form-control date naoValidar']) }}
                                            </div>
                                        </div>

                                        <div class="col-md-5">
                                            <div class="form-group">
                                                {!! Form::label('telefonecontato', 'Telefones de Contato')  !!} <small class="text-danger" > Ex: 69 9.9999-9999 / 69 9.9999-9999</small>
                                                {{ Form::text('telefonecontato', null, ['id'=>'telefonecontato','class' => 'form-control']) }}
                                            </div>
                                        </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <div>
                                                <img class="img-responsive editable-empty" id="fotovisita" src="" />
                                            </div>
                                            {!! Form::label('fotovisita','Buscar Foto')  !!}
                                            <input type="file" id="fotovisita" name="fotovisita" class="form-control naoValidar"  >
                                        </div>
                                    </div>
                                </fieldset>
                            </div>
                        </div>
                    </div>


                </div>
                <div class="modal-footer">
                    <button class="btn btn-success" id="btnModalAtualizar" type="submit"> ATUALIZAR</button>
                </div>
                {{ Form::close() }}
            </div>
        </div>
    </div>



@stop


@section('scripts')
    {{ HTML::script('js/visitas/script.js') }}

    {{ HTML::script('js/datepickerJS/bootstrap-datepicker.min.js') }}
    {{ HTML::script('js/datepickerJS/bootstrap-datepicker.pt-BR.min.js') }}

    {{ HTML::script('js/mask/maskedinput.min.js') }}
@stop


