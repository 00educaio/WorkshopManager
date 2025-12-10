@extends('layouts.master')

@section('title', 'Adicionar Turma')

@section('content_header')
@stop

@section('content')

<x-app-layout>
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Painel</a></li>
        <li class="breadcrumb-item"><a href="{{ route('classes.index') }}">Turmas</a></li>
        <li class="breadcrumb-item active">Adicionar</li>
    </ol>

    <div class="py-8">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 lg:p-8">
                    <div class="flex justify-between mb-4">
                        <h2 class="text-xl font-semibold text-gray-900">
                            Nova Turma
                        </h2>
                        <a href="{{ route('classes.index') }}" 
                            class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-aqueles">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                            </svg>
                            Voltar
                        </a>
                    </div>

                    <form method="POST" action="{{ route('classes.store') }}" class="space-y-6">
                        @csrf
                        <!-- Nome da Turma -->
                        <div>
                            <label for="name" class="block text-base font-medium text-gray-700">
                                <i class="fas fa-user mr-1"></i> Nome da Turma
                            </label>
                            <input type="text" name="name" id="name" value="{{ old('name') }}" required
                                   class="mt-1 block w-full rounded-md border- shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm @error('name') border-red-500 @enderror"
                                   placeholder="Ex: Gratidão">
                            @error('name')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Série -->
                        <div>
                            <label for="grade" class="block text-base font-medium text-gray-700">
                                <i class="fas fa-envelope mr-1"></i> E-mail
                            </label>
                            <input type="text" name="grade" id="grade" value="{{ old('grade') }}"
                                   class="mt-1 block w-full rounded-md border-red-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm @error('email') border-red-500 @enderror"
                                   placeholder="2° Série/Ano">
                            @error('grade')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>


                        <!-- Select de School Origin -->

                        <div>
                            <label for="school_class_origin_id" class="block text-base font-medium text-gray-700">
                                <i class="fas fa-school mr-1"></i> Origem Escolar
                            </label>
                            <select id="school_class_origin_id" name="school_class_origin_id" 
                                    class="mt-1 block w-full rounded-md border-red-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm @error('origin_id') border-red-500 @enderror">
                                <option value="">Selecione a origem escolar</option>
                                @foreach($origins as $origin)
                                    <option value="{{ $origin->id }}" {{ old('school_class_origin_id') == $origin->id ? 'selected' : '' }}>
                                        {{ $origin->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('school_class_origin_id')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>


                        <!-- Botões de ação -->
                        <div class="flex items-center justify-end space-x-4 pt-6 border-t border-gray-200">
                            <button type="submit"
                                    class="inline-flex items-center px-5 py-2 border border-transparent text-base font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition">
                                <i class="fas fa-save mr-2"></i>
                                Salvar Oficineiro
                            </button>
                        </div>
                    </form>
                    

                </div>
            </div>
        </div>
    </div>
</x-app-layout>

@stop
