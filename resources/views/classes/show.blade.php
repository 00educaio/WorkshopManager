<x-main-view sectionTitle="Turmas - Detalhes">

    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Painel</a></li>
        <li class="breadcrumb-item"><a href="{{ route('classes.index') }}">Turmas</a></li>
        <li class="breadcrumb-item active">Detalhes</li>
    </ol>

    <div class="py-1">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    <!-- Cabeçalho com título e botões -->
                    <div class="flex items-center justify-between mb-8">
                        <div class="flex items-center gap-4">
                            <div class="w-16 h-16 rounded-full bg-gray-200 flex items-center justify-center text-gray-600 text-2xl">                              
                              <img class="w-16 h-16 rounded-full" src="{{ asset('storage/avatars/default-avatar.png') }}" alt="Ícone da Turma">

                            </div>
                            <div>
                                <h1 class="text-xl font-semibold text-gray-900">{{ $class->name }}</h1>
                                <span class="text-sm text-gray-500">{{ $class->grade ?? 'Série não informada' }}</span>
                            </div>
                        </div>

                        <div class="flex flex-col gap-1" x-data="{ showDeleteModal: false }">
                            <a href="{{ route('classes.index') }}" 
                               class="inline-flex items-center gap-2 px-2 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-aqueles">
                                <i class="fas fa-arrow-left"></i>
                                Voltar
                            </a>

                            <a href="{{ route('classes.edit', $class) }}"
                               class="inline-flex items-center gap-2 px-2 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-aqueles">
                                <i class="fas fa-edit"></i>
                                Editar
                            </a>

                            <!-- Botão de Apagar -->
                            <button @click="showDeleteModal = true"
                                    type="button"
                                    class="inline-flex items-center gap-2 px-2 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-aqueles">
                                <i class="fas fa-trash"></i>
                                Apagar
                            </button>

                            <!-- Modal de Confirmação -->
                            <div x-show="showDeleteModal" 
                                 style="display: none;"
                                 class="fixed inset-0 z-50 overflow-y-auto" 
                                 aria-labelledby="modal-title" 
                                 role="dialog" 
                                 aria-modal="true">
                                
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
                                            <h1 class="text-lg font-medium text-gray-900">Tem certeza que deseja apagar esta turma?</h1>
                                            <button @click="showDeleteModal = false" type="button" class="text-gray-400 hover:text-gray-500 focus:outline-none">
                                                <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                                </svg>
                                            </button>
                                        </div>
                                        
                                        <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                                            <form action="{{ route('classes.destroy', $class) }}" method="POST" class="inline-flex w-full sm:w-auto sm:ml-3">
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
                        <div class="bg-gray-50 rounded-lg p-4">
                            <dt class="text-sm font-medium text-gray-500">Nome da Turma</dt>
                            <dd class="mt-1 text-lg font-semibold text-gray-900">{{ $class->name }}</dd>
                        </div>

                        <div class="bg-gray-50 rounded-lg p-4">
                            <dt class="text-sm font-medium text-gray-500">Série / Grau</dt>
                            <dd class="mt-1 text-lg font-semibold text-gray-900">
                                {{ $class->grade ?? '-' }}
                            </dd>
                        </div>

                        <div class="bg-gray-50 rounded-lg p-4">
                            <dt class="text-sm font-medium text-gray-500">ID Origem (Escola/Sist.)</dt>
                            <dd class="mt-1 text-lg font-semibold text-gray-900">
                                {{ $class->origin->name }}
                            </dd>
                        </div>
                    </div>
                    <div class="mt-10">
                        <h2 class="text-xl font-semibold text-gray-900 mb-4">
                            Informações Relacionadas
                        </h2>
                        
                        <div class="bg-yellow-50 border-l-4 border-amber-400 p-4">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <i class="fas fa-info-circle text-amber-400"></i>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm text-amber-700">
                                        Aqui terá um gráfico com quais e quantas oficioneiros, ela teve oficina(Com A, 10. Com B, 20).
                                    </p>
                                </div>
                            </div>
                        </div>

                        {{-- Estrutura de tabela pronta para uso caso tenha dados --}}
                        {{-- 
                        <div class="overflow-x-auto mt-4">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                  <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                      Nome
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                      Detalhe
                                    </th>
                                  </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                  @foreach($class->students as $student)
                                    <tr>
                                      <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                        {{ $student->name }}
                                      </td>
                                      <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        ...
                                      </td>
                                    </tr>
                                  @endforeach
                                </tbody>
                            </table>
                        </div>
                        --}}
                    </div>
                    
                </div>
            </div>

        </div>
    </div>
</x-main-view>