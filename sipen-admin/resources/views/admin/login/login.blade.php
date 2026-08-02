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

                            {{ Form::open(['route' =>  'admin.login.post']) }}
                                <fieldset>
                                    <label class="block clearfix">
														<span class="block input-icon input-icon-left">
															<input name="username" type="text" class="form-control"
                                                                   placeholder="Username" required/>
															<i class="ace-icon fa fa-user"></i>
														</span>
                                    </label>

                                    <label class="block clearfix">
														<span class="block input-icon input-icon-left">
															<input name="password" type="password" class="form-control"
                                                                   placeholder="Password" required/>
															<i class="ace-icon fa fa-lock"></i>
														</span>
                                    </label>
                                    <label class="block clearfix">
														<span class="block input-icon input-icon-right">
															      <div class="clearfix">
                                        <label class="inline">
                                            <input name="remember" type="checkbox" value="1" class="ace"/>
                                            <span class="lbl"> Remember Me</span>
                                        </label>
                                    </div>
														</span>
                                    </label>
                                    <label class="block clearfix">
														<span class="block input-icon input-icon-right">
															   <button type="submit"
                                                                       class="btn btn-sm btn-primary btn-block">
                                            <i class="ace-icon fa fa-sign-in"></i>
                                            <span class="bigger-110">Entrar</span>
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
                                </a>
                            </div>

                        </div>
                    </div><!-- /.widget-body -->
                </div><!-- /.login-box -->




            </div><!-- /.position-relative -->

        </div>
    </div><!-- /.col -->
<br>
<br>
<br>
<br>
<br>
<br>
<br>




@endsection