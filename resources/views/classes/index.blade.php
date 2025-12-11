<x-main-view sectionTitle="Turmas">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Painel</a></li>
        <li class="breadcrumb-item active">Turmas</li>
    </ol>

    <div class="pb-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="flex justify-between mb-6 mt-8">
                <div class="flex items-center gap-3">
                    <span class="text-3xl font-bold text-gray-900">Turmas</span>
                </div>
                @if(auth()->user()->hasAnyRole(['admin', 'manager']))
                    <x-create-button href="{{ route('classes.create') }}">
                        Turma
                    </x-create-button>
                @endif
            </div>
            
            @forelse ($classes as $class)
                <div class="bg-white overflow-hidden shadow-md sm:rounded-lg mb-6">
                    <div class="p-6">
                        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                            
                            <div class="flex-1">
                                <h3 class="text-lg font-bold text-gray-900 flex items-center">
                                    {{ $class->name }}
                                </h3>

                                <div class="mt-3 flex flex-col gap-2">
                                    <p class="text-sm text-gray-600 flex items-center">
                                        <i class="fas fa-school mr-2 text-gray-400 w-4 text-center"></i>
                                        {{ $class->origin->name ?? 'N/A' }}
                                    </p>
                                </div>

                            </div>

                            <!-- Botão de Ação -->
                            <div class="flex items-center">
                                <a href="{{ route('classes.show', $class->id) }}" 
                                class="w-full sm:w-auto inline-flex justify-center items-center px-4 py-3 sm:py-2 border border-transparent text-sm font-medium rounded-md text-indigo-700 bg-indigo-50 hover:bg-indigo-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors duration-200">
                                    Ver detalhes
                                    <i class="fas fa-arrow-right ml-2 sm:hidden"></i>
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
            
            @if(auth()->user()->hasAnyRole(['admin', 'manager']))
                <x-trashed-button href="{{ route('classes.trashed') }}">
                    Turmas Excluídas
                </x-trashed-button>
                
            @endif
        </div>
    </div>
</x-main-view>
