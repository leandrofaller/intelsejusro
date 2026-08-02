@extends('layout.master')

@section('main')
<?php $errorMessage = '<span class="text-danger"><i class="fa fa-times"></i> :message</span>'; ?>
	<h2><i class="fa fa-plus text-muted"></i> {{ $title }}</h2>
	<hr>

@include('flash.message')
@if ($errors->any())
	<div class="alert alert-warning fade in">
		<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
		<ul>
			@foreach($errors->all() as $error)
				<li><h5>{{ $error }} </h5></li>
			@endforeach
		</ul>
	</div>
@endif
<div class="row">
	<div class="col-md-12">
		<div class="panel panel-default">
			<div class="panel-heading">

			</div>
			<div class="panel-body">

	{{ Form::open(['method' => 'POST', 'route' =>  'sistemas.store']) }}
		<div class="row">
			<div class="col-md-4">
				<div class="form-group">
					{{ Form::label('name', 'Nome') }}
					{{ Form::text('name', null, ['autofocus', 'placeholder' => 'Informe o nome', 'class' => 'form-control']) }}

				</div>
			</div>

			<div class="col-md-4">
				<div class="form-group">
					{{ Form::label('url', 'URL') }}
					{{ Form::input('url', 'url', null, ['placeholder' => 'Informe a URL', 'class' => 'form-control']) }}
				</div>
			</div>
			<div class="col-md-4">
				<div class="form-group">
					{{ Form::label('active', 'Ativo?') }}
					<select name="active" class="form-control">
						<option value="1">Sim</option>
						<option value="0">Não</option>
					</select>

				</div>
			</div>


		</div>
				<hr/>
				<div class="row">
				<div class="col-md-12">
					<div class="well well-sm ">
						<button type="submit" class="btn btn-primary btn-sm"><i class="fa fa-save"> </i> <b>SALVAR</b></button>
						<button type="button" onclick="history.go(-1)" class="btn btn-default btn-back pull-right btn-sm"> <b>VOLTAR</b></button>
					</div>
				</div>
				</div>
		</div>
	{{ Form::close() }}
			</div>
		</div>
	</div>



@endsection