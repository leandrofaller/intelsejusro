@extends('layout.master')

@section('main')
	<h1>
		{{ icon('user text-muted') }} Informações do Usuário

		<a class="btn btn-link pull-right" href="{{ route('usuarios.edit', $usuario->id) }}">{{ icon('edit') }} Editar Usuário</a>
	</h1>
	<hr>
	
	<table class="table table-bordered table-condensed">
		<tr>
			<th class="text-right">Nome</th>
			<td>{{ $usuario->nome }}</td>
			<th class="text-right">CPF</th>
			<td>{{ $usuario->cpf }}</td>
		</tr>
		<tr>
			<th class="text-right">Unidade Prisional</th>
			<td>{{ $usuario->unidades->first()->nomeunidade }}</td>
			<th class="text-right">Email</th>
			<td><a target="_blank" href="mailto:{{ $usuario->email }}">{{ $usuario->email }}</a></td>
		</tr>
	</table>
	<a href="{{route('usuarios.reset_password', $usuario->id)}}" type="submit"
	   onclick="return confirm('Deseja realmente resetar a Senha do usuário?');"
	   class="btn btn-block btn-sm"><i class="fa fa-unlock"></i> CLIQUE AQUI PARA RESETAR A SENHA </a>

@endsection