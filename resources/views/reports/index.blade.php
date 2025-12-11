@extends('layouts.master')

@section('title', 'Perfil')

@section('content_header')
@stop

@section('content')

<x-app-layout>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Painel</a></li>
      <li class="breadcrumb-item active">Devolutivas</li>
    </ol>
    <div class="pb-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <!-- Título + Busca (igual ao Breeze) -->
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-6">
                        <span class="text-xl font-semibold text-gray-900">
                            Devolutivas
                        </span>

                        <!-- Form de busca (igual ao Breeze) -->
                        <form method="GET" action="{{ route('classes.index') }}" class="mt-4 sm:mt-0">
                            <div class="flex rounded-md shadow-sm">
                                <input 
                                    type="text" 
                                    name="search" 
                                    value="{{ request('search') }}"
                                    placeholder="Buscar por título ou instrutor..."
                                    class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                                />
                                <button type="submit"
                                    class="ml-2 inline-flex items-center rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                                    <svg class="-ml-0.5 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                    </svg>
                                </button>
                            </div>
                        </form>
                    </div>

                    <!-- Tabela responsiva (igual ao Breeze) -->
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-lg font-medium text-gray-500 uppercase tracking-wider">
                                        Data
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-lg font-medium text-gray-500 uppercase tracking-wider">
                                        Dia da Semana
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-lg font-medium text-gray-500 uppercase tracking-wider">
                                        Instrutor
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-lg font-medium text-gray-500 uppercase tracking-wider">
                                        N. Oficinas
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-lg font-medium text-gray-500 uppercase tracking-wider">
                                        Atividade Extra
                                    </th>
                                    <th scope="col" class="relative px-6 py-3">
                                        
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse ($reports as $report)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-4 whitespace-nowrap text-base font-medium text-gray-900">
                                            {{ $report->report_date }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-base font-medium text-gray-500">
                                            {{ mb_strtoupper(
                                                \Carbon\Carbon::createFromFormat('d/m/Y', $report->report_date)
                                                    ->locale('pt_BR')
                                                    ->isoFormat('dddd'),
                                                'UTF-8'
                                                )
                                            }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-base text-gray-500">
                                            {{ $report->instructor->name }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-base text-gray-500">
                                            {{ $report->schoolClasses->count() }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-base text-gray-500">
                                            @if ($report->extra_activity)
                                                <span class="inline-flex items-center px-3 py-1 text-white text-sm font-semibold rounded-full">
                                                    <i class="fas fa-check mr-2"></i> Sim
                                                </span>
                                            @else
                                                <span class="inline-flex items-center px-3 py-1 bg-red-600 text-white text-sm font-semibold rounded-full">
                                                    <i class="fas fa-times mr-2"></i> Não
                                                </span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-base font-medium">
                                            <a href="{{ route('reports.show', $report) }}" class="ml-2 inline-flex items-center rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                                                Visualizar
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="px-6 py-12 text-center text-gray-500">
                                            @if(request('search'))
                                                Nenhuma oficina encontrada para "{{ request('search') }}"
                                            @else
                                                Nenhuma oficina cadastrada ainda.
                                            @endif
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Paginação (exatamente como no Breeze) -->
                    {{-- <div class="mt-6">
                        {{ $reports->onEachSide(1)->links() }}
                    </div> --}}
                </div>
            </div>
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
