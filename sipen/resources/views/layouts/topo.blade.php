<div class="navbar-container" id="navbar-container">
	<!-- #section:basics/sidebar.mobile.toggle -->
	<button type="button" class="navbar-toggle menu-toggler pull-left" id="menu-toggler" data-target="#sidebar">
		<span class="sr-only">Toggle sidebar</span>

		<span class="icon-bar"></span>

		<span class="icon-bar"></span>

		<span class="icon-bar"></span>
	</button>

	<!-- /section:basics/sidebar.mobile.toggle -->
	<div class="navbar-header pull-left">
		<!-- #section:basics/navbar.layout.brand -->
		<a href="#" class="navbar-brand">
			<small>
				<i class="fa fa-get-pocket"></i>
				SIPEN - SISTEMA DE INTELIGÊNCIA PENITENCIÁRIA
			</small>
		</a>
	</div>

	<!-- #section:basics/navbar.dropdown -->
	<div class="navbar-buttons navbar-header pull-right" role="navigation">
		<ul class="nav ace-nav">

			{{--<li class="blue">--}}
				{{--<a class="dropdown-toggle" href="#" id="btnPerguntas" >--}}
					{{--<i class="ace-icon fa fa-comment"></i>--}}
					{{--<span class="badge badge-important">0</span>--}}
				{{--</a>--}}
			{{--</li>--}}

			{{--<li class="green">--}}
				{{--<a data-toggle="dropdown" class="dropdown-toggle" href="#">--}}
					{{--<i class="ace-icon fa fa-institution icon-animated-vertical"></i>--}}
					{{--<span class="badge badge-success">1</span>--}}
				{{--</a>--}}
				{{--<ul class="dropdown-menu-right dropdown-navbar dropdown-menu dropdown-caret dropdown-close">--}}
					{{--<li class="dropdown-header">--}}
						{{--<i class="ace-icon fa fa-institution"></i>--}}
						{{--Unidade de Serviço--}}
					{{--</li>--}}
					{{--<li class="dropdown-content ace-scroll" style="position: relative;">--}}
						{{--<div class="scroll-track" style="display: none;">--}}
							{{--<div class="scroll-bar"></div>--}}
						{{--</div>--}}
						{{--<div class="scroll-content" style="max-height: 200px;">--}}
							{{--<ul class="dropdown-menu dropdown-navbar">--}}
								{{--<li>--}}
									{{--<a href="#">--}}
										{{--<i class="btn btn-xs btn-primary fa fa-toggle-left"></i>--}}
										{{--{{ Auth::user()->unidades->nomeunidade}}--}}
									{{--</a>--}}

								{{--</li>--}}
							{{--</ul>--}}
						{{--</div>--}}
					{{--</li>--}}

					{{--<li class="dropdown-footer">--}}
					{{--</li>--}}
				{{--</ul>--}}
			{{--</li>--}}



			<!-- Botão Toggle Modo Escuro -->
			<li class="grey">
				<a href="#" id="toggle-dark-mode" title="Alternar Modo Claro/Escuro" style="background-color: transparent !important; color: white !important;">
					<i class="ace-icon fa fa-moon-o" id="dark-mode-icon" style="font-size: 16px;"></i>
				</a>
			</li>

			<!-- #section:basics/navbar.user_menu -->
			<li class="light-blue">
				<a data-toggle="dropdown" href="#" class="dropdown-toggle">
					<small>{{ Auth::user()->nome }} </small>	/
					{{ Auth::user()->matricula}}
					<i class="ace-icon fa fa-cogs"></i>
					<i class="ace-icon fa fa-caret-down"></i>
				</a>

				<ul class="user-menu dropdown-menu-right dropdown-menu dropdown-yellow dropdown-caret dropdown-close">

					<li><a href="{{ route('alterarPassword') }}"> <i class="ace-icon fa fa-cog"></i> Alterar Senha </a> </li>
					<li class="divider"></li>
					<li> <a href="{{ route('logout') }}"> <i class="ace-icon fa fa-power-off"></i> Logout </a> </li>
				</ul>
			</li>

		</ul>
	</div>

</div><!-- /.navbar-container -->






<div class="modal fade" id="myModalAjuda" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog modal-lg " role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title"> <i class="fa fa-paperclip" ></i> Perguntas & Resposas</h4>
			</div>

			<fieldset>
				{{--<h2>Olá, <b>{{ Auth::user()->nome}}</b> </h2>--}}
				{{--<input type="hidden" name="idUserAjuda" value="">--}}
				<input type="hidden" name="idUnidadeUser" value="">
				<h2>Em Desenvolvimento</h2>

				<div class="col-md-6">
					<div class="form-group">
						{!! Form::label('pergunta','Pergunta ')  !!}
						{!! Form::text('pergunta',null, ['class' => 'form-control','id'=>'titulo']) !!}
					</div>
				</div>

			</fieldset>

			<div class="form-actions center">
				<input  class="btn btn-success" type="submit" name="btnSalvarAjuda" id="btnSalvarAjuda" value="Enviar" >
			</div>

			{{ Form::close() }}

		</div>

	</div>

</div>

