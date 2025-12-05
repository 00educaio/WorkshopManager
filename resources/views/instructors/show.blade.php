@extends('layouts.master')

@section('title', 'Devolutiva - Detalhes')

@section('content_header')
@stop

@section('content')

<x-app-layout>
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Painel</a></li>
        <li class="breadcrumb-item"><a href="{{ route('instructors.index') }}">Oficineiros</a></li>
        <li class="breadcrumb-item active">Detalhes</li>
    </ol>

    <div class="py-1">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <!-- Cabeçalho com título e botão voltar -->
                    <div class="flex items-center justify-between mb-8">
                        <div class="flex items-center gap-4">
                            <img class="w-16 h-16 rounded-full" src="{{ $instructor->avatar_img }}" alt="{{ $instructor->name }}">
                            <h1 class="text-xl font-semibold text-gray-900">{{ $instructor->name }}</h1>
                        </div>
                        <div class="flex flex-col gap-1">
                            <a href="{{ route('instructors.index') }}" 
                               class="inline-flex items-center gap-2 px-2 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-aqueles">
                                <i class="fas fa-arrow-left"></i>
                                Voltar
                            </a>

                            <a href=" {{ route('instructors.edit', $instructor) }}"
                               class="inline-flex items-center gap-2 px-2 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-aqueles">
                                <i class="fas fa-edit"></i>
                                Editar
                            </a>

                        </div>
                    </div>

                    <!-- Card com informações principais -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                        <div class="bg-gray-50 rounded-lg p-1">
                            <dt class="text-sm font-medium text-gray-500">N. Devolutivas</dt>
                            <dd class="mt-1 text-lg font-semibold text-gray-900">{{ $instructor->workshopReports->count() }}</dd>
                        </div>

                        <div class="bg-gray-50 rounded-lg p-1">
                            <dt class="text-sm font-medium text-gray-500">N. Oficinas</dt>
                            <dd class="mt-1 text-lg font-semibold text-gray-900">
                                {{ $instructor->unique_workshops_count }}
                            </dd>
                        </div>


                    </div>

                    <!-- Seção de Oficinas Realizadas -->
                    <div class="mt-10">
                        <h2 class="text-xl font-semibold text-gray-900 mb-4">
                            Turmas Atendidas {{$classes->count()}}
                        </h2>

                        @if($classes->count() > 0)
                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-50">
                                      <tr>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                          Turma
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                          Quantidade
                                        </th>
                                      </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                      @foreach($classes as $class)
                                        <tr>
                                          <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                            {{ $class->schoolClass->name }}
                                          </td>
                                          <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $class->total }}
                                          </td>
                                        </tr>
                                      @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <p class="text-gray-500 italic">Nenhuma Turma Atendida.</p>
                        @endif
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
@endsection

@section('css')
    {{-- estilos extras se precisar --}}
@endsection

@section('js')
    {{-- scripts extras se precisar --}}
@endsection