@extends('layouts.solicitaracesso')

@section('conteudo')

    <div class="page-header">
        <h1>
            {{ $title }}
            <small>
                <i class="ace-icon fa fa-angle-double-right"></i>

                <a href="{!! route('login') !!}" class="btn btn-default btn-sm">{{icon('arrow-left')}} VOLTAR </a>
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



        <div class="row">
            <div class="col-md-12">

                {!!Form::open ( ['route'=>('solicitaracesso.salvar'), 'id'=>'formulario', 'enctype' => 'multipart/form-data']) !!}

                <div class="panel panel-primary">
                    <div class="panel-heading">Dados Pessoais do Servidor</div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    {{ Form::label('nome', 'Nome') }} <small class="text-danger"> *</small>
                                    {{ Form::text('nome', null, ['placeholder' => 'Informe o nome', 'class' => 'form-control','maxlength'=>'100']) }}
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    {{ Form::label('Cpf', 'Cpf') }}
                                    <small class="text-danger"> *</small>
                                    {{ Form::text('cpf', null, ['placeholder' => 'Cpf', 'class' => 'form-control cpf']) }}
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    {{ Form::label('matricula', 'Matricula Funcional') }}
                                    <small class="text-danger"> *</small>
                                    {{ Form::text('matricula', null, ['placeholder' => 'matricula', 'class' => 'form-control', 'maxlength' => 9]) }}
                                </div>
                            </div>

                            <div class="col-md-2">
                                <div class="form-group">
                                {{ Form::label('dt_nascimento', 'Nascimento') }}
                                {{ Form::text('dt_nascimento', null, ['class' => 'form-control date']) }}
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    {{ Form::label('email', 'E-mail') }}<small class="text-danger"> *</small>
                                    {{ Form::text('email', null, ['placeholder' => 'email válido e único', 'class' => 'form-control','maxlength'=>'100']) }}
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    {{ Form::label('celular', 'Telefone para Contato') }}
                                    {{ Form::text('celular', null, ['class' => 'form-control celular']) }}
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="panel panel-primary">
                    <div class="panel-heading">Endereço</div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-5">
                                <div class="form-group">
                                    {{ Form::label('rua', 'Rua') }}
                                    {{ Form::text('rua', null, ['placeholder' => 'Rua', 'class' => 'form-control','maxlength'=>'100']) }}
                                </div>
                            </div>
                            <div class="col-md-1">
                                <div class="form-group">
                                    {{ Form::label('numero', 'Número') }}
                                    {{ Form::text('numero', null, ['placeholder' => '', 'class' => 'form-control number','maxlength'=>'5']) }}
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    {{ Form::label('complemento', 'Complemento') }}
                                    {{ Form::text('complemento', null, ['placeholder' => '', 'class' => 'form-control','maxlength'=>'100']) }}
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    {{ Form::label('bairro', 'Bairro') }}
                                    {{ Form::text('bairro', null, ['placeholder' => '', 'class' => 'form-control','maxlength'=>'100']) }}
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    {{ Form::label('estado', 'Estado') }}
                                    {{ Form::select('estado', $estados,0, ['id'=>'estado','class' => 'form-control chosen-select','data-placeholder'=>"Selecione o estado"]) }}
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="form-group">
                                    {{ Form::label('cidade_id', 'Cidade') }}
                                    {{ Form::select('cidade_id', [],null, ['id'=>'cidade','class' => 'form-control']) }}
                                </div>
                            </div>


                        </div>
                    </div>
                </div>


                <div class="panel panel-primary">
                    <div class="panel-heading">Unidade Prisional de Trabalho</div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    {{ Form::label('unidade_id', 'Unidade Prisional') }}
                                    {{ Form::select('unidade_id', $unidades,0, ['id'=>'unidade_id','class' => 'form-control chosen-select','data-placeholder'=>"Selecione a Unidade"]) }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="panel panel-primary">
                    <div class="panel-heading">Identificação</div>
                    <div class="panel-body">
                        <div class="row">

                            {{--<div class="col-md-6">--}}
                                {{--<div class="form-group">--}}
                                    {{--{{ Form::label('termo', 'Termos de Uso') }} <br>--}}
                                    {{--<input name="termo" id="termo" type="checkbox" value="SIM"> Declaro que estou de acordo com o termo de uso do sistema.--}}
                                {{--</div>--}}
                            {{--</div>--}}

                            <div class="col-md-6">
                                <div class="form-group">
                                    {!! Form::label('anexodocumento','Anexar Identificação Funcional')  !!}
                                    <input type="file" id="anexodocumento" name="anexodocumento" class="form-control"  >
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

                <div class="panel panel-default">
                    <div class="panel-heading">

                        <label class="block">
                            <input type="checkbox" id="termo" name="termo" class="ace" value="1">
                            <span class="lbl"> Estou ciente e concordo com os termos <a href="#" name="btnTermo" id="btnTermo" >Abrir Termo</a> </span>
                        </label>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-12">
                                <a href="{!! route('login') !!}" class="btn btn-default pull-left btn-sm">{{icon('arrow-left')}} VOLTAR </a>
                                <button type="submit" class="btn btn-primary btn-sm pull-right" id="btnEnviar"><i class="fa fa-save"></i> SOLICITAR ACESSO </button>
                            </div>
                        </div>
                    </div>
                    {{ Form::close() }}
                </div>

                <!-- /.box -->
            </div>
        </div>


    <div class="modal fade " id="myModalTermo" tabindex="-1" role="dialog" aria-labelledby="myModalTermo">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="pontoModalLabel">VISUALIZAÇÃO DO TERMO</h4>
                </div>
                <div class="modal-body">

                    <embed src="{!! asset('termo.pdf') !!}" width="100%" height="450" alt="pdf" pluginspage="http://www.adobe.com/products/acrobat/readstep2.html"> </embed>

                </div>

                <div class="modal-footer">
                </div>
            </div>
        </div>
    </div>


@endsection

@section('scripts')

    {{ HTML::script('resources/assets/js/datepickerJS/bootstrap-datepicker.min.js') }}
    {{ HTML::script('resources/assets/js/datepickerJS/bootstrap-datepicker.pt-BR.min.js') }}

    {{ HTML::script('resources/assets/js/mask/maskedinput.min.js') }}
    {{ HTML::script('resources/assets/js/validacao/formatainput.js') }}
    {{ HTML::script('resources/assets/js/validacao/validacao.js') }}

    {{ HTML::script('resources/assets/js/solicitaracesso/cidades.js') }}

@endsection