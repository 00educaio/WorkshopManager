<x-main-view sectionTitle="Oficineiros">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Painel</a></li>
        <li class="breadcrumb-item active">Oficineiros</li>
    </ol>
    
    <div class="pb-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="flex justify-between mb-6 mt-8">
                <div class="flex items-center gap-3">
                    <span class="text-3xl font-bold text-gray-900">Oficineiros</span>
                    <span class="px-2 py-1 text-xs text-white font-semibold bg-red-100 rounded-full" style="background-color: #28a745;">
                        {{ $instructors->count() }} Ativos
                    </span>
                </div>
                <x-create-button href="{{ route('instructors.create') }}">
                    Oficineiro
                </x-create-button>
            </div>

            @forelse ($instructors as $instructor)
                <div class="bg-white overflow-hidden shadow-md rounded-lg mb-4 sm:mb-6">
                    <div class="p-4 sm:p-6">
                        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                            
                            <!-- Informações do Instrutor -->
                            <div class="flex-1">
                                <h3 class="text-lg font-bold text-gray-900 flex items-center">
                                    <div class="p-2 bg-indigo-50 rounded-full mr-2 text-indigo-600 flex items-center justify-center">
                                        <i class="fas fa-user-tie text-sm"></i>
                                    </div>
                                    {{ $instructor->name }}
                                </h3>

                                <!-- Container de Estatísticas (Grid para melhor visualização) -->
                                <div class="mt-3 flex flex-col gap-2">
                                    <p class="text-sm text-gray-600 flex items-center">
                                        <i class="fas fa-file-alt mr-2 text-gray-400 w-4 text-center"></i>
                                        Devolutivas: 
                                        <strong class="ml-1 text-gray-800">{{ $instructor->workshopReports->count() }}</strong>
                                    </p>

                                    <p class="text-sm text-gray-600 flex items-center">
                                        <i class="fas fa-chalkboard-teacher mr-2 text-gray-400 w-4 text-center"></i>
                                        Oficinas:
                                        <strong class="ml-1 text-gray-800">{{ $instructor->unique_workshops_count }}</strong>
                                    </p>
                                </div>

                            </div>

                            <!-- Botão de Ação -->
                            <div class="flex items-center">
                                <a href="{{ route('instructors.show', $instructor->id) }}" 
                                class="w-full sm:w-auto inline-flex justify-center items-center px-4 py-3 sm:py-2 border border-transparent text-sm font-medium rounded-md text-indigo-700 bg-indigo-50 hover:bg-indigo-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors duration-200">
                                    Ver detalhes
                                    <i class="fas fa-arrow-right ml-2 sm:hidden"></i> <!-- Seta visível apenas no mobile para indicar ação -->
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-12 text-center">
                        <i class="fas fa-calendar-times text-6xl text-gray-300 mb-4"></i>
                        <h3 class="text-lg font-medium text-gray-900">Nenhum oficineiro cadastrado</h3>
                        <p class="mt-2 text-gray-600">Clique no botão acima para adicionar o primeiro oficineiro.</p>
                    </div>
                </div>
            @endforelse

            <x-trashed-button href="{{ route('instructors.trashed') }}">
                Oficineiros Excluídos
            </x-trashed-button>
        </div>
    </div>
</x-main-view>