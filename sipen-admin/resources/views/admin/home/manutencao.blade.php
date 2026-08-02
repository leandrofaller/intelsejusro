<?php $title = 'Em Manutenção'; ?>

@extends('layout.master')

@section('head')
<meta http-equiv="refresh" content="5">
@endsection

@section('main')

<br><br><br>
<div class="text-center well well-sm">
	<h1 class="text-primary">
		{{ icon('cogs text-muted') }} Em manutenção
	</h1>

	<br>
	<br>

	<h2 class="text-danger">Aguarde o término da manutenção do sistema...</h2>	

	<br>
	<br>
	<br>

	<h1 title="Atualizando...">
		<small>Atualizando... </small><br>
		{{ icon('cog fa-spin fa-4x text-muted') }}
		{{ icon('cog fa-spin fa-4x text-muted') }}
		{{ icon('cog fa-spin fa-4x text-muted') }}
	</h1>
	
</div>
	
@endsection