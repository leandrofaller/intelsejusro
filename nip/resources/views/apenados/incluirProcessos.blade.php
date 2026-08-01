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
              <a href="{!! route('apenados.selecionarOpcao', $apenado->id) !!}" class="btn btn-xs btn-light bigger"> <i class="ace-icon fa fa-arrow-left"></i> Voltar </a>
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
            <div class="widget-box widget-color-dark ">
                <div class="widget-header">
                    <h4 class="widget-title">DADOS PESSOAIS</h4>
                </div>

                <div class="widget-body">
                    <div class="widget-main no-padding">
                        <fieldset>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        {!! Form::label('nomeapenado','Nome do Apenado')  !!}
                                        {!! Form::text('nomeapenadoc', $apenado->nomeapenado, ['class' => 'form-control','id'=>'nomeapenado', 'readonly']) !!}
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <div class="form-group">
                                        {!! Form::label('cpf','Cpf do Apenado')  !!}
                                        {!! Form::text('cpfc', $apenado->cpf, ['class' => 'form-control cpf','id'=>'cpf','readonly']) !!}
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        {!! Form::label('datanascimento','Nascimento')  !!}
                                        {!! Form::text('datanascimentoc', $apenado->datanascimento ? strftime('%d/%m/%Y',strtotime($apenado->datanascimento)) : null , ['class' => 'form-control', 'readonly']) !!}
                                    </div>
                                </div>
                                <div class="col-md-2">
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


        <div class="col-md-6">
            <div class="widget-box widget-color-dark ">
                <div class="widget-header">
                    <h4 class="widget-title">PROCESSOS </h4>
                </div>

                <div class="widget-body">
                    <div class="widget-main no-padding">
                        {!! Form::open(['route'=>['apenados.incluirProcessosSalvar', $apenado->id ], 'id'=>'formulario' ]) !!}
                            <fieldset>
                                <input type="hidden" name="apenado_id" id="apenado_id" value="{!! $apenado->id !!}">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        {!! Form::label('numeroprocesso', 'Número do Processo') !!} <label class="red">*</label>
                                        {!! Form::text('numeroprocesso', null, ['class' => 'form-control','id'=>'numeroprocesso']) !!}
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        {!! Form::label('artigos', 'Tipificação')  !!}
                                        {!! Form::text('artigos', null, ['class' => 'form-control naoValidar','id'=>'artigos']) !!}
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        {!! Form::label('vara','Vara')  !!}
                                        {!! Form::select('vara', \App\Model\Apenado::$varas, null, ['class' => 'form-control naoValidar','id'=>'vara']) !!}
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





        <div class="col-md-6">
            <div class="widget-box widget-color-dark ">
                <div class="widget-header">
                    <h4 class="widget-title"> <span class="badge badge-info"> {!! count($processos) !!} </span> PROCESSOS CADASTRADOS  </h4>
                </div>

                <div class="widget-body">
                    <div class="widget-main no-padding">

                        <div class="table-responsive">
                            <table id="simple-table" class="table table-striped table-bordered table-hover">
                                <thead>
                                <tr class="">
                                    <th>NÚMERO DO PROCESSO</th>
                                    <th>ARTIGOS</th>
                                    <th>Vara</th>
                                    <th></th>
                                </tr>
                                </thead>
                                <tbody>
                                @forelse($processos as $dado)
                                    <tr>
                                        <td>{!! $dado->numeroprocesso !!}</td>
                                        <td>{!! $dado->artigos !!}</td>
                                        <td>{!! $dado->vara !!}</td>
                                        <td class="col-md-1">{!! $dado->principal == 'S' ? '<span class="label label-success label-sm">PRINCIPAL</span>' : '' !!}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="12">
                                            <div class="well text-center ">
                                                <h4 class="text-danger"> <i class="fa fa-warning"></i> Nenhuma Mudança de Cela!</h4>
                                            </div>
                                    </tr>
                                @endforelse

                                </tbody>
                            </table>
                        </div>

                    </div>
                    <!-- /.box-body -->
                </div>

            </div>

        </div>









    <script src={{asset('js/jquery.js')}}></script>


@endsection

@section('scripts')

    {{ HTML::script('resources/assets/js/selectGeral.js') }}

    {{ HTML::script('resources/assets/js/validacao/validacao.js') }}
    {{--{{ HTML::script('chosen/chosen.jquery.js') }}--}}
    {{--{{ HTML::script('chosen/chosen.js') }}--}}

    {{--{{ HTML::script('js/datepickerJS/bootstrap-datepicker.min.js') }}--}}
    {{--{{ HTML::script('js/datepickerJS/bootstrap-datepicker.pt-BR.min.js') }}--}}

    {{--{{ HTML::script('js/mask/maskedinput.min.js') }}--}}
    {{--{{ HTML::script('js/validacao/formatainput.js') }}--}}

@stop