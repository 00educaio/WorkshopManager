@extends('layouts.master')

@section('title', 'Devolutiva - Detalhes')

@section('content_header')
@stop

@section('content')

<x-app-layout>

    @if (session('success'))
        <div class="mb-4 px-4 py-3 bg-green-100 border border-green-300 text-green-800 rounded-lg shadow-sm">
            {{ session('success') }}
        </div>
    @endif
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Painel</a></li>
        <li class="breadcrumb-item"><a href="{{ route('instructors.index') }}">Oficineiros</a></li>
        <li class="breadcrumb-item active">Detalhes</li>
    </ol>

    <div class="py-1">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <!-- Cabeçalho com título e botões -->
                    <div class="flex items-center justify-between mb-8">
                        <div class="flex items-center gap-4">
                            <img class="w-16 h-16 rounded-full" src="{{ $instructor->avatar_img }}" alt="{{ $instructor->name }}">
                            <h1 class="text-xl font-semibold text-gray-900">{{ $instructor->name }}</h1>
                        </div>
                        <div class="flex flex-col gap-1" x-data="{ showDeleteModal: false }">
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

                            <!-- ADICIONADO: Botão de Apagar -->
                            <button @click="showDeleteModal = true"
                                    type="button"
                                    class="inline-flex items-center gap-2 px-2 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-aqueles">
                                <i class="fas fa-trash"></i>
                                Apagar
                            </button>

                            <div x-show="showDeleteModal" 
                                 style="display: none;"
                                 class="fixed inset-0 z-50 overflow-y-auto" 
                                 aria-labelledby="modal-title" 
                                 role="dialog" 
                                 aria-modal="true">
                                
                                <!-- Fundo escuro (Overlay) -->
                                <div class="flex items-end justify-center mt-4 px-4 text-center sm:block sm:p-0">
                                    <div x-show="showDeleteModal"
                                         x-transition:enter="ease-out duration-300"
                                         x-transition:enter-start="opacity-0"
                                         x-transition:enter-end="opacity-100"
                                         x-transition:leave="ease-in duration-200"
                                         x-transition:leave-start="opacity-100"
                                         x-transition:leave-end="opacity-0"
                                         class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" 
                                         aria-hidden="true"
                                         @click="showDeleteModal = false"></div>

                                    <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

                                    <div x-show="showDeleteModal"
                                         x-transition:enter="ease-out duration-300"
                                         x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                                         x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                                         x-transition:leave="ease-in duration-200"
                                         x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                                         x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                                         class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                                        
                                        <div class="flex items-start justify-between bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                                            <h1>Tem certeza que deseja apagar este instrutor?</h1>
                                            <button @click="showDeleteModal = false" type="button" class="text-gray-400 hover:text-gray-500 focus:outline-none">
                                                <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                                </svg>
                                        </div>
                                        
                                        <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                                            
                                            <!-- 1. O Botão de Apagar (Fica na DIREITA por ser o 1º no row-reverse) -->
                                            <form action="{{ route('instructors.destroy', $instructor) }}" method="POST" class="inline-flex w-full sm:w-auto sm:ml-3">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:w-auto sm:text-sm">
                                                    Sim, Apagar
                                                </button>
                                            </form>
                                            
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- FIM DO MODAL -->

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
    {{-- Se por algum motivo o Alpine não estiver carregando globalmente, descomente a linha abaixo --}}
    {{-- <script src="//unpkg.com/alpinejs" defer></script> --}}
@endsection