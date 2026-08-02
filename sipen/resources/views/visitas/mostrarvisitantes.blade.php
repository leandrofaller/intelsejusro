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
                                    <img class="img-responsive editable-empty" style="height: 250px;" src="{!! asset($apenado->foto) !!}"/>
                                </div>
                        </fieldset>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <div class="row">

        <div class="col-md-12">

            <hr>
        <div class="row">
            <div class="col-md-12">
                    <span class="pull-left">
                        <a href="#" class="btn btn-info bigger" id="btnTipo" name="btnTipo" > <i class="ace-icon fa fa-plus"></i> INSERIR VISITANTE</a>
                        {{--<a href="#" class="btn btn-success bigger" id="btnNovo" name="btnNovo" > <i class="ace-icon fa fa-plus"></i> INSERIR VISITANTE</a>--}}
                    </span>
            </div>
        </div>


            <div class="widget-box widget-color-dark">
                <div class="widget-header">
                    <h4 class="widget-title">VISITANTES CADASTRADOS</h4>
                </div>

                <div class="widget-body">

                    <div class="widget-main no-padding">

                        <fieldset>

                            <div class="table-responsive">
                                <table id="simple-table" class="table table-striped table-bordered table-hover">
                                    <thead>
                                    <tr class="">
                                        <th>#</th>
                                        <th>NOME VISITANTES</th>
                                        <th>GRAU PARENTESCO</th>
                                        <th>Situação</th>
                                        <th></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @forelse($visitas as $visita)
                                        <tr>
                                            <td data-id={!! $visita->id !!}>{!! $visita->id !!}</td>
                                            <td data-nomevisita="{!! $visita->nomevisita !!}">{!! $visita->nomevisita !!}</td>
                                            <td data-parentescovisita="{!! $visita->parentescovisita !!}" >{!! $visita->parentescovisita !!}</td>
                                            <td>{!! $visita->datacancelamento == null ? '<span class="label label-sm label-success">Ativo</span>' : '<span class="label label-sm label-danger">Inativo</span>' !!} </td>

                                            <td class="hidden" data-visitaapen={!! $visita->idVisitaApenado !!}>{!! $visita->idVisitaApenado !!}</td>
                                            <td class="hidden" data-dataemicaocarteirinha="{{strftime('%d/%m/%Y',strtotime($visita->dataemicaocarteirinha))}}"> {!! strftime('%d/%m/%Y',strtotime($visita->dataemicaocarteirinha)) !!}</td>
                                            <td class="hidden" data-apenado_id="{{$visita->apenado_id}}"> {!! $visita->apenado_id !!}</td>
                                            <td class="hidden" data-cpfvisita="{{$visita->cpfvisita}}"> {!! $visita->cpfvisita !!}</td>

                                            <td>
                                                @if($visita->datacancelamento == null )
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




    <div class="modal fade" id="myModalTipo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog modal-xs " role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">CADASTRO DE VISITANTES</h4>
                </div>
                <div class="modal-body" id="modalbody">
                    <div class="widget-box widget-color-dark ">
                        <div class="widget-body">
                            <div class="widget-main no-padding">
                                <fieldset>

                                    {!! Form::open(['route'=>['visitas.novo'], 'id'=>'formSalvar']) !!}

                                        <input name="apenado_id" id="apenado_id" type="hidden" value="{!! $apenado->id !!}">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    {!! Form::label('tipoparente', 'Grau de Parentesco')  !!}
                                                    {{ Form::select('tipoparente', \App\Model\Visita::$grauparentesco, null, ['id'=>'tipoparente','class' => 'form-control']) }}
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    {!! Form::label('cpfvisita', 'Cpf')  !!}
                                                    {{ Form::text('cpfvisita', null, ['id'=>'cpfvisita','class' => 'form-control cpf']) }}
                                                </div>
                                           </div>

                                            <div class="col-md-12">
                                                    <div class="form-actions center">
                                                        <button type="submit" class="btn btn-sm btn-success" id="btnSalvar">
                                                            <i class="ace-icon fa fa- Example of check icon-on-right bigger-110"></i>
                                                            INICIAR CADASTRO
                                                        </button>
                                                    </div>
                                            </div>
                                    {{ Form::close() }}

                                </fieldset>
                            </div>
                        </div>
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
                    <h4 class="modal-title">CANCELAMENTO DE VISITANTE</h4>
                </div>
                {!! Form::open(['route'=>['visitas.cancelar'], 'id'=>'formModalCancelar', 'enctype' => 'multipart/form-data' ]) !!}
                <div class="modal-body" id="modalbody">
                    Informações Pessoais
                    <div class="widget-box widget-color-dark ">

                        <div class="widget-body">
                            <div class="widget-main no-padding">
                                <fieldset>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            {!! Form::label('id','Código do Visitante')  !!}
                                            {{ Form::text('id', null, ['id'=>'id', 'class' => 'form-control', 'readonly']) }}
                                        </div>
                                    </div>

                                    <div class="col-md-9">
                                        <div class="form-group">
                                            {!! Form::label('nomevisita','Nome do (a) Visitante')  !!}
                                            {{ Form::text('nomevisita', null, ['id'=>'nomevisita', 'class' => 'form-control', 'readonly']) }}
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            {!! Form::label('cpfvisita', 'Cpf')  !!}
                                            {{ Form::text('cpfvisita', null, ['id'=>'cpfvisita','class' => 'form-control cpf naoValidar', 'readonly']) }}
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            {!! Form::label('dataemicaocarteirinha', 'Data da Carteirinha')  !!}
                                            {{ Form::text('dataemicaocarteirinha', null, ['id'=>'dataemicaocarteirinha','class' => 'form-control naoValidar', 'readonly']) }}
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            {!! Form::label('parentescovisita', 'Grau de Parentesco')  !!}
                                            {{ Form::text('parentescovisita', null, ['id'=>'parentescovisita','class' => 'form-control' , 'readonly']) }}
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
                                    <input type="hidden" id="visitaapen" name="visitaapen">
                                    <input name="apenado_id" id="apenado_id" type="hidden" value={{$apenado->id}}>
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









    {{--<div class="modal fade" id="myModalNovo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">--}}
        {{--<div class="modal-dialog modal-lg " role="document">--}}
            {{--<div class="modal-content">--}}
                {{--<div class="modal-header">--}}
                    {{--<button type="button" class="close" data-dismiss="modal">&times;</button>--}}
                    {{--<h4 class="modal-title">CADASTRO DE VISITANTES</h4>--}}
                {{--</div>--}}
                {{--{!! Form::open(['route'=>['visitas.salvar'], 'id'=>'formModalSalvar', 'enctype' => 'multipart/form-data' ]) !!}--}}
                {{--<div class="modal-body" id="modalbody">--}}
                    {{--NOVO--}}
                    {{--<div class="widget-box widget-color-dark ">--}}


                        {{--<div class="widget-body">--}}
                            {{--<div class="widget-main no-padding">--}}
                                {{--<fieldset>--}}
                                    {{--<input name="apenado_id" id="apenado_id" type="hidden" value={{$apenado->id}}>--}}

                                    {{--<div class="col-md-9">--}}
                                        {{--<div class="form-group">--}}
                                            {{--{!! Form::label('nomevisita','Nome do (a) Visitante')  !!}--}}
                                            {{--{{ Form::text('nomevisita', null, ['id'=>'nomevisita', 'class' => 'form-control']) }}--}}
                                        {{--</div>--}}
                                    {{--</div>--}}

                                    {{--<div class="col-md-3">--}}
                                        {{--<div class="form-group">--}}
                                            {{--{!! Form::label('parentescovisita', 'Grau de Parentesco')  !!}--}}
                                            {{--{{ Form::select('parentescovisita', \App\Model\Visita::$grauparentesco, null, ['id'=>'parentescovisita','class' => 'form-control']) }}--}}
                                        {{--</div>--}}
                                    {{--</div>--}}

                                    {{--<div class="col-md-4">--}}
                                        {{--<div class="form-group">--}}
                                            {{--{!! Form::label('cpfvisita','CPF')  !!}--}}
                                            {{--{{ Form::text('cpfvisita', null, ['id'=>'cpfvisita','class' => 'form-control cpf']) }}--}}
                                        {{--</div>--}}
                                    {{--</div>--}}

                                    {{--<div class="col-md-4">--}}
                                        {{--<div class="form-group">--}}
                                            {{--{!! Form::label('rgvisita', 'RG')  !!}--}}
                                            {{--{{ Form::text('rgvisita', null, ['id'=>'rgvisita','class' => 'form-control']) }}--}}

                                        {{--</div>--}}
                                    {{--</div>--}}

                                    {{--<div class="col-md-4">--}}
                                        {{--<div class="form-group">--}}
                                            {{--{!! Form::label('datanascimentovisita', 'Data de Nascimento')  !!}--}}
                                            {{--{{ Form::text('datanascimentovisita', null, ['id'=>'datanascimentovisita','class' => 'form-control date naoValidar']) }}--}}
                                        {{--</div>--}}
                                    {{--</div>--}}


                                    {{--<div class="col-md-6">--}}
                                        {{--<div class="form-group">--}}
                                            {{--{!! Form::label('enderecovisita', 'Logradouro')  !!} <small class="text-danger">Ex: Rua Olavo Bilac, 5888 - Centro</small>--}}
                                            {{--{{ Form::text('enderecovisita', null, ['id'=>'enderecovisita','class' => 'form-control']) }}--}}
                                        {{--</div>--}}
                                    {{--</div>--}}

                                    {{--<div class="col-md-2">--}}
                                        {{--<div class="form-group">--}}
                                            {{--{!! Form::label('ufvisita', 'UF')  !!}--}}
                                            {{--{{ Form::select('ufvisita', \App\Model\Visita::$ufs, null, ['id'=>'ufvisita','class' => 'form-control']) }}--}}
                                        {{--</div>--}}
                                    {{--</div>--}}
                                    {{--<div class="col-md-4">--}}
                                        {{--<div class="form-group">--}}
                                            {{--{!! Form::label('cidadevisita', 'Cidade da Visitante')  !!}--}}
                                            {{--{{ Form::text('cidadevisita', null, ['id'=>'cidadevisita','class' => 'form-control']) }}--}}
                                        {{--</div>--}}
                                    {{--</div>--}}

                                    {{--<div class="col-md-3">--}}
                                        {{--<div class="form-group">--}}
                                            {{--{!! Form::label('dataemicaocarteirinha', 'Data da Carteirinha')  !!}--}}
                                            {{--{{ Form::text('dataemicaocarteirinha', null, ['id'=>'dataemicaocarteirinha','class' => 'form-control date naoValidar']) }}--}}
                                        {{--</div>--}}
                                    {{--</div>--}}

                                    {{--<div class="col-md-5">--}}
                                        {{--<div class="form-group">--}}
                                            {{--{!! Form::label('telefonecontato', 'Telefones de Contato')  !!} <small class="text-danger" > Ex: 69 9.9999-9999 / 69 9.9999-9999</small>--}}
                                            {{--{{ Form::text('telefonecontato', null, ['id'=>'telefonecontato','class' => 'form-control']) }}--}}
                                        {{--</div>--}}
                                    {{--</div>--}}
                                    {{--<div class="col-md-4">--}}
                                        {{--<div class="form-group">--}}
                                            {{--<div>--}}
                                                {{--<img class="img-responsive editable-empty" id="fotovisita" src="" />--}}
                                            {{--</div>--}}
                                            {{--{!! Form::label('fotovisita','Buscar Foto')  !!}--}}
                                            {{--<input type="file" id="fotovisita" name="fotovisita" class="form-control naoValidar"  >--}}
                                        {{--</div>--}}
                                    {{--</div>--}}
                                {{--</fieldset>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                    {{--</div>--}}


                {{--</div>--}}
                {{--<div class="modal-footer">--}}
                    {{--<button class="btn btn-success" id="btnModalsalvar" type="submit">SALVAR</button>--}}
                {{--</div>--}}
                {{--{{ Form::close() }}--}}
            {{--</div>--}}
        {{--</div>--}}
    {{--</div>--}}




@endsection

@section('scripts')

    {{ HTML::script('js/visitas/script.js') }}


    {{ HTML::script('js/datepickerJS/bootstrap-datepicker.min.js') }}
    {{ HTML::script('js/datepickerJS/bootstrap-datepicker.pt-BR.min.js') }}

    {{ HTML::script('js/mask/maskedinput.min.js') }}
    {{ HTML::script('js/validacao/formatainput.js') }}

@stop