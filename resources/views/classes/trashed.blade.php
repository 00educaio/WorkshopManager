<x-main-view sectionTitle="Turmas - Lixeira">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Painel</a></li>
        <li class="breadcrumb-item"><a href="{{ route('classes.index') }}">Turmas</a></li>
        <li class="breadcrumb-item active">Lixeira</li>
    </ol>
    
    <div class="pb-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="flex justify-between mb-6 mt-8">
                <div class="flex items-center gap-3">
                    <span class="text-3xl font-bold text-gray-900">Lixeira</span>
                    <span class="px-2 py-1 text-xs font-semibold text-red-700 bg-red-100 rounded-full">
                        {{ $classes->count() }} Inativas
                    </span>
                </div>
                
                <x-back-button href="{{ route('classes.index') }}"></x-back-button>

            </div>

            @forelse ($classes as $class)
                <!-- Adicionado x-data aqui para escopar o modal por item -->
                <div x-data="{ showDeleteModal: false }" class="bg-red-50 border border-red-100 overflow-hidden shadow-sm sm:rounded-lg mb-6 relative">
                    
                    <!-- Faixa lateral indicando status -->
                    <div class="absolute left-0 top-0 bottom-0 w-1 bg-red-400"></div>

                    <div class="p-6 pl-8"> 
                        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                            <div class="flex-1">
                                <div class="flex items-center gap-2">
                                    <h3 class="text-lg font-semibold text-gray-900 line-through decoration-red-500">
                                        {{ $class->name }}
                                    </h3>
                                    <span class="text-xs text-red-600 bg-red-200 px-2 py-0.5 rounded">Excluído</span>
                                </div>
                                <div class="mt-3 flex flex-col gap-2">
                                    <p class="mt-2 text-sm text-gray-600">
                                        <i class="fas fa-calendar-times mr-1 text-red-400"></i>
                                        Data da exclusão: <strong>{{ $class->deleted_at->format('d/m/Y H:i') }}</strong>
                                    </p>
                                </div>

                            </div>

                            <form action="{{ route('classes.restore', $class->id) }}" method="POST" class="flex items-center">
                                @csrf
                                @method('PATCH')
                                <button type="submit" 
                                        class="w-full sm:w-auto inline-flex justify-center items-center gap-2 px-3 py-3 sm:py-2 border border-transparent text-sm font-medium rounded-md text-green-700 bg-green-100 hover:bg-green-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition"
                                        title="Recuperar oficineiro">
                                    <i class="fas fa-trash-restore"></i>
                                    Restaurar
                                </button>
                            </form>
                            
                        </div>
                    </div>

                </div>
            @empty
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border-2 border-dashed border-gray-300">
                    <div class="p-12 text-center">
                        <i class="fas fa-trash-alt text-6xl text-gray-200 mb-4"></i>
                        <h3 class="text-lg font-medium text-gray-500">Lixeira vazia</h3>
                        <p class="mt-2 text-gray-400">Não há Turmas inativas no momento.</p>
                        <a href="{{ route('classes.index') }}" class="mt-4 inline-block text-indigo-600 hover:text-indigo-800">
                            Voltar para a lista ativa
                        </a>
                    </div>
                </div>
            @endforelse
        </div>
    </div>
</x-main-view>