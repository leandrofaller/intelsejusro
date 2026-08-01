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
              <a href="{!! route('advogados.mostrarapenados' ) !!}" class="btn btn-xs btn-light bigger"> <i class="ace-icon fa fa-arrow-left"></i> Voltar </a>
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



    <div class="row">



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
                                    <img class="img-responsive editable-empty" src="{!! asset($apenado->foto) !!}"/>
                                </div>

                        </fieldset>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <div class="row">

        <div class="col-md-12">

            <div class="widget-box widget-color-dark">
                <div class="widget-header">
                    <h4 class="widget-title">ADVOGADOS CADASTRADOS</h4>
                    <span class="pull-right">
                        <a href="#" class="btn btn-success bigger" id="btnVincular" name="btnVincular" > <i class="ace-icon fa fa-plus"></i> INCLUIR NOVO ADVOGADO</a>
                    </span>
                </div>

                <div class="widget-body">

                    <div class="widget-main no-padding">

                        <fieldset>

                            <div class="table-responsive">
                                <table id="simple-table" class="table table-striped table-bordered table-hover">
                                    <thead>
                                    <tr class="">
                                        <th>#</th>
                                        <th>NOME DO ADVOGADO</th>
                                        <th>OAB</th>
                                        <th>DATA CADASTRO</th>
                                        <th>Situação</th>
                                        <th></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @forelse($advogados as $advogado)
                                        <tr>
                                            <td data-id={!! $advogado->idAdv !!}>{!! $advogado->idAdv !!}</td>
                                            <td data-nomeadvogado="{!! $advogado->nomeadvogado !!}">{!! $advogado->nomeadvogado !!}</td>
                                            <td data-oab="{!! $advogado->oab !!}">{!! $advogado->oab !!}</td>
                                            <td data-datacadastroadvogado="{{strftime('%d/%m/%Y',strtotime($advogado->datacadastroadvogado))}}"> {!! strftime('%d/%m/%Y',strtotime($advogado->datacadastroadvogado)) !!}</td>
                                            <td>{!! $advogado->datacancelamento == null ? '<span class="label label-sm label-success">Ativo</span>' : '<span class="label label-sm label-danger">Inativo</span>' !!} </td>

                                            <td class="hidden" data-idAdvApen={{ $advogado->idAdvApen }}>{!! $advogado->idAdvApen !!}</td>
                                           <td class="hidden" data-apenado_id="{{$advogado->apenado_id}}"> {!! $advogado->apenado_id !!}</td>
                                            <td class="hidden" data-idd="{{$advogado->idAdvApen}}"> {!! $advogado->idAdvApen !!}</td>

                                            <td>
                                                @if($advogado->datacancelamento == null )
                                                    <a href="#" id="btnCancelar" name="btnCancelar" class="btn btn-xs btn-danger" title="Cancelar" > <i class="ace-icon fa fa-times-circle bigger-120"></i> </a>
                                                @endif
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="12">
                                                <div class="well text-center ">
                                                    <h2 class="text-danger"> <i class="fa fa-warning"></i> Nenhum Registro Encontrado!</h2>
                                                </div>
                                        </tr>
                                    @endforelse

                                    </tbody>
                                </table>
                            </div>



                        </fieldset>
                    </div>
                </div>
            </div>
        </div>

    </div>


    <div class="modal fade" id="myModalCancelar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog modal-lg " role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">CANCELAMENTO DE ADVOGADO</h4>
                </div>
                {!! Form::open(['route'=>['advogados.cancelar'], 'id'=>'formModalCancelar' ]) !!}
                <div class="modal-body" id="modalbody">
                    Informações Pessoais
                    <div class="widget-box widget-color-dark ">

                        <div class="widget-body">
                            <div class="widget-main no-padding">
                                <fieldset>

                                    <div class="col-md-2">
                                        <div class="form-group">
                                            {!! Form::label('id','Código Advogado')  !!}
                                            {{ Form::text('id', null, ['id'=>'id', 'class' => 'form-control', 'readonly']) }}
                                        </div>
                                    </div>

                                    <div class="col-md-8">
                                        <div class="form-group">
                                            {!! Form::label('nomeadvogado','Nome do (a) Advogado')  !!}
                                            {{ Form::text('nomeadvogado', null, ['id'=>'nomeadvogado', 'class' => 'form-control', 'readonly']) }}
                                        </div>
                                    </div>

                                    <div class="col-md-2">
                                        <div class="form-group">
                                            {!! Form::label('oab', 'OAB')  !!}
                                            {{ Form::text('oab', null, ['id'=>'oab','class' => 'form-control', 'readonly']) }}
                                        </div>
                                    </div>

                                    <hr>

                                </fieldset>
                            </div>
                        </div>
                    </div>
                    Informações do Cancelamento
                    <div class="widget-box widget-color-dark ">

                        <div class="widget-body">
                            <div class="widget-main no-padding">
                                <fieldset>
                                    <input type="hidden" id="idd" name="idd" value="">
                                    <input type="hidden" name="apenado_id" id="apenado_id"  value={{$apenado->id}}>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            {!! Form::label('datacancelamento','Data do Cancelamento')  !!}
                                            {{ Form::text('datacancelamento', null, ['id'=>'datacancelamento', 'class' => 'form-control date']) }}
                                        </div>
                                    </div>
                                    <div class="col-md-9">
                                        <div class="form-group">
                                            {!! Form::label('motivo', 'Motivo')  !!}
                                            {{ Form::text('motivo', null, ['id'=>'motivo','class' => 'form-control' ]) }}
                                        </div>
                                    </div>

                                    <hr>

                                </fieldset>
                            </div>
                        </div>
                    </div>


                </div>
                <div class="modal-footer">
                    <button class="btn btn-danger" id="btnModalCancelar" type="submit"> SALVAR</button>
                </div>
                {{ Form::close() }}
            </div>
        </div>
    </div>




    <div class="modal fade" id="myModalNovo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog modal-lg " role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">CADASTRO DE ADVOGADOS</h4>
                </div>
                {!! Form::open(['route'=>['advogados.salvar'], 'id'=>'formModalSalvar', 'enctype' => 'multipart/form-data' ]) !!}
                <div class="modal-body" id="modalbody">
                    NOVO
                    <div class="widget-box widget-color-dark ">

                        <div class="widget-body">
                            <div class="widget-main no-padding">
                                <fieldset>
                                    <input name="apenado_id" id="apenado_id" type="hidden" value={{$apenado->id}}>

                                    <div class="col-md-9">
                                        <div class="form-group">
                                            {!! Form::label('nomeadvogado','Nome do (a) Advogado')  !!}
                                            {{ Form::text('nomeadvogado', null, ['id'=>'nomeadvogado', 'class' => 'form-control']) }}
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            {!! Form::label('rgadvogado', 'RG')  !!}
                                            {{ Form::text('rgadvogado', null, ['id'=>'rgadvogado','class' => 'form-control']) }}
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            {!! Form::label('cpfadvogado','CPF')  !!}
                                            {{ Form::text('cpfadvogado', null, ['id'=>'cpfadvogado','class' => 'form-control cpf']) }}
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            {!! Form::label('oab', 'OAB')  !!}
                                            {{ Form::text('oab', null, ['id'=>'oab','class' => 'form-control']) }}

                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            {!! Form::label('seccional', 'Seccional')  !!}
                                            {{ Form::text('seccional', null, ['id'=>'seccional','class' => 'form-control']) }}

                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            {!! Form::label('telefoneadvogado', 'Telefone Contato')  !!}
                                            {{ Form::text('telefoneadvogado', null, ['id'=>'telefoneadvogado','class' => 'form-control ']) }}
                                        </div>
                                    </div>


                                    <div class="col-md-6">
                                        <div class="form-group">
                                            {!! Form::label('enderecoadvogado', 'Logradouro')  !!} <small class="text-danger">Ex: Rua Olavo Bilac, 5888 - Centro</small>
                                            {{ Form::text('enderecoadvogado', null, ['id'=>'enderecoadvogado','class' => 'form-control']) }}
                                        </div>
                                    </div>

                                    <div class="col-md-2">
                                        <div class="form-group">
                                            {!! Form::label('datacadastroadvogado', 'Data de Cadastro')  !!}
                                            {{ Form::text('datacadastroadvogado', null, ['id'=>'datacadastroadvogado','class' => 'form-control date naoValidar']) }}
                                        </div>
                                    </div>


                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <div>
                                                <img class="img-responsive editable-empty" id="foto" src="" />
                                            </div>
                                            {!! Form::label('foto','Buscar Foto')  !!}
                                            <input type="file" id="foto" name="foto" class="form-control naoValidar"  >
                                        </div>
                                    </div>
                                </fieldset>
                            </div>
                        </div>
                    </div>


                </div>
                <div class="modal-footer">
                    <button class="btn btn-success" id="btnModalsalvar" type="submit">SALVAR</button>
                </div>
                {{ Form::close() }}
            </div>
        </div>
    </div>


    <div class="modal fade" id="myModalVincular" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog modal-lg " role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">VINCULAR ADVOGADO A APENADO</h4>

                </div>
                {!! Form::open(['route'=>['advogados.vincular'], 'id'=>'formModalVincular' ]) !!}
                <div class="modal-body" id="modalbody">
                    Selecione o advogado para inclusão ao preso
                    <div class="widget-box widget-color-dark ">


                        <div class="widget-body">
                            <div class="widget-main no-padding">
                                <fieldset>
                                    <input name="apenado_id" id="apenado_id" type="hidden" value={{$apenado->id}}>

                                    <div class="col-md-9">
                                        <div class="form-group">
                                            {!! Form::label('advogado_id','Nome do (a) Advogado')  !!}
                                            {{ Form::select('advogado_id', $listageraladvogados, null, ['id'=>'advogado_id', 'class' => 'form-control chosen-select']) }}
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            {!! Form::label('datacadastroadvogado', 'Data de Cadastro')  !!}
                                            {{ Form::text('datacadastroadvogado', null, ['id'=>'datacadastroadvogado','class' => 'form-control date naoValidar']) }}
                                        </div>
                                    </div>



                                </fieldset>
                            </div>
                        </div>
                    </div>


                </div>
                <div class="modal-footer">
                    <button class="btn btn-success" id="btnModalVincular" type="submit"> <i class="ace-icon fa fa-save"></i> SALVAR</button>
                    <span class="pull-left">
                                            <a href="#" class="btn btn-info  bigger" id="btnNovo" name="btnNovo" > <i class="ace-icon fa fa-plus"></i> INCLUIR NOVO ADVOGADO</a>
                                          </span>

                </div>
                {{ Form::close() }}


            </div>
        </div>


    </div>


@endsection

@section('scripts')

    {{ HTML::script('js/advogados/script.js') }}

    {{ HTML::script('chosen/chosen.jquery.js') }}
    {{ HTML::script('chosen/chosen.js') }}

    {{ HTML::script('js/datepickerJS/bootstrap-datepicker.min.js') }}
    {{ HTML::script('js/datepickerJS/bootstrap-datepicker.pt-BR.min.js') }}

    {{ HTML::script('js/mask/maskedinput.min.js') }}
    {{ HTML::script('js/validacao/formatainput.js') }}

@stop