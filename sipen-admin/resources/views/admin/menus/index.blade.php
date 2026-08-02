@extends('layout.master')

@section('main')
@section('styles')
    {{ HTML::style('chosen/chosen.css') }}
@endsection
    <h2><i class="fa fa-sitemap text-muted"></i> {{ $title }}</h2>
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
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading">
            </div>
            <div class="panel-body">
                {{ Form::open(['method' => 'GET', 'id' => 'form']) }}
                <div class="row">
                    <div class="well well-sm" style="margin: 10px">
                        <div class="form-inline">
                            <div class="form-group">
                                {{ Form::label('sistema', 'Sistema : ') }}
                                {{ Form::select('app_id',$sistemas, Request::get('app_id') , ['class' => 'form-control','onchange' => "$('#form').trigger('submit');"]) }}
                            </div>
                            @if(sizeof($papeis) > 0)
                                <div class="form-group">
                                    {{ Form::label('app_role_id', 'Papel : ') }}
                                    {{ Form::select('app_role_id', $papeis, Request::get('app_role_id'), ['class' => 'form-control', 'onchange' => "$('#form').trigger('submit');"]) }}
                                    @endif
                                    <button type="submit" class="btn btn-primary btn-sm">{{icon('search')}}</button>
                                </div>
                        </div>
                    </div>
                </div>

                {{ Form::close() }}
            </div>
        </div>
    </div>

    @if(isset($menus) && sizeof($papeis) > 0)
        <div class="col-md-12">
            <div class="panel panel-default hidden-xs">
                @if($menus->count() == 0)
                    <div class="panel-heading">
                        <h5 class="text-info text-center"><i class="fa fa-info-circle"></i> Não há nenhum menu
                            cadastrado.</h5>
                    </div>
                @else
                    <div class="panel-heading">
                        <span class="text-left">Menu Atual</span>
                    </div>
                    <div class="panel-body">
                        <div id="sidebar" class="sidebar h-sidebar navbar-collapse collapse ace-save-state">
                            <ul class="nav nav-list">
                                @foreach($menus as $menu)
                                    <li class="hover">
                                        <a href="{{route('menus.index', ['app_id' => Request::get('app_id'), 'app_role_id' => Request::get('app_role_id'), 'app_menu_pai' => $menu->id]) }}"
                                           class="dropdown">
                                            <i class="menu-icon fa fa-{{$menu->icon}}"></i>
                                            <span class="menu-text"> {{$menu->title}} </span>
                                            <b class="arrow fa fa-angle-down"></b>
                                        </a>
                                        <b class="arrow"></b>
                                        <ul class="submenu">
                                            @foreach($menu->menusChildrens()->orderBy('order')->get() as $m)
                                                <li class="hover">
                                                    <a href='{{ route('menus.index', ['app_id' => Request::get('app_id'), 'app_role_id' => Request::get('app_role_id'), 'app_menu_id' => $m->id]) }}'>
                                                        <i class="menu-icon fa fa-caret-right"></i>
                                                        {{icon($m->icon). $m->title}}
                                                    </a>
                                                    <b class="arrow"></b>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </li>
                                @endforeach

                            </ul><!-- /.nav-list -->
                        </div>
                    </div>
                @endif
            </div>
        </div>

        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <span class="text-left">Menus Pais</span>
                    <span class="pull-right"><a
                                href='{{ route('menus.index', ['app_id' => Request::get('app_id'), 'app_role_id' => Request::get('app_role_id')]) }}'>{{icon('plus')}}
                            Novo</a></span>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-12">
                            @if(isset($menusPais))
                                {{ Form::open(['route' => ['menus.pais.update', $menusPais->id]]) }}
                            @else
                                {{ Form::open(['route' => 'menus.pais.store']) }}
                                {{ Form::hidden('app_role_id', Request::get('app_role_id')) }}
                            @endif
                            <div class="col-md-2">
                                <div class="form-group">
                                    {{ Form::label('id', '#') }}
                                    {{ Form::text('id', isset($menusPais) ? $menusPais->id :'0', ['class' => 'form-control text-bold', 'disabled']) }}
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="form-group">
                                    {{ Form::label('title', 'Título') }}
                                    {{ Form::text('title', isset($menusPais) ? $menusPais->title :'', ['class' => 'form-control', 'placeholder' => 'Informe Titulo']) }}

                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    {{ Form::label('order', 'Ordem') }}
                                    {{ Form::input('number', 'order', isset($menusPais) ? $menusPais->order :'', ['class' => 'form-control']) }}
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    {{ Form::label('icon', 'Ícone') }}
                                    {{ Form::text('icon', isset($menusPais) ? $menusPais->icon :'', ['class' => 'form-control', 'placeholder' => 'Ex:list']) }}
                                </div>
                            </div>

                                <div class="col-md-9">
                                    <div class="form-group">
                                        {{ Form::label('route', 'Rota') }} <br>
                                        {{ Form::select('route', $routesMenuPai, isset($menusPais) ? $menusPais->route :null, ['class' => 'form-control chosen-select']) }}
                                    </div>
                                </div>
                        </div>
                    </div>
                    <div class="row">
                        <hr>
                        <div class="col-md-4">
                            <button type="submit" class="btn btn-sm btn-success"><i
                                        class="fa fa-save"></i> SALVAR
                            </button>
                        </div>
                        @if(isset($menusPais))
                            <div class="col-md-2">
                                <div class="form-group">
                                    <a href="{{route('menus.pais.destroy',$menusPais->id)}}" type="submit"
                                       class="btn btn-danger btn-xs pull-right"
                                       onclick="return confirm('Deseja realmente remover Menu Pai?  Os Filhos serão deletados Juntos');"><i
                                                class="fa fa-trash-o"></i> Remover Menu Pai</a>
                                </div>
                            </div>
                        @endif
                    </div>
                    {{ Form::close() }}
                </div>
            </div>
        </div>
    @endif
    @if(isset($menus))
        @if($menus->count() > 0  && sizeof($papeis) > 0)
            <div class="col-md-6">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <span class="text-left">Menus Filhos</span>
                        <span class="pull-right"><a
                                    href='{{ route('menus.index', ['app_id' => Request::get('app_id'), 'app_role_id' => Request::get('app_role_id')]) }}'>{{icon('plus')}}
                                Novo</a></span>
                    </div>
                    <div class="panel-body">
                        @if(Request::has('app_id') && Request::has('app_role_id'))
                            <div class="row">
                                <div class="col-md-12">
                                    @if(isset($menusFilhos))
                                        {{ Form::open(['route' => ['menus.filhos.update', $menusFilhos->id]]) }}
                                    @else
                                        {{ Form::open(['route' => 'menus.filhos.store']) }}
                                    @endif
                                    {{ Form::hidden('app_id', Request::get('app_id')) }}
                                    {{ Form::hidden('app_role_id', Request::get('app_role_id')) }}

                                    <div class="row">
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                {{ Form::label('id', '#') }}
                                                {{ Form::text('id', isset($menusFilhos) ? $menusFilhos->id :'0', ['class' => 'form-control text-bold', 'disabled']) }}
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                {{ Form::label('app_menu_id', 'Menu Pai') }} <br>
                                                {{ Form::select('app_menu_id', $menuPai, isset($menusFilhos) ? $menusFilhos->app_menu_id :'0', ['class' => 'form-control']) }}
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                {{ Form::label('title', 'Título') }} <br>
                                                {{ Form::text('title', isset($menusFilhos) ? $menusFilhos->title :'' , ['class' => 'form-control', 'placeholder' => 'Informe a descrição'] ) }}
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                {{ Form::label('order', 'Ordem') }}
                                                {{ Form::input('number', 'order', isset($menusFilhos) ? $menusFilhos->order :'', ['class' => 'form-control']) }}
                                            </div>
                                        </div>

                                    </div>

                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                {{ Form::label('icon', 'Ícone') }}
                                                {{ Form::text('icon', isset($menusFilhos) ? $menusFilhos->icon :'', ['class' => 'form-control', 'placeholder' => 'Ex:list']) }}
                                            </div>
                                        </div>
                                        <div class="col-md-8">
                                            <div class="form-group">
                                                {{ Form::label('app_action_id', 'Rota') }} <br>
                                                {{ Form::select('app_action_id', $routes, isset($menusFilhos) ? $menusFilhos->app_action_id :null, ['class' => 'form-control chosen-select']) }}
                                            </div>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <button type="submit" class="btn btn-sm btn-success"><i
                                                            class="fa fa-save"></i> SALVAR
                                                </button>
                                            </div>
                                        </div>
                                        @if(isset($menusFilhos))
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <a href="{{route('menus.filhos.destroy',$menusFilhos->id)}}"
                                                       type="submit"
                                                       class="btn btn-danger btn-xs pull-right"
                                                       onclick="return confirm('Deseja realmente remover Menu Filho?');"><i
                                                                class="fa fa-trash-o"></i> Remover Menu Filho</a>
                                                </div>
                                            </div>
                                        @endif
                                    </div>

                                    {{ Form::close() }}

                                </div>
                            </div>
                    </div>
                    @endif
                </div>
            </div>

        @endif
    @endif
@section('scripts')
    {{ HTML::script('chosen/chosen.jquery.min.js') }}
    {{ HTML::script('js/carrega_chosen.js') }}
@endsection
@endsection