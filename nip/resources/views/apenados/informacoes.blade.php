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

                                <div class="col-md-12">
                                    <div class="form-group">
                                        {!! Form::label('nomeapenado','Nome do Apenado')  !!}
                                        {!! Form::text('nomeapenadoc', $apenado->nomeapenado, ['class' => 'form-control','id'=>'nomeapenado', 'readonly']) !!}
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
                                        {!! Form::label('numprocesso','Processo / Execução')  !!}
                                        {!! Form::text('numprocesso', $apenado->numeroprocesso, ['class' => 'form-control cpf','id'=>'cpf','readonly']) !!}
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        {!! Form::label('datanascimento','Nascimento')  !!}
                                        {!! Form::text('datanascimentoc', $apenado->datanascimento ? strftime('%d/%m/%Y',strtotime($apenado->datanascimento)) : null , ['class' => 'form-control', 'readonly']) !!}
                                    </div>
                                </div>
                                <div class="col-md-3">
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
            <div class="widget-box widget-color-dark ">
                <div class="widget-header">
                    <h4 class="widget-title"> <i class="fa fa-info-circle" ></i> INFORMAÇÕES ADICIONAIS </h4>
                    <span class="pull-right">
                        <a class="btn btn-success bigger" name="btnEditar"> <i class="ace-icon fa fa-plus"></i> INSERIR INFORMAÇÕES</a>
                </span>
                </div>


                <div class="widget-body">
                    <div class="widget-main no-padding">

                        <div class="table-responsive">
                            @if(count($informacoes)> 0)
                                <div class="timeline-container">
                                    <div class="timeline-label">
							<span class="label label-grey arrowed-in-right label-lg">
							    INFORMAÇÕES CADASTRADAS
							</span>
                                    </div>

                                    <div class="timeline-items">

                                        @forelse($informacoes as $informacao)

                                            <div class="timeline-item clearfix">
                                                <div class="timeline-info">
                                                    <i class="timeline-indicator ace-icon fa fa-rocket btn btn-primary no-hover green"></i>
                                                </div>

                                                <div class="widget-box transparent">
                                                    <div class="widget-header widget-header-small">
                                                        <h5 class="widget-title smaller">{!! $informacao->nome !!} - <b> {!! \App\Model\Unidade::mostraNomeUnidade($informacao->unidade_id)  !!} </b> </h5>
                                                        <span class="widget-toolbar no-border">
                                                <i class="ace-icon fa fa-clock-o bigger-110"></i> {!! strftime('%d/%m/%Y',strtotime($informacao->datacadastro)) !!}
                                            </span>
                                                        <span class="widget-toolbar">
                                                             <a href="{{route('apenados.destroyInformacaoCadastro', ['idApen'=>$apenado->id, 'idInfo'=>$informacao->idInf]) }}" type="submit"
                                                                onclick="return confirm('Deseja realmente excluir esta Informação?');"
                                                                class="text-danger"><i class="fa fa-trash"></i> </a>
                                                <a href="#" data-action="collapse"> <i class="ace-icon fa fa-chevron-up"></i> </a>
                                            </span>
                                                    </div>

                                                    <div class="widget-body">
                                                        <div class="widget-main">
                                                            {!! $informacao->descricaoinfo !!}
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        @empty
                                            <h2 class="text-danger text-center"> <i class="fa fa-warning"></i> Nenhum Registro Cadastrado!</h2>
                                        @endforelse

                                    </div><!-- /.timeline-items -->
                                </div>

                            @else
                                <div class="well text-center ">
                                    <h4 class="text-danger"> <i class="fa fa-warning"></i> Nenhuma Informação Adicional!</h4>
                                </div>
                            @endif
                        </div>

                    </div>
                    <!-- /.box-body -->
                </div>

            </div>

        </div>






    <div class="modal fade" id="myModalEditar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog modal-lg " role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title"> <i class="fa fa-info-circle" ></i> INFORMAÇÕES ADICIONAIS</h4>
                </div>
                {!! Form::open(['route'=>['apenados.informacoes_inserir'], 'id'=>'formModalAtualizar']) !!}
                <div class="modal-body" id="modalbody">
                    NOVA INFORMAÇÃO
                    <div class="widget-box widget-color-dark ">
                        <div class="widget-body">
                            <div class="widget-main no-padding">
                                <fieldset>
                                    <input type="hidden" name="idapenid" id="idapenid" value="{!! $apenado->id !!}">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            {!! Form::label('descricaoinfo','Digite as Informações')  !!}
                                            {{ Form::textarea('descricaoinfo', null, ['id'=>'descricaoinfo', 'rows'=>'5', 'class' => 'form-control']) }}
                                        </div>
                                    </div>
                                </fieldset>
                            </div>
                        </div>
                    </div>


                </div>
                <div class="modal-footer">
                    <button class="btn btn-success" id="btnModalAtualizar" type="submit"> SALVAR</button>
                </div>
                {{ Form::close() }}


                <div class="modal-body" id="modalbody">


                </div>

            </div>
        </div>
    </div>


    <script src={{asset('resources/assets/js/jquery.js')}}></script>


@endsection

@section('scripts')

    {{ HTML::script('resources/assets/js/informacoes/script.js') }}

    {{--{{ HTML::script('/js/validacao/validacao.js') }}--}}
    {{--{{ HTML::script('chosen/chosen.jquery.js') }}--}}
    {{--{{ HTML::script('chosen/chosen.js') }}--}}

    {{--{{ HTML::script('js/datepickerJS/bootstrap-datepicker.min.js') }}--}}
    {{--{{ HTML::script('js/datepickerJS/bootstrap-datepicker.pt-BR.min.js') }}--}}

    {{--{{ HTML::script('js/mask/maskedinput.min.js') }}--}}
    {{--{{ HTML::script('js/validacao/formatainput.js') }}--}}

@stop