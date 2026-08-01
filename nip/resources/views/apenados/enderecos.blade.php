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
                                        {!! Form::text('datanascimentoc', $apenado->datanascimento ? strftime('%d/%m/%Y',strtotime($apenado->datanascimento)) : null , ['class' => 'form-control', 'readonly']) !!}
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
                    <h4 class="widget-title">INCLUIR ENDEREÇO</h4>
                </div>

                <div class="widget-body">
                    <div class="widget-main no-padding">
                        {!! Form::open(['route'=>['apenados.enderecosSalvar', $apenado->id ], 'id'=>'formulario' ]) !!}
                            <fieldset>
                                <input type="hidden" value="{{ $apenado->id }}" name="idApenado">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        {!! Form::label('rua_endereco', 'Tipo / Rua')  !!}<span class="text-danger">*</span>
                                        {!! Form::text('rua_endereco', null , ['class' => 'form-control', 'maxlength'=>'100' ]) !!}
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        {!! Form::label('numero_endereco', 'Número')  !!}<span class="text-danger">*</span>
                                        {!! Form::text('numero_endereco', null , ['class' => 'form-control', 'maxlength'=>'30' ]) !!}
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        {!! Form::label('complemento_endereco', 'Complemento')  !!}<span class="text-danger">*</span>
                                        {!! Form::text('complemento_endereco', null , ['class' => 'form-control', 'maxlength'=>'30' ]) !!}
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        {!! Form::label('bairro_endereco', 'Bairro')  !!}<span class="text-danger">*</span>
                                        {!! Form::text('bairro_endereco', null , ['class' => 'form-control', 'maxlength'=>'30' ]) !!}
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        {!! Form::label('uf_endereco','Estado') !!}
                                        {!! Form::select('uf_endereco', $estados, 0, ['class' => 'form-control ','id'=>'uf_endereco']) !!}
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        {!! Form::label('cidade_endereco','Cidade') !!}
                                        {!! Form::text('cidade_endereco', null, ['class' => 'form-control ','id'=>'cidade_endereco']) !!}
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
                    <h4 class="widget-title">ENDEREÇOS CADASTRADAS</h4>
                </div>

                <div class="widget-body">
                    <div class="widget-main no-padding">

                        <div class="table-responsive">
                            <table id="simple-table" class="table table-striped table-bordered table-hover">
                                <thead>
                                <tr class="">
                                    <th>#</th>
                                    <th>Tipo / Rua</th>
                                    <th>Número</th>
                                    <th>Complemento</th>
                                    <th>Bairro</th>
                                    <th>Estado</th>
                                    <th>Cidade</th>
                                    <th>Data Cadastro</th>
                                    <th> </th>
                                </tr>
                                </thead>
                                <tbody>
                                @forelse($enderecos as $dado)
                                    <tr>
                                        <td>{!! $dado->id !!}</td>
                                        <td>{!! $dado->rua_endereco !!}</td>
                                        <td>{!! $dado->numero_endereco !!}</td>
                                        <td>{!! $dado->complemento_endereco !!}</td>
                                        <td>{!! $dado->bairro_endereco !!}</td>
                                        <td>{!! $dado->uf_endereco !!}</td>
                                        <td>{!! $dado->cidade_endereco !!}</td>
                                        <td>{!! dataFormat($dado->created_at) !!}</td>
                                        <td>
                                            {{--@if(Auth::user()->perfil == 'Admin')--}}
                                            {{--<a href="{{route('apenados.alcunhaPrincipal', ['id'=>$dado->id ]) }}" type="submit"--}}
                                               {{--onclick="return confirm('Deseja realmente executar esta ação?');"--}}
                                               {{--class="btn btn-info btn-sm"><i class="fa fa-check-circle"></i> </a>--}}
                                            {{--@endif--}}
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