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

                                <div class="col-md-9">
                                    <div class="form-group">
                                        {!! Form::label('nomeapenado','Nome do Apenado')  !!}
                                        {!! Form::text('nomeapenadoc', $apenado->nomeapenado, ['class' => 'form-control','id'=>'nomeapenado', 'readonly']) !!}
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        {!! Form::label('cpf','Cpf')  !!}
                                        {!! Form::text('cpfc', $apenado->cpf, ['class' => 'form-control cpf','id'=>'cpf','readonly']) !!}
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        {!! Form::label('numprocesso','Processo / Execução')  !!}
                                        {!! Form::text('numprocesso', $apenado->numeroprocesso, ['class' => 'form-control cpf','id'=>'cpf','readonly']) !!}
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        {!! Form::label('datanascimento','Nascimento')  !!}
                                        {!! Form::text('datanascimentoc', $apenado->dataentrada ? dataFormat($apenado->datanascimento) : null , ['class' => 'form-control', 'readonly']) !!}
                                    </div>
                                </div>
                                <div class="col-md-5">
                                    <div class="form-group">
                                        {!! Form::label('unidade','Unidade Prisional')  !!}
                                        {!! Form::text('unidade', $apenado->nomeunidade , ['class' => 'form-control', 'readonly']) !!}
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


        <div class="col-md-12">
            <div class="widget-box widget-color-blue ">
                <div class="widget-header">
                    <h4 class="widget-title">MUDANÇA DE CELA</h4>
                </div>

                <div class="widget-body">
                    <div class="widget-main no-padding">
                        {!! Form::open(['route'=>['apenados.mudarcelaSalvar', $apenado->id ], 'id'=>'formulario' ]) !!}
                            <fieldset>
                                <input type="hidden" value="{{ $apenado->idMovimentacao }}" name="idMovimentacao">


                                <div class="col-md-3">
                                    <div class="form-group">
                                        {!! Form::label('datamudanca','Data da Mudança')  !!}<span class="text-danger">*</span>
                                        {!! Form::text('datamudanca', null, ['class' => 'form-control date']) !!}
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        {!! Form::label('motivomudanca', 'Motivo da Mudança')  !!}<span class="text-danger">*</span>
                                        {{ Form::select('motivomudanca', \App\Model\Cela::$motivomudancadecela, null, ['class' => 'form-control']) }}
                                    </div>
                                </div>

                                <div class="col-md-6" id="outros" hidden>
                                    <div class="form-group">
                                        {!! Form::label('descricao', 'Descrição')  !!}
                                        {!! Form::text('descricao', null , ['class' => 'form-control naoValidar', 'maxlength'=>'30' ]) !!}
                                    </div>
                                </div>


                                <div class="col-md-3">
                                    <div class="form-group">
                                       {!! Form::label('carceragem_id', 'Carceragem de Destino')  !!} <span class="text-danger">*</span>
                                       <select name="carceragem_id" id="carceragem_id" class="form-control">
                                            <option value=""></option>
                                               @foreach($carceragens as $carceragen)
                                                  <option value="{{ $carceragen->id }}"> {{$carceragen->nomecarceragem}} </option>
                                               @endforeach
                                       </select>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                       {!! Form::label('cela_id','Cela de Destino')  !!} <span class="text-danger">*</span>
                                          <select name="cela_id" id="cela_id" class="form-control"> </select>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        {!! Form::label('autorizadopor','Autorizado por?')  !!}
                                        {!! Form::text('autorizadopor', null , ['class' => 'form-control naoValidar' ]) !!}
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        {!! Form::label('transferidopor','Transferido por?')  !!}
                                        {!! Form::text('transferidopor', null , ['class' => 'form-control naoValidar' ]) !!}
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





        <div class="col-md-12">
            <div class="widget-box widget-color-dark ">
                <div class="widget-header">
                    <h4 class="widget-title">HISTÓRICO DE MUDANÇA DE CELAS</h4>
                </div>

                <div class="widget-body">
                    <div class="widget-main no-padding">

                        <div class="table-responsive">
                            <table id="simple-table" class="table table-striped table-bordered table-hover">
                                <thead>
                                <tr class="">
                                    <th>#</th>
                                    <th>DATA DE MUDANÇA</th>
                                    <th>MOTIVO DA MUDANÇA</th>
                                    <th>CELA DE</th>
                                    <th>CELA PARA</th>
                                    <th>AUTORIZADO POR</th>
                                    <th>TRANSFERIDO POR</th>
                                    <th> </th>
                                </tr>
                                </thead>
                                <tbody>
                                @forelse($log as $dado)
                                    <tr>
                                        <td>{!! $dado->id !!}</td>
                                        <td>{!! strftime('%d/%m/%Y',strtotime($dado->datamudanca)) !!}</td>
                                        <td>{!! $dado->motivomudanca !!}</td>
                                        <td>{!! \App\Model\Apenado::nomecela($dado->celaDE) !!}</td>
                                        <td>{!! \App\Model\Apenado::nomecela($dado->celaPARA) !!}</td>
                                        <td>{!! $dado->autorizadopor !!}</td>
                                        <td>{!! $dado->transferidopor !!}</td>
                                        <td>
                                            @if(Auth::user()->perfil == 'Admin')
                                            <a href="{{route('apenados.mudarCeladestroy', ['id'=>$dado->id, 'idApen'=>$apenado->id ]) }}" type="submit"
                                               onclick="return confirm('Deseja realmente excluir este Histórico de Mudança de Cela?');"
                                               class="btn btn-danger btn-sm"><i class="fa fa-trash"></i> </a>
                                            @endif
                                        </td>
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









    <script src={{asset('resources/assets/js/jquery.js')}}></script>


@endsection

@section('scripts')

    {{ HTML::script('resources/assets/js/selectGeral.js') }}
    {{ HTML::script('resources/assets/js/apenados/script.js') }}

    {{ HTML::script('resources/assets/js/datepickerJS/bootstrap-datepicker.min.js') }}
    {{ HTML::script('resources/assets/js/datepickerJS/bootstrap-datepicker.pt-BR.min.js') }}

    {{ HTML::script('resources/assets/js/mask/maskedinput.min.js') }}
    {{ HTML::script('resources/assets/js/validacao/formatainput.js') }}
    {{ HTML::script('resources/assets/js/validacao/validacao.js') }}
@stop