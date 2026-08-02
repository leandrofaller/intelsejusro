@extends('layout.login')
@section('content')

    <div class="col-sm-10 col-sm-offset-1">
        <div class="login-container">
            <div class="center">
                <h1>
                    <i class="ace-icon fa fa-get-pocket"></i>
                    <span class="blue">SIPEN</span>
                    <span class="white" id="id-text2">Admin</span>
                </h1>
                <h4 class="blue" id="id-company-text"></h4>
            </div>

            <div class="space-6"></div>

            <div class="position-relative">
                <div id="login-box" class="login-box visible widget-box no-border">
                    <div class="widget-body">
                        <div class="widget-main">
                            <h5 class=" blue lighter bigger">
                                @include('flash.message')
                            </h5>

                            <div class="space-6"></div>

                            {{ Form::open(['method' => 'POST', 'route' =>  'admin.selectRole.post']) }}
                            <fieldset>
                                <label class="block clearfix">
														<span class="block input-icon input-icon-left">
															<input name="username" type="text" class="form-control"
                                                                   placeholder="Username" readonly value="{{$usuario}}"/>
															<i class="ace-icon fa fa-user"></i>
														</span>
                                </label>

                                <label class="block clearfix">
														<span class="block">
                                    {{ Form::select('app_role_id', $roles ,null, ['class' => 'form-control']) }}
                                </label>

                                <label class="block clearfix">
														<span class="block input-icon input-icon-right">
															   <button type="submit"
                                                                       class="btn btn-sm btn-primary btn-block">
                                            <i class="ace-icon fa fa-sign-in"></i>
                                            <span class="bigger-110">Login</span>
                                        </button>
														</span>
                                </label>

                                <div class="space"></div>


                                <div class="space-4"></div>
                            </fieldset>
                            {{ Form::close() }}


                            <div class="space-6"></div>


                        </div><!-- /.widget-main -->

                        <div class="toolbar clearfix">
                            <div>
                                <a href="#" data-target="#signup-box" class="user-signup-link">
                                    Esqueci a Senha
                                </a>
                            </div>
                        </div>
                    </div><!-- /.widget-body -->
                </div><!-- /.login-box -->




            </div><!-- /.position-relative -->

        </div>
    </div><!-- /.col -->
@endsection