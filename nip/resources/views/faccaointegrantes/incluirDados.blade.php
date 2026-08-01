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
                                    <img class="img-responsive editable-empty" style="height: 202px;" src="{!! asset('public/'.\App\Model\Apenado::mostraFotoPrincipal($apenado->id)) !!}"/>
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
                    <div class="widget-toolbar">
                        <a href="#" class="abrirModalEditarFaccionado" data-action="collapse">
                            <i class="ace-icon fa fa-edit"></i> Editar
                        </a>
                    </div>
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
                                        {!! Form::text('datanascimentoc', $apenado->datanascimento ? dataFormat($apenado->datanascimento) : NULL , ['class' => 'form-control', 'readonly']) !!}
                                    </div>
                                </div>

                                <div class="col-md-8">
                                    <div class="form-group">
                                        {!! Form::label('faccao_id', 'Faccão')  !!}
                                        {{ Form::text('faccao_id', \App\Model\Faccao::mostraNomeFaccao($apenado->faccao_id), ['class' => 'form-control naoValidar' ,'readonly']) }}
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        {!! Form::label('databatismoA', 'Data do Batismo')  !!}
                                        {{ Form::text('databatismoA', $apenado->databatismo ? dataFormat($apenado->databatismo) : NULL, ['class' => 'form-control naoValidar' ,'readonly']) }}
                                    </div>
                                </div>
                        </fieldset>
                    </div>
                </div>
            </div>
        </div>



    <input type="hidden" value="{{ $apenado->id }}" name="apenado_id">



    <div class="col-md-12">
        <div class="widget-box widget-color-dark ">
            <div class="widget-header">
                <h4 class="widget-title">TELEFONES DE CONTATO</h4>
                <div class="widget-toolbar">
                    <a href="#" id="btnNovoTelefone" data-action="collapse">
                        <i class="ace-icon fa fa-plus"></i>
                    </a>
                </div>
            </div>
            <div class="widget-body">
                <div class="widget-main no-padding">
                    <fieldset>
                        {{ Form::open(['method' => 'POST', 'id'=>'formulario', 'route'=>'faccaointegrantes.SalvarTelefone']) }}
                        <input type="hidden" value="{{ $apenado->id }}" name="apenado_id">
                        <input type="hidden" value="{{ $apenado->idIntegrante }}" name="integrante_id">

                        <div id="formCadTelefone" hidden>
                            <fieldset>
                            <div class="col-md-2">
                                <div class="form-group">
                                    {{ Form::label('idTelefone', 'Código') }}
                                    {!! Form::text('idTelefone', 0, ['class' => 'form-control border-input','id'=>'idTelefone', 'readonly']) !!}
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    {!! Form::label('ddd', 'DDD')  !!}
                                    {{ Form::text('ddd', null, ['class' => 'form-control soddd', 'id'=>'ddd', 'placeholder'=>'Informe os Dados']) }}
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    {!! Form::label('numero_telefone', 'Número Telefone')  !!}
                                    {{ Form::text('numero_telefone', null, ['class' => 'form-control sotelefone', 'id'=>'numero_telefone']) }}
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    {!! Form::label('descricao_telefone','Descrição da Telefone')  !!}
                                    {!! Form::textarea('descricao_telefone', null, ['class' => 'form-control naoValidar','id'=>'descricao_telefone',  'maxlength'=>'240', 'rows'=>'2']) !!}
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-actions center">
                                    <button class="btn btn-sm btn-default" type="submit">
                                        <i class="ace-icon fa fa-save bigger-110"></i>
                                        SALVAR
                                    </button>
                                </div>
                            </div>

                            </fieldset>

                        </div>

                    <div class="clearfix"></div>
                        {{ Form::close() }}

                        <div class="col-md-12">
                            <div class="widget-box transparent">
                                <div class="widget-body">
                                    <div class="widget-main no-padding">
                                        <table class="table table-bordered table-striped">
                                            <thead class="thin-border-bottom">
                                            <tr>
                                                <th><i class="ace-icon fa fa-caret-right blue"></i>DDD</th>
                                                <th><i class="ace-icon fa fa-caret-right blue"></i>Telefone</th>
                                                <th><i class="ace-icon fa fa-caret-right blue"></i>Descrição</th>
                                                <th><i class="ace-icon fa fa-caret-right blue"></i>Atual</th>
                                                <th><i class="ace-icon fa fa-caret-right blue"></i>Data</th>
                                                <th></th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @forelse($telefones as $telefone)
                                                <tr>
                                                    <td>{!! $telefone->ddd !!}</td>
                                                    <td>{!! $telefone->numero_telefone !!}</td>
                                                    <td><b class="green">{!! $telefone->atual_telefone !!}</b></td>
                                                    <td>{!! $telefone->descricao_telefone !!}</td>
                                                    <td>{!! dataFormat($telefone->created_at) !!}</td>
                                                    <td class="col-md-2">
                                                        <button class="btn btn-info btn-sm" data-toggle="tooltip" data-placement="top" title="Editar"
                                                                onclick="EditarTelefone('{{$telefone->id}}','{{$telefone->ddd}}','{{$telefone->numero_telefone}}','{{$telefone->descricao_telefone}}')"><i class="fa fa-edit"></i></button>
                                                        <a href="{{ route('faccaointegrantes.SituacaoTelefone', [$telefone->id, $telefone->integrante_id] ) }}"
                                                           class="btn btn-sm btn-warning btn-sm situacao"><i
                                                                    class="fa fa-check" data-toggle="tooltip" data-placement="top"
                                                                    title="Definir como Ativo"></i></a>
                                                        <a href="{{ route('faccaointegrantes.ExcluirTelefone', [$telefone->id] ) }}"
                                                           class="btn btn-sm btn-danger btn-sm delete"><i
                                                                    class="fa fa-trash" data-toggle="tooltip" data-placement="top"
                                                                    title="Excluir item"></i></a>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="12">
                                                        <h5 class="text-danger"> <i class="fa fa-warning"></i> Nenhum Registro Encontrado!</h5>
                                                    </td>
                                                </tr>
                                            @endforelse
                                            </tbody>
                                        </table>
                                    </div><!-- /.widget-main -->
                                </div><!-- /.widget-body -->
                            </div><!-- /.widget-box -->
                        </div>
                    </fieldset>
                </div>
            </div>
        </div>
    </div>



    <div class="col-md-12">
        <div class="widget-box widget-color-dark ">
            <div class="widget-header">
                <h4 class="widget-title">PLACA / CHAPA / NÚMERO BATISMO / MATRICULA</h4>
                <div class="widget-toolbar">
                    <a href="#" id="btnNovoMatricula" data-action="collapse">
                        <i class="ace-icon fa fa-plus"></i>
                    </a>
                </div>
            </div>
            <div class="widget-body">
                <div class="widget-main no-padding">
                    <fieldset>
                        {{ Form::open(['method' => 'POST', 'id'=>'formulario', 'route'=>'faccaointegrantes.SalvarMatricula']) }}
                        <input type="hidden" value="{{ $apenado->id }}" name="apenado_id">
                        <input type="hidden" value="{{ $apenado->idIntegrante }}" name="integrante_id">
                        <div id="formCadMatricula" hidden>
                            <fieldset>
                            <div class="col-md-2">
                                <div class="form-group">
                                    {{ Form::label('idMatricula', 'Código') }}
                                    {!! Form::text('idMatricula', 0, ['class' => 'form-control border-input','id'=>'idMatricula', 'readonly']) !!}
                                </div>
                            </div>
                            <div class="col-md-10">
                                <div class="form-group">
                                    {!! Form::label('matricula', 'Matricula')  !!}
                                    {{ Form::text('matricula', null, ['class' => 'form-control', 'placeholder'=>'Informe os Dados']) }}
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    {!! Form::label('descricao_matricula','Descrição da Matricula')  !!}
                                    {!! Form::textarea('descricao_matricula', null, ['class' => 'form-control naoValidar','id'=>'descricao_matricula',  'maxlength'=>'240', 'rows'=>'2']) !!}
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-actions center">
                                    <button class="btn btn-sm btn-default" type="submit">
                                        <i class="ace-icon fa fa-save bigger-110"></i>
                                        SALVAR
                                    </button>
                                </div>
                            </div>
                            </fieldset>
                        </div>

                        <div class="clearfix"></div>
                        {{ Form::close() }}

                        <div class="col-md-12">
                            <div class="widget-box transparent">
                                <div class="widget-body">
                                    <div class="widget-main no-padding">
                                        <table class="table table-bordered table-striped">
                                            <thead class="thin-border-bottom">
                                            <tr>
                                                <th><i class="ace-icon fa fa-caret-right blue"></i>Informações Cadastradas</th>
                                                <th><i class="ace-icon fa fa-caret-right blue"></i>Descrição</th>
                                                <th><i class="ace-icon fa fa-caret-right blue"></i>Atual</th>
                                                <th><i class="ace-icon fa fa-caret-right blue"></i>Data</th>
                                                <th></th>
                                            </tr>
                                            </thead>

                                            <tbody>
                                                @forelse($matriculas as $matricula)
                                                <tr>
                                                    <td>{!! $matricula->nome_matricula !!}</td>
                                                    <td>{!! $matricula->descricao_matricula !!}</td>
                                                    <td><b class="green">{!! $matricula->atual_matricula !!}</b></td>
                                                    <td>{!! dataFormat($matricula->created_at) !!}</td>
                                                    <td class="col-md-2">
                                                        <button class="btn btn-info btn-sm" data-toggle="tooltip" data-placement="top" title="Editar"
                                                                onclick="EditarMatricula('{{$matricula->id}}','{{$matricula->nome_matricula}}','{{$matricula->descricao_matricula}}')"><i class="fa fa-edit"></i></button>
                                                        <a href="{{ route('faccaointegrantes.SituacaoMatricula', [$matricula->id, $matricula->integrante_id] ) }}"
                                                           class="btn btn-sm btn-warning btn-sm situacao"><i
                                                                    class="fa fa-check" data-toggle="tooltip" data-placement="top"
                                                                    title="Definir como Ativo"></i></a>
                                                        <a href="{{ route('faccaointegrantes.ExcluirMatricula', [$matricula->id] ) }}"
                                                           class="btn btn-sm btn-danger btn-sm delete"><i
                                                                    class="fa fa-trash" data-toggle="tooltip" data-placement="top"
                                                                    title="Excluir item"></i></a>
                                                    </td>
                                                </tr>
                                                @empty
                                                    <tr>
                                                        <td colspan="12">
                                                            <h5 class="text-danger"> <i class="fa fa-warning"></i> Nenhum Registro Encontrado!</h5>
                                                        </td>
                                                    </tr>
                                                @endforelse
                                            </tbody>
                                        </table>
                                    </div><!-- /.widget-main -->
                                </div><!-- /.widget-body -->
                            </div><!-- /.widget-box -->
                        </div>
                    </fieldset>
                </div>
            </div>
        </div>
    </div>



    <div class="col-md-12">
        <div class="widget-box widget-color-dark ">
            <div class="widget-header">
                <h4 class="widget-title">NOME BATISMO</h4>
                <div class="widget-toolbar">
                    <a href="#" id="btnNovoNomeBatismo" data-action="collapse">
                        <i class="ace-icon fa fa-plus"></i>
                    </a>
                </div>
            </div>
            <div class="widget-body">
                <div class="widget-main no-padding">
                    <fieldset>
                        {{ Form::open(['method' => 'POST', 'id'=>'formulario', 'route'=>'faccaointegrantes.SalvarNomeBatismo']) }}
                        <input type="hidden" value="{{ $apenado->id }}" name="apenado_id">
                        <input type="hidden" value="{{ $apenado->idIntegrante }}" name="integrante_id">
                        <div id="formCadNomeBatismo" hidden>
                    <fieldset>

                    <div class="col-md-2">
                                <div class="form-group">
                                    {{ Form::label('idNomeBatismo', 'Código') }}
                                    {!! Form::text('idNomeBatismo', 0, ['class' => 'form-control border-input','id'=>'idNomeBatismo', 'readonly']) !!}
                                </div>
                            </div>
                            <div class="col-md-10">
                                <div class="form-group">
                                    {!! Form::label('nome_batismo', 'Cadastro')  !!}
                                    {{ Form::text('nome_batismo', null, ['class' => 'form-control', 'placeholder'=>'Informe os Dados']) }}
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    {!! Form::label('descricao_batismo','Descrição da Batismo')  !!}
                                    {!! Form::textarea('descricao_batismo', null, ['class' => 'form-control naoValidar','id'=>'descricao_batismo',  'maxlength'=>'240', 'rows'=>'2']) !!}
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-actions center">
                                    <button class="btn btn-sm btn-default" type="submit">
                                        <i class="ace-icon fa fa-save bigger-110"></i>
                                        SALVAR
                                    </button>
                                </div>
                            </div>
                    </fieldset>
                        </div>
                        <div class="clearfix"></div>
                        {{ Form::close() }}

                        <div class="col-md-12">
                            <div class="widget-box transparent">
                                <div class="widget-body">
                                    <div class="widget-main no-padding">
                                        <table class="table table-bordered table-striped">
                                            <thead class="thin-border-bottom">
                                            <tr>
                                                <th><i class="ace-icon fa fa-caret-right blue"></i>Informações Cadastradas</th>
                                                <th><i class="ace-icon fa fa-caret-right blue"></i>Descrição</th>
                                                <th><i class="ace-icon fa fa-caret-right blue"></i>Atual</th>
                                                <th><i class="ace-icon fa fa-caret-right blue"></i>Data</th>
                                                <th></th>
                                            </tr>
                                            </thead>
                                           <tbody>
                                            @forelse($nomebatismos as $nomebatismo)
                                                <tr>
                                                    <td>{!! $nomebatismo->nome_batismo !!}</td>
                                                    <td>{!! $nomebatismo->descricao_batismo !!}</td>
                                                    <td><b class="green">{!! $nomebatismo->atual_batismo !!}</b></td>
                                                    <td>{!! dataFormat($nomebatismo->created_at) !!}</td>
                                                    <td class="col-md-2">
                                                        <button class="btn btn-info btn-sm" data-toggle="tooltip" data-placement="top" title="Editar"
                                                                onclick="EditarNomeBatismo('{{$nomebatismo->id}}','{{$nomebatismo->nome_batismo}}','{{$nomebatismo->descricao_batismo}}')"><i class="fa fa-edit"></i></button>
                                                        <a href="{{ route('faccaointegrantes.SituacaoNomeBatismo', [$nomebatismo->id,$nomebatismo->integrante_id ] ) }}"
                                                           class="btn btn-sm btn-warning btn-sm situacao"><i
                                                                    class="fa fa-check" data-toggle="tooltip" data-placement="top"
                                                                    title="Definir como Ativo"></i></a>
                                                        <a href="{{ route('faccaointegrantes.ExcluirNomeBatismo', [$nomebatismo->id] ) }}"
                                                           class="btn btn-sm btn-danger btn-sm delete"><i
                                                                    class="fa fa-trash" data-toggle="tooltip" data-placement="top"
                                                                    title="Excluir item"></i></a>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="12">
                                                            <h5 class="text-danger"> <i class="fa fa-warning"></i> Nenhum Registro Encontrado!</h5>
                                                    </td>
                                                </tr>
                                            @endforelse
                                            </tbody>
                                        </table>
                                    </div><!-- /.widget-main -->
                                </div><!-- /.widget-body -->
                            </div><!-- /.widget-box -->
                        </div>
                    </fieldset>
                </div>
            </div>
        </div>
    </div>




    <div class="col-md-12">
        <div class="widget-box widget-color-dark ">
            <div class="widget-header">
                <h4 class="widget-title">LOCAL BATISMO</h4>
                <div class="widget-toolbar">
                    <a href="#" id="btnNovoLocalBatismo" data-action="collapse">
                        <i class="ace-icon fa fa-plus"></i>
                    </a>
                </div>
            </div>
            <div class="widget-body">
                <div class="widget-main no-padding">
                    <fieldset>

                        {{ Form::open(['method' => 'POST', 'id'=>'formulario', 'route'=>'faccaointegrantes.SalvarLocalBatismo']) }}
                        <input type="hidden" value="{{ $apenado->id }}" name="apenado_id">
                        <input type="hidden" value="{{ $apenado->idIntegrante }}" name="integrante_id">

                        <div id="formCadLocalBatismo" hidden>
                            <fieldset>
                            <div class="col-md-2">
                                <div class="form-group">
                                    {{ Form::label('idLocalBatismo', 'Código') }}
                                    {!! Form::text('idLocalBatismo', 0, ['class' => 'form-control border-input','id'=>'idLocalBatismo', 'readonly']) !!}
                                </div>
                            </div>
                            <div class="col-md-10">
                                <div class="form-group">
                                    {!! Form::label('nome_localbatismo', 'Cadastro')  !!}
                                    {{ Form::text('nome_localbatismo', null, ['class' => 'form-control', 'placeholder'=>'Informe os Dados']) }}
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    {!! Form::label('descricao_localbatismo','Descrição Local Batismo')  !!}
                                    {!! Form::textarea('descricao_localbatismo', null, ['class' => 'form-control naoValidar','id'=>'descricao_localbatismo',  'maxlength'=>'240', 'rows'=>'2']) !!}
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-actions center">
                                    <button class="btn btn-sm btn-default" type="submit">
                                        <i class="ace-icon fa fa-save bigger-110"></i>
                                        SALVAR
                                    </button>
                                </div>
                            </div>
                            </fieldset>
                        </div>
                        <div class="clearfix"></div>
                        {{ Form::close() }}

                        <div class="col-md-12">
                            <div class="widget-box transparent">
                                <div class="widget-body">
                                    <div class="widget-main no-padding">
                                        <table class="table table-bordered table-striped">
                                            <thead class="thin-border-bottom">
                                            <tr>
                                                <th><i class="ace-icon fa fa-caret-right blue"></i>Informações Cadastradas</th>
                                                <th><i class="ace-icon fa fa-caret-right blue"></i>Descrição</th>
                                                <th><i class="ace-icon fa fa-caret-right blue"></i>Atual</th>
                                                <th><i class="ace-icon fa fa-caret-right blue"></i>Data</th>
                                                <th></th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @forelse($localbatismos as $local)
                                                <tr>
                                                    <td>{!! $local->nome_localbatismo!!}</td>
                                                    <td>{!! $local->descricao_localbatismo!!}</td>
                                                    <td><b class="green">{!! $local->atual_localbatismo !!}</b></td>
                                                    <td>{!! dataFormat($local->created_at) !!}</td>
                                                    <td class="col-md-2">
                                                        <button class="btn btn-info btn-sm" data-toggle="tooltip" data-placement="top" title="Editar"
                                                                onclick="EditarLocalBatismo('{{$local->id}}','{{$local->nome_localbatismo}}', '{{$local->descricao_localbatismo}}')"><i class="fa fa-edit"></i></button>
                                                        <a href="{{ route('faccaointegrantes.SituacaoLocalBatismo', [$local->id, $local->integrante_id] ) }}"
                                                           class="btn btn-sm btn-warning btn-sm situacao"><i
                                                                    class="fa fa-check" data-toggle="tooltip" data-placement="top"
                                                                    title="Definir como Ativo"></i></a>
                                                        <a href="{{ route('faccaointegrantes.ExcluirLocalBatismo', [$local->id] ) }}"
                                                           class="btn btn-sm btn-danger btn-sm delete"><i
                                                                    class="fa fa-trash" data-toggle="tooltip" data-placement="top"
                                                                    title="Excluir item"></i></a>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="12">
                                                        <h5 class="text-danger"> <i class="fa fa-warning"></i> Nenhum Registro Encontrado!</h5>
                                                    </td>
                                                </tr>
                                            @endforelse
                                            </tbody>
                                        </table>
                                    </div><!-- /.widget-main -->
                                </div><!-- /.widget-body -->
                            </div><!-- /.widget-box -->
                        </div>

                    </fieldset>
                </div>
            </div>
        </div>
    </div>



    <div class="col-md-12">
        <div class="widget-box widget-color-dark ">
            <div class="widget-header">
                <h4 class="widget-title">QUEBRADA ORIGEM</h4>
                <div class="widget-toolbar">
                    <a href="#" id="btnNovoQuebradaOrigem" data-action="collapse">
                        <i class="ace-icon fa fa-plus"></i>
                    </a>
                </div>
            </div>
            <div class="widget-body">
                <div class="widget-main no-padding">
                    <fieldset>

                        {{ Form::open(['method' => 'POST', 'id'=>'formulario', 'route'=>'faccaointegrantes.SalvarQuebradaOrigem']) }}
                        <input type="hidden" value="{{ $apenado->id }}" name="apenado_id">
                        <input type="hidden" value="{{ $apenado->idIntegrante }}" name="integrante_id">

                        <div id="formCadQuebradaOrigem" hidden>
                        <fieldset>
                            <div class="col-md-2">
                                <div class="form-group">
                                    {{ Form::label('idQuebradaOrigem', 'Código') }}
                                    {!! Form::text('idQuebradaOrigem', 0, ['class' => 'form-control border-input','id'=>'idQuebradaOrigem', 'readonly']) !!}
                                </div>
                            </div>
                            <div class="col-md-10">
                                <div class="form-group">
                                    {!! Form::label('nome_origem', 'Cadastro')  !!}
                                    {{ Form::text('nome_origem', null, ['class' => 'form-control', 'placeholder'=>'Informe os Dados']) }}
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    {!! Form::label('descricao_origem','Descrição de Origem')  !!}
                                    {!! Form::textarea('descricao_origem', null, ['class' => 'form-control naoValidar','id'=>'descricao_origem',  'maxlength'=>'240', 'rows'=>'2']) !!}
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-actions center">
                                    <button class="btn btn-sm btn-default" type="submit">
                                        <i class="ace-icon fa fa-save bigger-110"></i>
                                        SALVAR
                                    </button>
                                </div>
                            </div>
                    </fieldset>


                        </div>
                        <div class="clearfix"></div>
                        {{ Form::close() }}


                        <div class="col-md-12">
                            <div class="widget-box transparent">
                                <div class="widget-body">
                                    <div class="widget-main no-padding">
                                        <table class="table table-bordered table-striped">
                                            <thead class="thin-border-bottom">
                                            <tr>
                                                <th><i class="ace-icon fa fa-caret-right blue"></i>Informações Cadastradas</th>
                                                <th><i class="ace-icon fa fa-caret-right blue"></i>Descrição</th>
                                                <th><i class="ace-icon fa fa-caret-right blue"></i>Atual</th>
                                                <th><i class="ace-icon fa fa-caret-right blue"></i>Data</th>
                                                <th></th>
                                            </tr>
                                            </thead>

                                            <tbody>
                                            @forelse($quebradaorigens as $quebradaorigem)
                                                <tr>
                                                    <td>{!! $quebradaorigem->nome_origem!!}</td>
                                                    <td>{!! $quebradaorigem->descricao_origem!!}</td>
                                                    <td><b class="green">{!! $quebradaorigem->atual_origem !!}</b></td>
                                                    <td>{!! dataFormat($quebradaorigem->created_at) !!}</td>
                                                    <td class="col-md-2">

                                                        <button class="btn btn-info btn-sm" data-toggle="tooltip" data-placement="top" title="Editar"
                                                                onclick="EditarQuebradaOrigem('{{$quebradaorigem->id}}','{{$quebradaorigem->nome_origem}}','{{$quebradaorigem->descricao_origem}}')"><i class="fa fa-edit"></i></button>

                                                        <a href="{{ route('faccaointegrantes.SituacaoQuebradaOrigem', [$quebradaorigem->id, $quebradaorigem->integrante_id] ) }}"
                                                           class="btn btn-sm btn-warning btn-sm situacao"><i
                                                                    class="fa fa-check" data-toggle="tooltip" data-placement="top"
                                                                    title="Definir como Ativo"></i></a>

                                                        <a href="{{ route('faccaointegrantes.ExcluirQuebradaOrigem', [$quebradaorigem->id] ) }}"
                                                           class="btn btn-sm btn-danger btn-sm delete"><i
                                                                    class="fa fa-trash" data-toggle="tooltip" data-placement="top"
                                                                    title="Excluir item"></i></a>

                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="12">
                                                        <h5 class="text-danger"> <i class="fa fa-warning"></i> Nenhum Registro Encontrado!</h5>
                                                    </td>
                                                </tr>
                                            @endforelse
                                            </tbody>
                                        </table>
                                    </div><!-- /.widget-main -->
                                </div><!-- /.widget-body -->
                            </div><!-- /.widget-box -->
                        </div>

                    </fieldset>
                </div>
            </div>
        </div>
    </div>






    <div class="col-md-12">
        <div class="widget-box widget-color-dark ">
            <div class="widget-header">
                <h4 class="widget-title">QUEBRADA ATUAL</h4>
                <div class="widget-toolbar">
                    <a href="#" id="btnNovoQuebradaAtual" data-action="collapse">
                        <i class="ace-icon fa fa-plus"></i>
                    </a>
                </div>
            </div>
            <div class="widget-body">
                <div class="widget-main no-padding">
                    <fieldset>

                        {{ Form::open(['method' => 'POST', 'id'=>'formulario', 'route'=>'faccaointegrantes.SalvarQuebradaAtual']) }}
                        <input type="hidden" value="{{ $apenado->id }}" name="apenado_id">
                        <input type="hidden" value="{{ $apenado->idIntegrante }}" name="integrante_id">

                        <div id="formCadQuebradaAtual" hidden>
                            <fieldset>
                            <div class="col-md-2">
                                <div class="form-group">
                                    {{ Form::label('idQuebradaAtual', 'Código') }}
                                    {!! Form::text('idQuebradaAtual', 0, ['class' => 'form-control border-input','id'=>'idQuebradaAtual', 'readonly']) !!}
                                </div>
                            </div>
                            <div class="col-md-10">
                                <div class="form-group">
                                    {!! Form::label('nome_atual', 'Cadastro')  !!}
                                    {{ Form::text('nome_atual', null, ['class' => 'form-control', 'placeholder'=>'Informe os Dados']) }}
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    {!! Form::label('descricao_atual','Descrição Quebrada Atual')  !!}
                                    {!! Form::textarea('descricao_atual', null, ['class' => 'form-control naoValidar','id'=>'descricao_atual',  'maxlength'=>'240', 'rows'=>'2']) !!}
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-actions center">
                                    <button class="btn btn-sm btn-default" type="submit">
                                        <i class="ace-icon fa fa-save bigger-110"></i>
                                        SALVAR
                                    </button>
                                </div>
                            </div>
                            </fieldset>


                        </div>
                        <div class="clearfix"></div>
                        {{ Form::close() }}


                        <div class="col-md-12">
                            <div class="widget-box transparent">
                                <div class="widget-body">
                                    <div class="widget-main no-padding">
                                        <table class="table table-bordered table-striped">
                                            <thead class="thin-border-bottom">
                                            <tr>
                                                <th><i class="ace-icon fa fa-caret-right blue"></i>Informações Cadastradas</th>
                                                <th><i class="ace-icon fa fa-caret-right blue"></i>Descrição</th>
                                                <th><i class="ace-icon fa fa-caret-right blue"></i>Atual</th>
                                                <th><i class="ace-icon fa fa-caret-right blue"></i>Data</th>
                                                <th></th>
                                            </tr>
                                            </thead>

                                            <tbody>
                                            @forelse($quebradaatuais as $quebradaatual)
                                                <tr>
                                                    <td>{!! $quebradaatual->nome_atual!!}</td>
                                                    <td>{!! $quebradaatual->descricao_atual !!}</td>
                                                    <td><b class="green">{!! $quebradaatual->atual_atual !!}</b></td>
                                                    <td>{!! dataFormat($quebradaatual->created_at) !!}</td>
                                                    <td class="col-md-2">

                                                        <button class="btn btn-info btn-sm" data-toggle="tooltip" data-placement="top" title="Editar"
                                                                onclick="EditarQuebradaAtual('{{$quebradaatual->id}}','{{$quebradaatual->nome_atual}}','{{$quebradaatual->descricao_atual}}')"><i class="fa fa-edit"></i></button>

                                                        <a href="{{ route('faccaointegrantes.SituacaoQuebradaAtual', [$quebradaatual->id, $quebradaatual->integrante_id] ) }}"
                                                           class="btn btn-sm btn-warning btn-sm situacao"><i
                                                                    class="fa fa-check" data-toggle="tooltip" data-placement="top"
                                                                    title="Definir como Ativo"></i></a>

                                                        <a href="{{ route('faccaointegrantes.ExcluirQuebradaAtual', [$quebradaatual->id] ) }}"
                                                           class="btn btn-sm btn-danger btn-sm delete"><i
                                                                    class="fa fa-trash" data-toggle="tooltip" data-placement="top"
                                                                    title="Excluir item"></i></a>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="12">
                                                        <h5 class="text-danger"> <i class="fa fa-warning"></i> Nenhum Registro Encontrado!</h5>
                                                    </td>
                                                </tr>
                                            @endforelse
                                            </tbody>
                                        </table>
                                    </div><!-- /.widget-main -->
                                </div><!-- /.widget-body -->
                            </div><!-- /.widget-box -->
                        </div>

                    </fieldset>
                </div>
            </div>
        </div>
    </div>




    <div class="col-md-12">
        <div class="widget-box widget-color-dark ">
            <div class="widget-header">
                <h4 class="widget-title">CARGOS NA FACÇÃO</h4>
                <div class="widget-toolbar">
                    <a href="#" id="btnNovoCargo" data-action="collapse">
                        <i class="ace-icon fa fa-plus"></i>
                    </a>
                </div>
            </div>
            <div class="widget-body">
                <div class="widget-main no-padding">
                    <fieldset>

                        {{ Form::open(['method' => 'POST', 'id'=>'formulario', 'route'=>'faccaointegrantes.SalvarCargo']) }}
                        <input type="hidden" value="{{ $apenado->id }}" name="apenado_id">
                        <input type="hidden" value="{{ $apenado->idIntegrante }}" name="integrante_id">

                        <div id="formCadCargo" hidden>
                            <fieldset>

                                <div class="col-md-2">
                                    <div class="form-group">
                                        {{ Form::label('idCargo', 'Código') }}
                                        {!! Form::text('idCargo', 0, ['class' => 'form-control border-input','id'=>'idCargo', 'readonly']) !!}
                                    </div>
                                </div>

                                <div class="col-md-10">
                                    <div class="form-group">
                                        {!! Form::label('cargo_faccao_id', 'Cadastro')  !!}
                                        {{ Form::select('cargo_faccao_id', $cargosfaccao, 0, ['class' => 'form-control']) }}
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="form-group">
                                        {!! Form::label('descricao_cargo','Descrição do Cargo')  !!}
                                        {!! Form::textarea('descricao_cargo', null, ['class' => 'form-control naoValidar','id'=>'descricao_cargo',  'maxlength'=>'240', 'rows'=>'3']) !!}
                                    </div>
                                </div>

                                <div class="form-actions center">
                                    <button class="btn btn-sm btn-default" type="submit">
                                        <i class="ace-icon fa fa-save bigger-110"></i>
                                        SALVAR
                                    </button>
                                </div>
                            </fieldset>

                        </div>
                        <div class="clearfix"></div>
                        {{ Form::close() }}


                        <div class="col-md-12">
                            <div class="widget-box transparent">
                                <div class="widget-body">
                                    <div class="widget-main no-padding">
                                        <table class="table table-bordered table-striped">
                                            <thead class="thin-border-bottom">
                                            <tr>
                                                <th><i class="ace-icon fa fa-caret-right blue"></i>Informações Cadastradas</th>
                                                <th><i class="ace-icon fa fa-caret-right blue"></i>Descrição</th>
                                                <th><i class="ace-icon fa fa-caret-right blue"></i>Atual</th>
                                                <th><i class="ace-icon fa fa-caret-right blue"></i>Data</th>
                                                <th></th>
                                            </tr>
                                            </thead>

                                            <tbody>
                                            @forelse($cargos as $cargo)
                                                <tr>
                                                    <td>{!! $cargo->nomecargo!!}</td>
                                                    <td>{!! $cargo->descricao_cargo !!}</td>
                                                    <td><b class="green">{!! $cargo->atual_cargo !!}</b></td>
                                                    <td>{!! dataFormat($cargo->created_at) !!}</td>
                                                    <td class="col-md-2">

                                                        <button class="btn btn-info btn-sm" data-toggle="tooltip" data-placement="top" title="Editar"
                                                                onclick="EditarCargo('{{$cargo->id}}','{{$cargo->cargo_faccao_id}}','{{$cargo->descricao_cargo}}')"><i class="fa fa-edit"></i></button>

                                                        <a href="{{ route('faccaointegrantes.SituacaoCargo', [$cargo->id, $cargo->integrante_id] ) }}"
                                                           class="btn btn-sm btn-warning btn-sm situacao"><i
                                                                    class="fa fa-check" data-toggle="tooltip" data-placement="top"
                                                                    title="Definir como Ativo"></i></a>

                                                        <a href="{{ route('faccaointegrantes.ExcluirCargo', [$cargo->id] ) }}"
                                                           class="btn btn-sm btn-danger btn-sm delete"><i
                                                                    class="fa fa-trash" data-toggle="tooltip" data-placement="top"
                                                                    title="Excluir item"></i></a>

                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="12">
                                                        <h5 class="text-danger"> <i class="fa fa-warning"></i> Nenhum Registro Encontrado!</h5>
                                                    </td>
                                                </tr>
                                            @endforelse
                                            </tbody>
                                        </table>
                                    </div><!-- /.widget-main -->
                                </div><!-- /.widget-body -->
                            </div><!-- /.widget-box -->
                        </div>

                    </fieldset>
                </div>
            </div>
        </div>
    </div>





    <div class="col-md-12">
        <div class="widget-box widget-color-dark ">
            <div class="widget-header">
                <h4 class="widget-title">REFERÊNCIAS</h4>
                <div class="widget-toolbar">
                    <a href="#" id="btnNovoReferencia" data-action="collapse">
                        <i class="ace-icon fa fa-plus"></i>
                    </a>
                </div>
            </div>
            <div class="widget-body">
                <div class="widget-main no-padding">
                    <fieldset>

                        {{ Form::open(['method' => 'POST', 'id'=>'formulario', 'route'=>'faccaointegrantes.SalvarReferencia']) }}
                        <input type="hidden" value="{{ $apenado->id }}" name="apenado_id">
                        <input type="hidden" value="{{ $apenado->idIntegrante }}" name="integrante_id">

                        <div id="formCadReferencia" hidden>
                            <fieldset>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        {{ Form::label('idReferencia', 'Código') }}
                                        {!! Form::text('idReferencia', 0, ['class' => 'form-control border-input','id'=>'idReferencia', 'readonly']) !!}
                                    </div>
                                </div>
                                <div class="col-md-10">
                                    <div class="form-group">
                                        {{ Form::label('nome_referencia', 'Nome da Referência') }}
                                        {!! Form::text('nome_referencia', null, ['class' => 'form-control border-input','id'=>'nome_referencia']) !!}
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        {!! Form::label('descricao_referencia','Descrição da Referência')  !!}
                                        {!! Form::textarea('descricao_referencia', null, ['class' => 'form-control naoValidar','id'=>'descricao_referencia',  'maxlength'=>'240', 'rows'=>'3']) !!}
                                    </div>
                                    {{--<small>Máximo de 240 Caracteres</small>--}}
                                </div>
                                <div class="form-actions center">
                                    <button class="btn btn-sm btn-default" type="submit">
                                        <i class="ace-icon fa fa-save bigger-110"></i>
                                        SALVAR
                                    </button>
                                </div>
                            </fieldset>
                        </div>

                        <div class="clearfix"></div>
                        {{ Form::close() }}


                        <div class="col-md-12">
                            <div class="widget-box transparent">
                                <div class="widget-body">
                                    <div class="widget-main no-padding">
                                        <table class="table table-bordered table-striped">
                                            <thead class="thin-border-bottom">
                                            <tr>
                                                <th><i class="ace-icon fa fa-caret-right blue"></i>Informações Cadastradas</th>
                                                <th><i class="ace-icon fa fa-caret-right blue"></i>Descrição</th>
                                                <th><i class="ace-icon fa fa-caret-right blue"></i>Atual</th>
                                                <th><i class="ace-icon fa fa-caret-right blue"></i>Data</th>
                                                <th></th>
                                            </tr>
                                            </thead>

                                            <tbody>
                                            @forelse($referencias as $referencia)
                                                <tr>
                                                    <td>{!! $referencia->nome_referencia!!}</td>
                                                    <td>{!! $referencia->descricao_referencia!!}</td>
                                                    <td><b class="green">{!! $referencia->atual_referencia !!}</b></td>
                                                    <td>{!! dataFormat($referencia->atual_referencia) !!}</td>
                                                    <td class="col-md-2">

                                                        <button class="btn btn-info btn-sm" data-toggle="tooltip" data-placement="top" title="Editar"
                                                                onclick="EditarReferencia('{{$referencia->id}}','{{$referencia->nome_referencia}}','{{$referencia->descricao_referencia}}')"><i class="fa fa-edit"></i></button>

                                                        <a href="{{ route('faccaointegrantes.SituacaoReferencia', [$referencia->id, $referencia->integrante_id] ) }}"
                                                           class="btn btn-sm btn-warning btn-sm situacao"><i
                                                                    class="fa fa-check" data-toggle="tooltip" data-placement="top"
                                                                    title="Definir como Ativo"></i></a>

                                                        <a href="{{ route('faccaointegrantes.ExcluirReferencia', [$referencia->id] ) }}"
                                                           class="btn btn-sm btn-danger btn-sm delete"><i
                                                                    class="fa fa-trash" data-toggle="tooltip" data-placement="top"
                                                                    title="Excluir item"></i></a>

                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="12">
                                                        <h5 class="text-danger"> <i class="fa fa-warning"></i> Nenhum Registro Encontrado!</h5>
                                                    </td>
                                                </tr>
                                            @endforelse
                                            </tbody>
                                        </table>
                                    </div><!-- /.widget-main -->
                                </div><!-- /.widget-body -->
                            </div><!-- /.widget-box -->
                        </div>

                    </fieldset>
                </div>
            </div>
        </div>
    </div>



    <div class="col-md-12">
        <div class="widget-box widget-color-dark ">
            <div class="widget-header">
                <h4 class="widget-title">PADRINHOS - INDICAÇÃO INTERNA</h4>
                <div class="widget-toolbar">
                    <a href="#" id="btnNovoPadrinhoInterno" data-action="collapse">
                        <i class="ace-icon fa fa-plus"></i>
                    </a>
                </div>
            </div>
            <div class="widget-body">
                <div class="widget-main no-padding">
                    <fieldset>

                        {{ Form::open(['method' => 'POST', 'id'=>'formulario', 'route'=>'faccaointegrantes.SalvarPadrinhoInterno']) }}
                        <input type="hidden" value="{{ $apenado->id }}" name="apenado_id">
                        <input type="hidden" value="{{ $apenado->idIntegrante }}" name="integrante_id">

                        <div id="formCadPadrinhoInterno" hidden>
                            <fieldset>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        {{ Form::label('idPadrinhoInterno', 'Código') }}
                                        {!! Form::text('idPadrinhoInterno', 0, ['class' => 'form-control border-input','id'=>'idPadrinhoInterno', 'readonly']) !!}
                                    </div>
                                </div>
                                <div class="col-md-10">
                                    <div class="form-group">
                                        {{ Form::label('padrinho_id', 'Nome do Padrinho') }}
                                        {{ Form::select('padrinho_id', $listapadrinhosinterno, 0, ['class' => 'form-control']) }}
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        {!! Form::label('descricao_padrinhointerno','Descrição Relevante')  !!}
                                        {!! Form::textarea('descricao_padrinhointerno', null, ['class' => 'form-control naoValidar','id'=>'descricao_padrinhointerno',  'maxlength'=>'240', 'rows'=>'3']) !!}
                                    </div>
                                    {{--<small>Máximo de 240 Caracteres</small>--}}
                                </div>
                                <div class="form-actions center">
                                    <button class="btn btn-sm btn-default" type="submit">
                                        <i class="ace-icon fa fa-save bigger-110"></i>
                                        SALVAR
                                    </button>
                                </div>
                            </fieldset>
                        </div>
                        <div class="clearfix"></div>
                        {{ Form::close() }}


                        <div class="col-md-12">
                            <div class="widget-box transparent">
                                <div class="widget-body">
                                    <div class="widget-main no-padding">
                                        <table class="table table-bordered table-striped">
                                            <thead class="thin-border-bottom">
                                            <tr>
                                                <th><i class="ace-icon fa fa-caret-right blue"></i>Nome do Padrinho</th>
                                                <th><i class="ace-icon fa fa-caret-right blue"></i>Descrição</th>
                                                <th><i class="ace-icon fa fa-caret-right blue"></i>Data</th>
                                                {{--<th><i class="ace-icon fa fa-caret-right blue"></i>Atual</th>--}}
                                                <th></th>
                                            </tr>
                                            </thead>

                                            <tbody>
                                            @forelse($padrinhosinternos as $padrinhosinterno)
                                                <tr>
                                                    <td>{!! $padrinhosinterno->nomeapenado!!}</td>
                                                    <td>{!! $padrinhosinterno->descricao_padrinhointerno!!}</td>
                                                    <td>{!! dataFormat($padrinhosinterno->created_at) !!}</td>
                                                    {{--<td><b class="green">{!! $cargo->atual_cargo !!}</b></td>--}}
                                                    <td class="col-md-2">

                                                        <button class="btn btn-info btn-sm" data-toggle="tooltip" data-placement="top" title="Editar"
                                                                onclick="EditarPadrinhoInterno('{{$padrinhosinterno->id}}','{{$padrinhosinterno->padrinho_id}}','{{$padrinhosinterno->descricao_padrinhointerno}}')"><i class="fa fa-edit"></i></button>

                                                        {{--<a href="{{ route('faccaointegrantes.SituacaoCargo', [$cargo->id] ) }}"--}}
                                                           {{--class="btn btn-sm btn-warning btn-sm situacao"><i--}}
                                                                    {{--class="fa fa-check" data-toggle="tooltip" data-placement="top"--}}
                                                                    {{--title="Definir como Ativo"></i></a>--}}

                                                        <a href="{{ route('faccaointegrantes.ExcluirPadrinhoInterno', [$padrinhosinterno->id] ) }}"
                                                           class="btn btn-sm btn-danger btn-sm delete"><i
                                                                    class="fa fa-trash" data-toggle="tooltip" data-placement="top"
                                                                    title="Excluir item"></i></a>

                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="12">
                                                        <h5 class="text-danger"> <i class="fa fa-warning"></i> Nenhum Registro Encontrado!</h5>
                                                    </td>
                                                </tr>
                                            @endforelse
                                            </tbody>
                                        </table>
                                    </div><!-- /.widget-main -->
                                </div><!-- /.widget-body -->
                            </div><!-- /.widget-box -->
                        </div>

                    </fieldset>
                </div>
            </div>
        </div>
    </div>





    <div class="col-md-12">
        <div class="widget-box widget-color-dark ">
            <div class="widget-header">
                <h4 class="widget-title">PADRINHOS - INDICAÇÃO EXTERNA</h4>
                <div class="widget-toolbar">
                    <a href="#" id="btnNovoPadrinhoExterno" data-action="collapse">
                        <i class="ace-icon fa fa-plus"></i>
                    </a>
                </div>
            </div>
            <div class="widget-body">
                <div class="widget-main no-padding">
                    <fieldset>

                        {{ Form::open(['method' => 'POST', 'id'=>'formulario', 'route'=>'faccaointegrantes.SalvarPadrinhoExterno']) }}
                        <input type="hidden" value="{{ $apenado->id }}" name="apenado_id">
                        <input type="hidden" value="{{ $apenado->idIntegrante }}" name="integrante_id">

                        <div id="formCadPadrinhoExterno" hidden>
                            <fieldset>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        {{ Form::label('idPadrinhoExterno', 'Código') }}
                                        {!! Form::text('idPadrinhoExterno', 0, ['class' => 'form-control border-input','id'=>'idPadrinhoExterno', 'readonly']) !!}
                                    </div>
                                </div>
                                <div class="col-md-10">
                                    <div class="form-group">
                                        {{ Form::label('nome_padrinhoexterno', 'Nome do Padrinho Externo') }}
                                        {!! Form::text('nome_padrinhoexterno', null, ['class' => 'form-control',]) !!}
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        {!! Form::label('descricao_padrinhoexterno','Descrição Relevante')  !!}
                                        {!! Form::textarea('descricao_padrinhoexterno', null, ['class' => 'form-control naoValidar','id'=>'descricao_padrinhoexterno',  'maxlength'=>'240', 'rows'=>'3']) !!}
                                    </div>
                                    {{--<small>Máximo de 240 Caracteres</small>--}}
                                </div>
                                <div class="form-actions center">
                                    <button class="btn btn-sm btn-default" type="submit">
                                        <i class="ace-icon fa fa-save bigger-110"></i>
                                        SALVAR
                                    </button>
                                </div>
                            </fieldset>
                        </div>
                        <div class="clearfix"></div>
                        {{ Form::close() }}


                        <div class="col-md-12">
                            <div class="widget-box transparent">
                                <div class="widget-body">
                                    <div class="widget-main no-padding">
                                        <table class="table table-bordered table-striped">
                                            <thead class="thin-border-bottom">
                                            <tr>
                                                <th><i class="ace-icon fa fa-caret-right blue"></i>Nome do Padrinho</th>
                                                <th><i class="ace-icon fa fa-caret-right blue"></i>Descrição</th>
                                                <th><i class="ace-icon fa fa-caret-right blue"></i>Data</th>
                                                {{--<th><i class="ace-icon fa fa-caret-right blue"></i>Atual</th>--}}
                                                <th></th>
                                            </tr>
                                            </thead>

                                            <tbody>
                                            @forelse($padrinhosexternos as $padrinhosexterno)
                                                <tr>
                                                    <td>{!! $padrinhosexterno->nome_padrinhoexterno!!}</td>
                                                    <td>{!! $padrinhosexterno->descricao_padrinhoexterno!!}</td>
                                                    <td>{!! dataFormat($padrinhosexterno->created_at) !!}</td>
                                                    {{--<td><b class="green">{!! $cargo->atual_cargo !!}</b></td>--}}
                                                    <td class="col-md-2">

                                                        <button class="btn btn-info btn-sm" data-toggle="tooltip" data-placement="top" title="Editar"
                                                                onclick="EditarPadrinhoExterno('{{$padrinhosexterno->id}}','{{$padrinhosexterno->nome_padrinhoexterno}}', '{{$padrinhosexterno->descricao_padrinhoexterno}}')"><i class="fa fa-edit"></i></button>

                                                        {{--<a href="{{ route('faccaointegrantes.SituacaoCargo', [$cargo->id] ) }}"--}}
                                                        {{--class="btn btn-sm btn-warning btn-sm situacao"><i--}}
                                                        {{--class="fa fa-check" data-toggle="tooltip" data-placement="top"--}}
                                                        {{--title="Definir como Ativo"></i></a>--}}

                                                        <a href="{{ route('faccaointegrantes.ExcluirPadrinhoExterno', [$padrinhosexterno->id] ) }}"
                                                           class="btn btn-sm btn-danger btn-sm delete"><i
                                                                    class="fa fa-trash" data-toggle="tooltip" data-placement="top"
                                                                    title="Excluir item"></i></a>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="12">
                                                        <h5 class="text-danger"> <i class="fa fa-warning"></i> Nenhum Registro Encontrado!</h5>
                                                    </td>
                                                </tr>
                                            @endforelse
                                            </tbody>
                                        </table>
                                    </div><!-- /.widget-main -->
                                </div><!-- /.widget-body -->
                            </div><!-- /.widget-box -->
                        </div>

                    </fieldset>
                </div>
            </div>
        </div>
    </div>






    <div class="col-md-12">
        <div class="widget-box widget-color-dark ">
            <div class="widget-header">
                <h4 class="widget-title">CLASSIFICAÇÃO</h4>
                <div class="widget-toolbar">
                    <a href="#" id="btnNovaClassificacao" data-action="collapse">
                        <i class="ace-icon fa fa-plus"></i>
                    </a>
                </div>
            </div>
            <div class="widget-body">
                <div class="widget-main no-padding">
                    <fieldset>
                    <div id="formNovaClassificacao" hidden>

                        {{ Form::open(['method' => 'POST', 'id'=>'formulario', 'route'=>'faccaointegrantes.SalvarClassificacao']) }}
                        <input type="hidden" value="{{ $apenado->id }}" name="apenado_id">
                        <input type="hidden" value="{{ $apenado->idIntegrante }}" name="integrante_id">

                            <div class="col-md-6">
                                <div class="form-group">
                                    {!! Form::label('faccao_possiveis_id','Classificação de Faccionado')  !!}
                                    {{ Form::select('faccao_possiveis_id',$possiveis , $apenado->faccao_possiveis_id, ['id'=>'possivel', 'class' => 'form-control']) }}
                                </div>
                            </div>
                            <div class="col-md-6">
                            {!! Form::label('faccao_classificacao_id','Catalogado')  !!}
                                <div class="input-group">
                                {{ Form::select('faccao_classificacao_id', $classificacoes, $apenado->faccao_classificacao_id, ['id'=>'classificacao', 'class' => 'form-control']) }}

                                <span class="input-group-btn">
                                            <button class="btn btn-sm btn-default" type="submit">
                                            <i class="ace-icon fa fa-save bigger-110"></i>
                                            SALVAR
                                            </button>
                                        </span>
                                </div>
                            </div>
                            {{ Form::close() }}

                    </div>


                            <div class="col-md-12">
                                <div class="widget-box transparent">
                                    <div class="widget-body">
                                        <div class="widget-main no-padding">
                                            <table class="table table-bordered table-striped">
                                                <thead class="thin-border-bottom">
                                                <tr>
                                                    <th><i class="ace-icon fa fa-caret-right blue"></i>Data Atualização</th>
                                                    <th><i class="ace-icon fa fa-caret-right blue"></i>Classificação</th>
                                                    <th></th>
                                                </tr>
                                                </thead>

                                                <tbody>
                                                <?php $i = 1; ?>
                                                @forelse($locClassificacoes as $hc)
                                                    <tr class=" {!! $i == 1 ? 'green' : 'red' !!} ">
                                                        <td><b>{!! dataFormat($hc->created_at) !!}</b></td>
                                                        <td><b>{!! $hc->tipo_poss !!} - {!! $hc->tipo_class !!}</b></td>
                                                        <td class="col-md-2"></td>
                                                    </tr>
                                                    <?php $i++; ?>

                                                @empty
                                                    <tr>
                                                        <td colspan="12">
                                                            <h5 class="text-danger"> <i class="fa fa-warning"></i> Não Classificado!</h5>
                                                        </td>
                                                    </tr>
                                                @endforelse
                                                </tbody>
                                            </table>
                                        </div><!-- /.widget-main -->
                                    </div><!-- /.widget-body -->
                                </div><!-- /.widget-box -->
                            </div>


                        </fieldset>







                </div>
            </div>
        </div>
    </div>




    @include('suportes._editarDadosIntegrante')


    {{--<script src={{asset('js/jquery.js')}}></script>--}}

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


    {{ HTML::script('resources/assets/js/integrantes/script.js') }}
    {{ HTML::script('resources/assets/js/validacao/confirme.js') }}



@stop