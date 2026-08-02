<div class="navbar-container ace-save-state" id="navbar-container">
	<div class="navbar-header pull-left">
		<a href="#" class="navbar-brand">
			<small>
				<i class="fa fa-get-pocket"></i>
				ADMINISTRAÇÃO -> SIPEN
			</small>
		</a>

		<button class="pull-right navbar-toggle navbar-toggle-img collapsed" type="button" data-toggle="collapse" data-target=".navbar-buttons,.navbar-menu">
			<span class="sr-only">Toggle user menu</span>
		</button>

		<button class="pull-right navbar-toggle collapsed" type="button" data-toggle="collapse" data-target="#sidebar">
			<span class="sr-only">Toggle sidebar</span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
		</button>
	</div>

	<div class="navbar-buttons navbar-header pull-right  collapse navbar-collapse" role="navigation">
		<ul class="nav ace-nav">

			<li class="light-blue dropdown-modal user-min">
				<a data-toggle="dropdown" href="#" class="dropdown-toggle" aria-expanded="false">
					<img class="nav-user-photo" src="{{asset('images/avatars/avatar2.png')}}" alt="">
					<span class="user-info">
									<small>Bem Vindo,</small>
									{{Auth::user()->nome}}
								</span>

					<i class="ace-icon fa fa-caret-down"></i>
				</a>

				<ul class="user-menu dropdown-menu-right dropdown-menu dropdown-yellow dropdown-caret dropdown-close">

					<li>
						<a href="{{route('admin.logout')}}">
							<i class="ace-icon fa fa-power-off"></i>
							Logout
						</a>
					</li>
				</ul>
			</li>
		</ul>
	</div>

	{{--<nav role="navigation" class="navbar-menu pull-left collapse navbar-collapse">--}}
		{{--<ul class="nav navbar-nav">--}}
			{{--<li>--}}
				{{--<a href="#" class="dropdown-toggle" data-toggle="dropdown">--}}
					{{--Cadastros--}}
					{{--<i class="ace-icon fa fa-angle-down bigger-110"></i>--}}
				{{--</a>--}}

				{{--<ul class="dropdown-menu dropdown-light-blue dropdown-caret">--}}
					{{--<li> <a href="#">  <i class="ace-icon fa fa-eye bigger-110 blue"></i> Quartos </a> </li>--}}
					{{--<li> <a href="#"> <i class="ace-icon fa fa-user bigger-110 blue"></i> Camas </a> </li>--}}
					{{--<li> <a href="#"> <i class="ace-icon fa fa-cog bigger-110 blue"></i> Igrejas </a> </li>--}}
				{{--</ul>--}}
			{{--</li>--}}

			{{--<li class="pull-right">--}}
				{{--<a href="#">--}}
					{{--{!! Auth::user()->name !!}--}}
				{{--</a>--}}
			{{--</li>--}}
		{{--</ul>--}}

	{{--</nav>--}}


</div><!-- /.navbar-container -->