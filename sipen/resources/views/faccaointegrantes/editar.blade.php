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
              <a href="{!! route('faccaointegrantes.listar' ) !!}" class="btn btn-xs btn-light bigger"> <i class="ace-icon fa fa-arrow-left"></i> Voltar </a>
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




        <div class="col-md-12">
            <div class="widget-box widget-color-blue2 ">
                <div class="widget-header">
                    <h4 class="widget-title">DADOS PESSOAIS</h4>
                </div>

                <div class="widget-body">
                    <div class="widget-main no-padding">
                        <fieldset>

                            <div class="col-md-2">
                                <div class="form-group">
                                    {!! Form::label('idApenc','Código')  !!}
                                    {!! Form::text('idApenc', $integrante->idApen, ['class' => 'form-control','id'=>'idApenc', 'readonly']) !!}
                                </div>
                            </div>
                                <div class="col-md-7">
                                    <div class="form-group">
                                        {!! Form::label('nomeapenado','Nome do Apenado')  !!}
                                        {!! Form::text('nomeapenadoc', $integrante->nomeapenado, ['class' => 'form-control','id'=>'nomeapenado', 'readonly']) !!}
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        {!! Form::label('alcunhaa','Alcunha')  !!}
                                        {!! Form::text('alcunhaa', null, ['class' => 'form-control','readonly']) !!}
                                    </div>
                                </div>

                        </fieldset>
                    </div>
                </div>
            </div>
        </div>




        <div class="col-md-12">

            <div class="widget-box widget-color-dark ">
                <div class="widget-header">
                    <h4 class="widget-title">INFORMAÇÕES DE INGRESSO NA FACÇÃO</h4>
                </div>

                <div class="widget-body">
                    <div class="widget-main no-padding">
                        {!! Form::open(['route'=>['faccaointegrantes.update', $integrante->id], 'id'=>'formulario', 'method'=>'put']) !!}

                                <fieldset>

                                    <input type="hidden" name="idApen" value="{{ $integrante->idApen }}">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label><smal>Facção Atual</smal></label><br>
                                            <button class="btn disabled btn-warning btn-block">{{ $integrante->nomefaccao  }}</button>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label><smal>Cargo Atual</smal></label><br>
                                            {{--<button class="btn disabled btn-primary btn-block">{{ $integrante->nomecargo }}</button>--}}
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label><smal>Padrinho Atual</smal></label><br>
                                            {{--<button class="btn disabled btn-defaul btn-block">{{ $padrinho }}</button>--}}
                                        </div>
                                    </div>


                                    <div class="hr hr-18 hr-double dotted"></div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            {!! Form::label('faccao_id','Selecione a Facção')  !!}
                                            <select name="faccao_id" id="faccao_id" class="form-control naoValidar">
                                                <option value="">Manter Atual</option>
                                                @foreach($faccoes as $faccao)
                                                    <option value="{!! $faccao->id !!}"> {!! $faccao->nomefaccao !!} </option>
                                                @endforeach
                                            </select>

                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            {!! Form::label('cargo_faccao_id','Selecione o Cargo na Facção')  !!}
                                            <select name="cargo_faccao_id" id="cargo_faccao_id" class="form-control naoValidar">
                                                <option value="">Manter Atual</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            {!! Form::label('padrinho', 'Padrinho de Ingresso na Facção - Indicação Interna')  !!}
                                            <select name="padrinho" id="padrinho" class="form-control naoValidar">
                                                <option value="">Manter Atual</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <div class="hr hr-18 hr-double dotted"></div>
                                        </div>
                                    </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    {!! Form::label('matricula', 'Chapa / Número de Batismo ou Matricula')  !!}
                                    {{ Form::text('matricula', null, ['class' => 'form-control naoValidar']) }}

                                </div>
                            </div>

                            <div class="col-md-2">
                                <div class="form-group">
                                   {!! Form::label('localbatismo', 'Local do Batismo')  !!}
                                    {{ Form::text('localbatismo', null, ['class' => 'form-control naoValidar']) }}
                                </div>
                            </div>

                            <div class="col-md-2">
                                <div class="form-group">
                                    {!! Form::label('databatismo', 'Data do Batismo')  !!}
                                    {{ Form::text('databatismo',  strftime('%d/%m/%Y',strtotime($integrante->databatismo)), ['class' => 'form-control date naoValidar']) }}
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    {!! Form::label('nomedebatismo', 'Nome de Batismo')  !!}
                                    {{ Form::text('nomedebatismo', null, ['class' => 'form-control naoValidar']) }}
                                </div>
                            </div>


                            <div class="col-md-12">
                                <div class="form-group">
                                    {!! Form::label('referencia', 'Padrinho de Ingresso na Facção - Indicação Externa / Referência')  !!}
                                    {{ Form::text('referencia', null, ['class' => 'form-control naoValidar']) }}
                                </div>
                            </div>

                            {{--<div class="col-md-12">--}}
                                {{--<div class="form-group">--}}
                                    {{--{!! Form::label('descricaorelevante', 'Descrição / Informações Relevantes')  !!}--}}
                                    {{--{{ Form::textarea('descricaorelevante', $integrante[0]->descricaorelevante, ['class' => 'form-control']) }}--}}
                                {{--</div>--}}
                            {{--</div>--}}


                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <div class="hr hr-18 hr-double dotted"></div>
                                        </div>
                                    </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                {!! Form::label('faccao_possiveis_id','Classificação de Faccionado')  !!}
                                                {{ Form::select('faccao_possiveis_id',$possiveis ,null, ['class' => 'form-control']) }}
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                {!! Form::label('faccao_classificacao_id','Catalogado')  !!}
                                                {{ Form::select('faccao_classificacao_id', $classificacoes, null, ['class' => 'form-control']) }}
                                            </div>
                                        </div>



                    </fieldset>

                        <div class="form-actions center">
                            <input  class="btn btn-success" type="submit" id="btnEnviar" value="Salvar" >
                        </div>
                    {!! Form::close() !!}

                        <!-- /.row -->
                    </div>
                    <!-- /.box-body -->
                </div>

            </div>

        </div>





    <script src={{asset('resources/assets/js/jquery.js')}}></script>


@endsection

@section('scripts')
    {{ HTML::script('resources/assets/js/validacao/validacao.js') }}
    {{ HTML::script('resources/assets/chosen/chosen.jquery.js') }}
    {{ HTML::script('resources/assets/chosen/chosen.js') }}

    {{ HTML::script('resources/assets/js/selectGeral.js') }}

    {{ HTML::script('resources/assets/js/datepickerJS/bootstrap-datepicker.min.js') }}
    {{ HTML::script('resources/assets/js/datepickerJS/bootstrap-datepicker.pt-BR.min.js') }}

    {{ HTML::script('resources/assets/js/mask/maskedinput.min.js') }}
    {{ HTML::script('resources/assets/js/validacao/formatainput.js') }}

@stop