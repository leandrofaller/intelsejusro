@extends('layouts.template')

@section('conteudo')

    <div class="page-header">
        <h1>
            {{ $titulo }}
            <small>
                <i class="ace-icon fa fa-angle-double-right"></i>
                {{ $subtitulo }}
            </small>
            <span class="pull-right">
              <a href="{!! route('visitas.mostrarapenados' ) !!}" class="btn btn-xs btn-light bigger"> <i class="ace-icon fa fa-arrow-left"></i> Voltar </a>
            </span>
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






        <div class="col-md-9">
            <div class="widget-box widget-color-blue2 ">
                <div class="widget-header">
                    <h4 class="widget-title">APENADO</h4>
                </div>

                <div class="widget-body">
                    <div class="widget-main no-padding">
                        <fieldset>

                                <div class="col-md-12">
                                    <div class="form-group">
                                        {!! Form::label('nomeapenado','Nome do Apenado')  !!}
                                        {!! Form::text('nomeapenadoc', $apenado->nomeapenado, ['class' => 'form-control','id'=>'nomeapenado', 'readonly']) !!}
                                    </div>
                                </div>

                                <div class="col-md-8">
                                    <div class="form-group">
                                        {!! Form::label('unidadec','Unidade Prisional')  !!}
                                        {!! Form::text('unidadec', $apenado->nomeunidade , ['class' => 'form-control', 'readonly']) !!}
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        {!! Form::label('cela','Cela Atual')  !!}
                                        {!! Form::text('celac', $apenado->nomecela , ['class' => 'form-control', 'readonly']) !!}
                                    </div>
                                </div>
                        </fieldset>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="widget-box widget-color-blue2">
                <div class="widget-header">
                    <h4 class="widget-title">FOTO DO APENADO</h4>
                </div>

                <div class="widget-body">
                    <div class="widget-main no-padding">
                        <fieldset>
                                <div>
                                    <img class="img-responsive editable-empty" style="height: 150px;" src="{!! asset($apenado->foto) !!}"/>
                                </div>
                        </fieldset>
                    </div>
                </div>
            </div>
        </div>


    {!! Form::open(['route'=>['visitas.salvar'], 'id'=>'formulario', 'enctype' => 'multipart/form-data' ]) !!}

    <div class="col-md-3">
        <div class="widget-box widget-color-blue2">
            <div class="widget-header">
                <h4 class="widget-title">FOTO VISITANTE</h4>
            </div>

            <div class="widget-body">
                <div class="widget-main no-padding">
                    <fieldset>
                        <div class="col-md-12">
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

    <div class="col-md-9">
        <div class="widget-box widget-color-blue2 ">
            <div class="widget-header">
                <h4 class="widget-title">DADOS VISITANTE</h4>
            </div>

            <div class="widget-body">
                <div class="widget-main no-padding">


                                <div class="widget-body">
                                    <div class="widget-main no-padding">
                                        <fieldset>
                                            <input name="apenado_id" id="apenado_id" type="hidden" value={{$apenado->id}}>

                                            <div class="col-md-10">
                                                <div class="form-group">
                                                    {!! Form::label('nomevisita','Nome do (a) Visitante')  !!} <label class="red">*</label>
                                                    {{ Form::text('nomevisita', null, ['id'=>'nomevisita', 'class' => 'form-control']) }}
                                                </div>
                                            </div>

                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    {!! Form::label('parentescovisita', 'Grau de Parentesco')  !!} <label class="red">*</label>
                                                    {{ Form::text('parentescovisita', $tipovisita, ['id'=>'parentescovi sita','class' => 'form-control', 'readonly']) }}
                                                </div>
                                            </div>

                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    {!! Form::label('cpfvisita','CPF')  !!} <label class="red">*</label>
                                                    {{ Form::text('cpfvisita', null, ['id'=>'cpfvisita','class' => 'form-control cpf', 'readonly']) }}
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    {!! Form::label('sexovisitante', 'Sexo')  !!} <label class="red">*</label>
                                                    {{ Form::select('sexovisitante', \App\Model\Visita::$sexovisitante, null, ['id'=>'sexovisitante','class' => 'form-control']) }}
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    {!! Form::label('rgvisita', 'RG')  !!}
                                                    {{ Form::text('rgvisita', null, ['id'=>'rgvisita','class' => 'form-control']) }}

                                                </div>
                                            </div>

                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    {!! Form::label('orgaoexpedicaovisita', 'Orgão de Expedição')  !!}
                                                    {{ Form::text('orgaoexpedicaovisita', null, ['id'=>'orgaoexpedicaovisita','class' => 'form-control']) }}

                                                </div>
                                            </div>

                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    {!! Form::label('naturalidadevisita', 'Naturalidade')  !!}<label class="red">*</label>
                                                    {{ Form::text('naturalidadevisita', null, ['id'=>'naturalidadevisita','class' => 'form-control']) }}

                                                </div>
                                            </div>

                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    {!! Form::label('datanascimentovisita', 'Data de Nascimento')  !!} <label class="red">*</label>
                                                    {{ Form::text('datanascimentovisita', null, ['id'=>'datanascimentovisita','class' => 'form-control date naoValidar']) }}
                                                </div>
                                            </div>

                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    {!! Form::label('idade', 'Idade')  !!} <label class="red">*</label>
                                                    {{ Form::text('idade', 0, ['id'=>'idade','class' => 'form-control', 'readonly']) }}

                                                </div>
                                            </div>


                                            <div class="col-md-7">
                                                <div class="form-group">
                                                    {!! Form::label('telefonecontato', 'Telefones de Contato')  !!} <small class="text-danger" > Ex: 69 9.9999-9999 / 69 9.9999-9999</small>
                                                    {{ Form::text('telefonecontato', null, ['id'=>'telefonecontato','class' => 'form-control']) }}
                                                </div>
                                            </div>

                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    {!! Form::label('enderecovisita', 'Logradouro')  !!} <small class="text-danger">Ex: Rua Olavo Bilac, 5888 - Centro</small>
                                                    {{ Form::text('enderecovisita', null, ['id'=>'enderecovisita','class' => 'form-control']) }}
                                                </div>
                                            </div>

                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    {!! Form::label('ufvisita', 'UF')  !!} <label class="red">*</label>
                                                    {{ Form::select('ufvisita', \App\Model\Visita::$ufs, null, ['id'=>'ufvisita','class' => 'form-control']) }}
                                                </div>
                                            </div>
                                            <div class="col-md-9">
                                                <div class="form-group">
                                                    {!! Form::label('cidadevisita', 'Cidade da Visitante')  !!} <label class="red">*</label>
                                                    {{ Form::text('cidadevisita', null, ['id'=>'cidadevisita','class' => 'form-control']) }}
                                                </div>
                                            </div>


                                        </fieldset>
                                    </div>
                                </div>

                        <div class="modal-footer">
                            <button class="btn btn-success" id="btnEnviar" type="submit">SALVAR</button>
                        </div>


                </div>
            </div>
        </div>
    </div>



    {{ Form::close() }}







@endsection

@section('scripts')

    {{ HTML::script('js/visitas/script.js') }}


    {{ HTML::script('js/datepickerJS/bootstrap-datepicker.min.js') }}
    {{ HTML::script('js/datepickerJS/bootstrap-datepicker.pt-BR.min.js') }}

    {{ HTML::script('js/mask/maskedinput.min.js') }}
    {{ HTML::script('js/validacao/formatainput.js') }}
    {{ HTML::script('js/validacao/validacao.js') }}


@stop