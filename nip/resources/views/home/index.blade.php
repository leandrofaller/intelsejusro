
{{--@if(Auth::user()->perfil == 'Externo')--}}


@extends('layouts.template')
@section('titulo', 'SIPEN')
    @section('conteudo')
        @include('flash.message')
        <!-- /section:settings.box -->
        <div class="page-header">
            <h1>
                PÁGINA PRINCIPAL
            </h1>
        </div><!-- /.page-header -->
        @if(Auth::user()->perfil == 'Admin')
            @include('home.admins')
        @elseif(Auth::user()->perfil == 'Servidor')
            @include('home.servidores')
        @else
            @include('home.externo')
        @endif
    @endsection
    @section('scripts')
    @endsection