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
              <a href="{!! route('faccaointegrantes.index' ) !!}" class="btn btn-xs btn-light bigger"> <i class="ace-icon fa fa-arrow-left"></i> Voltar </a>
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




        <div class="col-md-3">
            <div class="widget-box widget-color-dark ">
                <div class="widget-header">
                    <h4 class="widget-title">FOTO</h4>
                </div>

                <div class="widget-body">
                    <div class="widget-main no-padding">
                        <fieldset>
                                <div>
                                    <img class="img-responsive editable-empty" style="height: 298px;" src="{!! asset('public/'.\App\Model\Apenado::mostraFotoPrincipal($apenado->id)) !!}"/>
                                </div>
                        </fieldset>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-9">
            <div class="widget-box widget-color-dark ">
                <div class="widget-header">
                    <h4 class="widget-title">DADOS PESSOAIS</h4>
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

                                <div class="col-md-6">
                                    <div class="form-group">
                                        {!! Form::label('alcunhaa','Alcunha')  !!} <br>
                                        @foreach(\App\Model\Integrantes::mostraAlcunhas($apenado->id) as $alcunha)
                                            <span class="label label-info">{{ $alcunha->nome_alcunha }}</span>
                                        @endforeach
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        {!! Form::label('cpf','Cpf do Apenado')  !!}
                                        {!! Form::text('cpfc', $apenado->cpf, ['class' => 'form-control cpf','id'=>'cpf','readonly']) !!}
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        {!! Form::label('datanascimento','Nascimento')  !!}
                                        {!! Form::text('datanascimentoc', $apenado->datanascimento ? dataFormat($apenado->datanascimento) : null , ['class' => 'form-control', 'readonly']) !!}
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        {!! Form::label('mae','Nome Mae')  !!}
                                        {!! Form::text('mae', $apenado->nomemae , ['class' => 'form-control', 'readonly']) !!}
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        {!! Form::label('pai','Nome Pai')  !!}
                                        {!! Form::text('pai', $apenado->nomepai , ['class' => 'form-control', 'readonly']) !!}
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


    {!! Form::open(['route'=>['faccaointegrantes.salvar'], 'id'=>'formulario' ]) !!}

        <div class="col-md-12">
            <div class="widget-box widget-color-dark ">
                <div class="widget-header">
                    <h4 class="widget-title">INFORMAÇÕES DE INGRESSO NA FACÇÃO</h4>
                </div>

                <div class="widget-body">
                    <div class="widget-main no-padding">
                        <fieldset>
                            <input type="hidden" value="{{ $apenado->id }}" name="apenado_id">
                            <div class="col-md-4">
                                <div class="form-group">
                                    {!! Form::label('faccao_id','Selecione a Facção')  !!}
                                    <select name="faccao_id" id="faccao_id" class="form-control">
                                        <option value=""></option>
                                        @foreach($faccoes as $faccao)
                                            <option value="{!! $faccao->id !!}"> {!! $faccao->nomefaccao !!} </option>
                                        @endforeach
                                    </select>

                                </div>
                            </div>

                            <div class="col-md-8">
                                <div class="form-group">
                                    {!! Form::label('matricula', 'Placa / Chapa / Número de Batismo ou Matricula')  !!}
                                    {{ Form::text('matricula', null, ['class' => 'form-control naoValidar']) }}

                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                   {!! Form::label('localbatismo', 'Local do Batismo (Regional / UF)')  !!}
                                    {{ Form::text('localbatismo', null, ['class' => 'form-control naoValidar']) }}
                                </div>
                            </div>

                            <div class="col-md-2">
                                <div class="form-group">
                                    {!! Form::label('databatismo', 'Data do Batismo')  !!}
                                    {{ Form::text('databatismo', null, ['class' => 'form-control date naoValidar']) }}
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    {!! Form::label('nomedebatismo', 'Nome de Batismo')  !!}
                                    {{ Form::text('nomedebatismo', null, ['class' => 'form-control naoValidar']) }}
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    {!! Form::label('quebradaorigem', 'Quebrada Origem')  !!}
                                    {{ Form::text('quebradaorigem', null, ['class' => 'form-control naoValidar']) }}
                                </div>
                            </div>



                        </fieldset>

                        <div class="form-actions center">
                            <input  class="btn btn-success" type="submit" id="btnEnviar" value="Salvar" >
                        </div>

                        <!-- /.row -->
                    </div>
                    <!-- /.box-body -->
                </div>

            </div>

        </div>






    {!! Form::close() !!}





    <script src={{asset('resources/assets/js/jquery.js')}}></script>

@endsection

@section('scripts')
    {{ HTML::script('resources/assets/js/validacao/validacao.js') }}
    {{ HTML::script('resources/assets/chosen/chosen.jquery.js') }}
    {{ HTML::script('resources/assets/chosen/chosen.js') }}

    {{ HTML::script('resources/assets/js/datepickerJS/bootstrap-datepicker.min.js') }}
    {{ HTML::script('resources/assets/js/datepickerJS/bootstrap-datepicker.pt-BR.min.js') }}

    {{ HTML::script('resources/assets/js/mask/maskedinput.min.js') }}
    {{ HTML::script('resources/assets/js/validacao/formatainput.js') }}

@stop