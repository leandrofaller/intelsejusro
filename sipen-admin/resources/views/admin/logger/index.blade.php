@extends('layout.master')
<?php
use App\Models\Logger; ?>
@section('head')
    {{ HTML::style('css/bootstrap-datepicker.css') }}
    {{ HTML::style('css/timeline.css') }}
@endsection

@section('main')
    <div class="row">
        <div class="col-md-6">
            <h2><a href="{{ route('logger.index') }}">{{ icon('gears text-muted') . $title }}</a></h2>
        </div>
        <div class="col-md-6">
        </div>
    </div>
        <hr>
        @include('flash.message')
    <div class="panel panel-default">
        <div class="panel-heading"></div>
        <div class="panel-body">
        {{ Form::open(['method' => 'GET']) }}
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    {{ Form::label('app_id', 'Sistema') }}
                    {{ Form::select('app_id', $apps, Request::get('app_id'), ['autofocus', 'class' => 'form-control']) }}
                </div>
            </div>
            <div class="col-md-5">
                <div class="form-group">
                    {{ Form::label('username', 'Parâmetros') }}
                    {{ Form::text('argumento',Request::has('argumento') ? Request::get('argumento') : null, ['class' => 'form-control', 'placeholder' => 'Digite nome,cpf ou email']) }}
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    {{ Form::label('alert', 'Tipo de log') }}
                    {{ Form::select('alert', $alert, Request::has('alert') ? Request::get('alert') : 0, ['class' => 'chosen-select form-control']) }}
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">

                    {{ Form::label('dt_inicio', 'Data inicial') }}
                    {{ Form::text('dt_inicio', Request::has('dt_inicio') ? Request::get('dt_inicio') : $hoje, ['class' => 'form-control date']) }}
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">

                    {{ Form::label('dt_fim', 'Data final') }}
                    {{ Form::text('dt_fim', Request::has('dt_fim') ? Request::get('dt_fim') : $hoje, ['class' => 'form-control date']) }}
                </div>
            </div>
            <div class="well well-sm col-md-12">
                <button type="submit" class="btn btn-primary btn-sm">{{ icon('filter') }} FILTRAR</button>
                <button type="button" onclick="history.go(-1)" class="btn btn-default pull-right btn-sm">{{icon('arrow-left')}} VOLTAR
                </button>
            </div>
        </div>
        {{ Form::close() }}
        </div>
    </div>


            <div id="timeline-1">
                <div class="row">
                    <div class="col-xs-12 col-sm-10 col-md-12">
                        @if(isset($logs))
                        @forelse($logs as $log)
                            <div class="timeline-container">
                                <div class="timeline-label">
													<span class="label label-{{alert($log->alert)}} arrowed-in-right label-lg">
														<b>{{dataFormat($log->created_at)}}</b>
													</span>
                                </div>

                                <div class="timeline-items">
                                    <div class="timeline-item clearfix">
                                        <div class="timeline-info">
                                            <i class="timeline-indicator ace-icon fa fa-{{alertIcon($log->alert)}} btn btn-{{alert($log->alert)}} no-hover"></i>
                                        </div>

                                        <div class="widget-box transparent">
                                            <div class="widget-header widget-header-small">
                                                <h5 class="widget-title smaller">{{$log->title}}</h5>

                                                <span class="widget-toolbar no-border">
																	<i class="ace-icon fa fa-clock-o bigger-110"></i>
                                                    {{horaFormatada($log->created_at)}}
																</span>

                                                <span class="widget-toolbar">
																	<a href="#" data-action="collapse">
																		<i class="ace-icon fa fa-chevron-up"></i>
																	</a>
																</span>
                                            </div>

                                            <div class="widget-body">
                                                <div class="widget-main">
                                                   {{$log->message}}
                                                </div>
                                            </div>
                                            <div class="space-6"></div>
                                            <div class="widget-toolbox clearfix">
                                                <div class="pull-left">
                                                    <i class="ace-icon fa fa-globe grey bigger-125"></i>
                                                    {{$log->name}}

                                                </div>

                                                <div class="pull-right action-buttons">
                                                    <i class="ace-icon fa fa-user grey bigger-125"></i>
                                                    {{$log->nome}}
                                                </div>
                                            </div>
                                            <div class="space-8"></div>
                                        </div>
                                    </div>
                                </div><!-- /.timeline-items -->
                            </div><!-- /.timeline-container -->

                            @empty
                            <div class="well well-sm text-center">
                                <span> <h4>{{icon('info-circle')}} Nada encontrado</h4></span>
                            </div>

                        @endforelse
                        @endif
                    </div>
                </div>
            </div>







@section('scripts')
    {{ HTML::script('js/jquery.maskedinput.min.js') }}
    {{ HTML::script('js/bootstrap-datepicker.min.js') }}
    {{ HTML::script('js/bootstrap-datepicker.pt-BR.min.js') }}
    {{ HTML::script('js/mascara.js') }}

@endsection
@endsection