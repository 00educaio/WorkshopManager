@extends('layouts.master')

@section('title', 'Perfil')

@section('content_header')
@stop

@section('content')

<x-app-layout>
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Painel</a></li>
        <li class="breadcrumb-item active">Turmas</li>
    </ol>

    <div class="pb-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @forelse ($turmas as $turma)
                <div class="bg-white overflow-hidden shadow-md sm:rounded-lg mb-6">
                    <div class="p-6">
                        <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between">
                            <div class="flex-1">
                                <h3 class="text-lg font-semibold text-gray-900">
                                    {{ $turma->name }}
                                </h3>

                                @if($turma->origin->name)
                                    <p class="mt-1 text-sm text-gray-600">
                                        <i class="fas fa-user-tie mr-1"></i>
                                        Instrutor: <strong>{{ $turma->origin->name }}</strong>
                                    </p>
                                @endif

                                @if($turma->horario)
                                    <p class="mt-1 text-sm text-gray-600">
                                        <i class="fas fa-clock mr-1"></i>
                                        Horário: {{ $turma->horario->format('H:i') }}
                                    </p>
                                @endif

                                @if($turma->vagas !== null)
                                    <p class="mt-1 text-sm text-gray-600">
                                        <i class="fas fa-users mr-1"></i>
                                        Vagas: {{ $turma->vagas }}
                                    </p>
                                @endif

                                @if($turma->descricao)
                                    <p class="mt-4 text-gray-700 leading-relaxed">
                                        {{ $turma->descricao }}
                                    </p>
                                @endif
                            </div>

                            <div class="mt-4 sm:mt-0 sm:ml-6 flex items-center space-x-3">
                                {{-- @if($turma->vagas > 0)
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        Vagas disponíveis
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                        Lotada
                                    </span>
                                @endif --}}

                                {{-- route('turmas.show', $turma) --}}
                                <a href="" 
                                   class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-indigo-700 bg-indigo-100 hover:bg-indigo-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    Ver detalhes
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-12 text-center">
                        <i class="fas fa-calendar-times text-6xl text-gray-300 mb-4"></i>
                        <h3 class="text-lg font-medium text-gray-900">Nenhuma turma disponível</h3>
                        <p class="mt-2 text-gray-600">Em breve novas turmas serão abertas.</p>
                    </div>
                </div>
            @endforelse
        </div>
    </div>
</x-app-layout>

@stop

@section('css')
    {{-- Add here extra stylesheets --}}
    {{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
@stop

@section('js')
    <script> console.log("Hi, I'm using the Laravel-AdminLTE package!"); </script>
@stop
