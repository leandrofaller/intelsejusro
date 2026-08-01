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
                                        {!! Form::text('datanascimentoc', strftime('%d/%m/%Y',strtotime($apenado->datanascimento)) , ['class' => 'form-control', 'readonly']) !!}
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
                    <h4 class="widget-title">INCLUIR ALCUNHA</h4>
                </div>

                <div class="widget-body">
                    <div class="widget-main no-padding">
                        {!! Form::open(['route'=>['apenados.alcunhasSalvar', $apenado->id ], 'id'=>'formulario' ]) !!}
                            <fieldset>
                                <input type="hidden" value="{{ $apenado->id }}" name="idApenado">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        {!! Form::label('nome_alcunha', 'Nova Alcunha')  !!}<span class="text-danger">*</span>
                                        {!! Form::text('nome_alcunha', null , ['class' => 'form-control', 'maxlength'=>'30' ]) !!}
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
                    <h4 class="widget-title">ALCUNHAS CADASTRADAS</h4>
                </div>

                <div class="widget-body">
                    <div class="widget-main no-padding">

                        <div class="table-responsive">
                            <table id="simple-table" class="table table-striped table-bordered table-hover">
                                <thead>
                                <tr class="">
                                    <th>#</th>
                                    <th>NOME DA ALCUNHA</th>
                                    <th>SITUAÇÃO</th>
                                    <th>DATA CADASTRO</th>
                                    <th> </th>
                                </tr>
                                </thead>
                                <tbody>
                                @forelse($alcunhas as $dado)
                                    <tr>
                                        <td>{!! $dado->id !!}</td>
                                        <td>{!! $dado->nome_alcunha !!}</td>
                                        <td>{!! $dado->atual_alcunha !!}</td>
                                        <td>{!! dataFormat($dado->created_at) !!}</td>
                                        <td>
                                            @if(Auth::user()->perfil == 'Admin')
                                            <a href="{{route('apenados.alcunhaPrincipal', [$dado->id, $dado->apenado_id ]) }}" type="submit"
                                               onclick="return confirm('Deseja realmente executar esta ação?');"
                                               class="btn btn-info btn-sm"><i class="fa fa-check-circle"></i> </a>
                                                <a href="{{route('apenados.alcunhaDestroy', [$dado->id, $dado->apenado_id ]) }}" type="submit"
                                                   onclick="return confirm('Deseja realmente executar esta ação?');"
                                                   class="btn btn-danger btn-sm"><i class="fa fa-trash-o"></i> </a>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="12">
                                            <div class="well text-center ">
                                                <h4 class="text-danger"> <i class="fa fa-warning"></i> Nenhuma Mudança de Cela!</h4>
                                            </div>
                                        </td>
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

    {{--{{ HTML::script('chosen/chosen.jquery.js') }}--}}
    {{--{{ HTML::script('chosen/chosen.js') }}--}}

    {{ HTML::script('resources/assets/js/datepickerJS/bootstrap-datepicker.min.js') }}
    {{ HTML::script('resources/assets/js/datepickerJS/bootstrap-datepicker.pt-BR.min.js') }}

    {{ HTML::script('resources/assets/js/mask/maskedinput.min.js') }}
    {{ HTML::script('resources/assets/js/validacao/formatainput.js') }}
    {{ HTML::script('resources/assets//js/validacao/validacao.js') }}
@stop