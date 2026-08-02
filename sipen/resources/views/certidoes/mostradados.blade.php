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
              <a href="{!! route('certidoes.index' ) !!}" class="btn btn-xs btn-light bigger"> <i class="ace-icon fa fa-arrow-left"></i> Voltar </a>
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

                                <div class="col-md-3">
                                    <div class="form-group">
                                        {!! Form::label('alcunhaa','Alcunha')  !!}
                                        {!! Form::text('alcunhaa', $apenado->alcunha, ['class' => 'form-control','readonly']) !!}
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        {!! Form::label('cpf','Cpf do Apenado')  !!}
                                        {!! Form::text('cpfc', $apenado->cpf, ['class' => 'form-control cpf','id'=>'cpf','readonly']) !!}
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
                                    <img class="img-responsive" style="height: 150px;" src="{!! asset($apenado->foto) !!}"/>
                        </fieldset>
                    </div>
                </div>
            </div>
        </div>


    {!! Form::open(['route'=>['certidoes.emitir', $apenado->id]  ]) !!}

        <div class="col-md-12">
            <div class="widget-box widget-color-dark">
                <div class="widget-header">
                    <h4 class="widget-title">TIPO DE CERTIDÃO</h4>
                </div>


                    <div class="widget-body">
                        <div class="widget-main no-padding">
                            <div class="modal-body" id="modalbody">


                                <div class="widget-box">
                                    <div class="widget-body">
                                            <fieldset>
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        {!! Form::label('solicitante','Nome do(a) Solicitante')  !!}
                                                        {!! Form::text('solicitante', null, ['class' => 'form-control ','id'=>'solicitante']) !!}
                                                    </div>
                                                </div>
                                            </fieldset>
                                    </div>
                                </div>


                                SELECIONE O TIPO DE CERTIDÃO
                                <div class="widget-box widget-color-dark ">
                                    <div class="widget-body">
                                        <div class="widget-main no-padding">
                                            <fieldset>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <div class="radio">
                                                            <label>
                                                                <input name="radiotipo" id="radiotipoOculta" value="carceragem" type="radio" class="ace input-lg">
                                                                <span class="lbl bigger-120"> CARCERÁRIA</span>
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <div class="radio">
                                                            <label>
                                                                <input name="radiotipo" id="radiotipoMostra" value="comportamento" type="radio" class="ace input-lg">
                                                                <span class="lbl bigger-120"> COMPORTAMENTO</span>
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </fieldset>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>


                <div class="widget-body" id="blocoprocedimentos" hidden>
                    <div class="widget-main no-padding">
                        <div class="modal-body" id="modalbody">
                            INFORMAÇÕES DE PROCEDIMENTOS APURATÓRIOS

                            <div class="widget-box widget-color-dark ">
                                <div class="widget-body">
                                    <div class="widget-main no-padding">
                                        <fieldset>
                                            <div id="formProc">


                                                <fieldset>
                                                    <div class="table-responsive">
                                                        <table id="simple-table" class="table table-striped table-bordered table-hover">
                                                            <thead>
                                                            <tr class="">
                                                                <th></th>
                                                                <th>#</th>
                                                                <th>NÚM PAD</th>
                                                                <th>NÚM RELATÓRIO SEGURANÇA</th>
                                                                <th>DATA INÍCIO</th>
                                                                <th>DATA CONCLUSÃO</th>
                                                                <th>TIPO DE FATO</th>
                                                                <th>CLASSIFICAÇÃO DA FALTA</th>
                                                                <th>SITUAÇÃO</th>
                                                            </tr>
                                                            </thead>
                                                            <tbody>

                                                            @forelse($pads as $h)

                                                                <tr>
                                                                    <td>
                                                                        {{--<input name="padOpcao" type="radio" value="{!! $h->id !!}" >--}}
                                                                        <input name="Opcao[]" value="{!! $h->id !!}" type="checkbox" class="">
                                                                    </td>
                                                                    <td>{!! $h->id !!}</td>
                                                                    <td>{!! $h->numeropad !!}</td>
                                                                    <td>{!! $h->numerorelatorioseguranca !!}</td>
                                                                    <td>{!! strftime('%d/%m/%Y',strtotime($h->datainiciopad)) !!}</td>
                                                                    <td>{!! $h->dataconclusaopad == NULL ? '' : strftime('%d/%m/%Y',strtotime($h->dataconclusaopad)) !!}</td>
                                                                    <td>{!! $h->tipofato !!}</td>
                                                                    <td>{!! $h->tipofalta !!}</td>
                                                                    <td>{!! $h->situacaopad !!} </td>
                                                                </tr>
                                                            @empty
                                                                <tr>
                                                                    <td colspan="12">
                                                                        <div class="well text-center ">
                                                                            <h2 class="text-danger"> <i class="fa fa-warning"></i>
                                                                                Nenhum Registro Encontrado!</h2>

                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                            @endforelse

                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </fieldset>




                                            </div>
                                        </fieldset>


                                        <fieldset>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    {!! Form::label('class_comportamento','Comportamento')  !!}
                                                    {{ Form::select('class_comportamento', $tipos, null, ['class' => 'form-control naoValidar']) }}
                                                </div>
                                            </div>
                                        </fieldset>


                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>





            </div>
        </div>


    <div class="col-md-12">
        <div class="widget-box widget-color-dark">
            <div class="widget-header">
                <h4 class="widget-title">SELECIONE O PERIODO DE RECOLHIMENTO</h4>
            </div>
            <div class="widget-body">
                <div class="widget-main no-padding">
                    <fieldset>
                        <div class="table-responsive">
                            <table id="simple-table" class="table table-striped table-bordered table-hover">
                                <thead>
                                <tr class="">
                                    <th></th>
                                    <th>#</th>
                                    <th>PROCESSO</th>
                                    <th>DATA ENTRADA</th>
                                    <th>DATA SAÍDA</th>
                                    <th>MOTIVO SAÍDA</th>
                                    <th>RECOLHIDO</th>
                                </tr>
                                </thead>
                                <tbody>

                                @forelse($historicos as $h)

                                    <tr>
                                        <td>
                                           <input name="prisao" type="radio" value="{!! $h->idMov !!}" >
                                        </td>
                                        <td>{!! $h->idMov !!}</td>
                                        <td>{!! $h->numeroprocesso !!}</td>
                                        <td>{!! strftime('%d/%m/%Y',strtotime($h->dataentrada)) !!}</td>
                                        <td>{!! $h->datasaida == NULL ? '' : strftime('%d/%m/%Y',strtotime($h->datasaida)) !!}</td>
                                        <td>{!! tiposaida($h->motivosaida) !!}</td>
                                        <td>{!! $h->datasaida == NULL ? '<span class="label label-success">SIM</span>' : '<span class="label label-danger">NÃO</span>' !!} </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="12">
                                            <div class="well text-center ">
                                                <h2 class="text-danger"> <i class="fa fa-warning"></i> Nenhum Registro Encontrado!</h2>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse

                                </tbody>
                            </table>
                        </div>
                    </fieldset>
                </div>
            </div>



            <div class="widget-body">
                <div class="widget-main no-padding">
                    <div class="modal-footer">
                        <button class="btn btn-success" id="btnModalAtualizar" type="submit"> EMITIR</button>
                    </div>
                </div>
            </div>




        </div>
    </div>

    {{ Form::close() }}
@endsection

@section('scripts')

    {{ HTML::script('resources/assets/js/datepickerJS/bootstrap-datepicker.min.js') }}
    {{ HTML::script('resources/assets/js/datepickerJS/bootstrap-datepicker.pt-BR.min.js') }}

    {{ HTML::script('resources/assets/js/mask/maskedinput.min.js') }}
    {{ HTML::script('resources/assets/js/validacao/formatainput.js') }}


    <script type="application/javascript">

        $("#radiotipoOculta").change(function (event) {
            $('#blocoprocedimentos').show();
        });
        $("#radiotipoMostra").change(function (event) {
            $('#blocoprocedimentos').hide();
        });



    </script>

@stop