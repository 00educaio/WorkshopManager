@extends('layouts.master')

@section('title', 'Acesso Negado')

@section('content_header')
@stop

@section('content')

<x-app-layout>
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Painel</a></li>
        <li class="breadcrumb-item active">Erro 403</li>
    </ol>
    
    <div class="pb-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white overflow-hidden shadow-md sm:rounded-lg mt-8">
                <div class="p-12 text-center">
                    {{-- Ícone de bloqueio/erro --}}
                    <div class="mb-4">
                        <i class="fas fa-lock text-6xl text-red-500"></i>
                    </div>

                    {{-- Título do Erro --}}
                    <h1 class="text-4xl font-bold text-gray-900 mb-2">403</h1>
                    <h3 class="text-xl font-semibold text-gray-800">Acesso Negado</h3>

                    {{-- Mensagem descritiva --}}
                    <p class="mt-4 text-gray-600 max-w-lg mx-auto">
                        Desculpe, você não tem permissão para acessar esta página ou realizar esta ação. 
                        Se você acredita que isso é um erro, contate o administrador do sistema.
                    </p>

                    {{-- Botão de Ação (Voltar) --}}
                    <div class="mt-8">
                        <a href="{{ route('dashboard') }}" 
                           class="inline-flex items-center gap-2 px-4 py-2 border border-transparent text-base font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition">
                            <i class="fas fa-arrow-left"></i>
                            Voltar para o Painel
                        </a>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>

@stop