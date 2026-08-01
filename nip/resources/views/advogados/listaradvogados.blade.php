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
                {!!Form::open ( ['route'=>'advogados.listaradvogados','method' => 'GET','id'=>'formulario'] ) !!}
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
                        <th>NOME DO ADVOGADO</th>
                        <th>OAB</th>
                        <th>CPF</th>
                        <th>ENDERECO</th>
                        <th>TELEFONE CONTATO</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($advogados as $advogado)
                        <tr>

                            <td data-id={{$advogado->idAdv}}> {!! $advogado->idAdv !!}</td>
                            <td data-nomeadvogado="{{$advogado->nomeadvogado}}" >{!! $advogado->nomeadvogado !!}</td>
                            <td data-oab="{{$advogado->oab}}" >{!! $advogado->oab !!}</td>
                            <td data-cpfadvogado="{{$advogado->cpfadvogado}}" >{!! $advogado->cpfadvogado !!}</td>
                            <td data-enderecoadvogado="{{$advogado->enderecoadvogado}}" >{!! $advogado->enderecoadvogado !!}</td>
                            <td data-telefoneadvogado="{{$advogado->telefoneadvogado}}" >{!! $advogado->telefoneadvogado !!}</td>

                            <td class="hidden" data-rgadvogado="{{$advogado->rgadvogado}}"> {!! $advogado->rgadvogado !!}</td>
                            <td class="hidden" data-foto="{{asset($advogado->foto)}}"> {!! $advogado->foto !!}</td>
                            <td class="hidden" data-seccional="{{$advogado->seccional}}"> {!! $advogado->seccional !!}</td>
                            <td class="hidden" data-datacadastroadvogado="{{strftime('%d/%m/%Y',strtotime($advogado->datacadastroadvogado))}}"> {!! strftime('%d/%m/%Y',strtotime($advogado->datacadastroadvogado)) !!}</td>

                            <td>
                                <a href="#" title="Alterar Cadastro do Advogado" name="btnEditar" class="btn btn-xs btn-info"> <i class="ace-icon fa fa-pencil-square bigger-120"></i> </a>
                                <a href="{{ route('advogados.detalhaclientes', $advogado->idAdv) }}" title="Mostrar Apenados Atendidos" class="btn btn-xs btn-warning"> <i class="ace-icon fa fa-bars bigger-120"></i> </a>
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
                {!! $advogados->render() !!}
            </div>

            <!-- /.box -->
        </div>
    </div>









    <div class="modal fade" id="myModalEditar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog modal-lg " role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">CADASTRO DE ADVOGADOS</h4>
                </div>
                {!! Form::open(['route'=>['advogados.advogados_update'], 'id'=>'formModalAtualizar', 'enctype' => 'multipart/form-data' ]) !!}
                <div class="modal-body" id="modalbody">
                    Informações Pessoais para Edição
                    <div class="widget-box widget-color-dark ">


                        <div class="widget-body">
                            <div class="widget-main no-padding">
                                <fieldset>

                                    <div class="col-md-4">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <div>
                                                    <img class="img-responsive editable-empty" id="foto" src="" />
                                                </div>
                                                {!! Form::label('foto','Buscar Foto')  !!}
                                                <input type="file" id="foto" name="foto" class="form-control naoValidar"  >
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                {!! Form::label('id','Código ')  !!}
                                                {{ Form::text('id', null, ['id'=>'id', 'class' => 'form-control', 'readonly']) }}
                                            </div>
                                        </div>

                                        <div class="col-md-9">
                                            <div class="form-group">
                                                {!! Form::label('nomeadvogado','Nome do (a) Advogado')  !!}
                                                {{ Form::text('nomeadvogado', null, ['id'=>'nomeadvogado', 'class' => 'form-control']) }}
                                            </div>
                                        </div>


                                        <div class="col-md-4">
                                            <div class="form-group">
                                                {!! Form::label('cpfadvogado','CPF')  !!}
                                                {{ Form::text('cpfadvogado', null, ['id'=>'cpfadvogado','class' => 'form-control cpf']) }}
                                            </div>
                                        </div>

                                        <div class="col-md-3">
                                            <div class="form-group">
                                                {!! Form::label('rgadvogado', 'RG')  !!}
                                                {{ Form::text('rgadvogado', null, ['id'=>'rgadvogado','class' => 'form-control']) }}

                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                {!! Form::label('oab', 'OAB')  !!}
                                                {{ Form::text('oab', null, ['id'=>'oab','class' => 'form-control']) }}

                                            </div>
                                        </div>

                                        <div class="col-md-2">
                                            <div class="form-group">
                                                {!! Form::label('seccional', 'Seccional')  !!}
                                                {{ Form::text('seccional', null, ['id'=>'seccional','class' => 'form-control']) }}
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                {!! Form::label('enderecoadvogado', 'Logradouro')  !!} <small class="text-danger">Ex: Rua Olavo Bilac, 5888 - Centro</small>
                                                {{ Form::text('enderecoadvogado', null, ['id'=>'enderecoadvogado','class' => 'form-control']) }}
                                            </div>
                                        </div>


                                        <div class="col-md-6">
                                            <div class="form-group">
                                                {!! Form::label('telefoneadvogado', 'Telefone de Contato')  !!}
                                                {{ Form::text('telefoneadvogado', null, ['id'=>'telefoneadvogado','class' => 'form-control']) }}
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                {!! Form::label('datacadastroadvogado', 'Data de Cadastro')  !!}
                                                {{ Form::text('datacadastroadvogado', null, ['id'=>'datacadastroadvogado','class' => 'form-control date naoValidar']) }}
                                            </div>
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
    {{ HTML::script('js/advogados/script.js') }}

    {{ HTML::script('js/datepickerJS/bootstrap-datepicker.min.js') }}
    {{ HTML::script('js/datepickerJS/bootstrap-datepicker.pt-BR.min.js') }}

    {{ HTML::script('js/mask/maskedinput.min.js') }}
@stop


