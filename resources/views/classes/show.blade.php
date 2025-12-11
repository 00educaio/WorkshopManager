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
                            
                            <x-back-button href="{{ route('classes.index') }}"></x-back-button>

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
                                x-transition.opacity
                                class="fixed inset-0 z-50 flex items-start justify-center pt-20 bg-black bg-opacity-50"
                                style="display: none;">

                                <!-- Caixa do modal -->
                                <div @click.away="showDeleteModal = false"
                                    x-transition
                                    class="bg-white rounded-lg shadow-xl w-full max-w-lg">

                                    <!-- Header -->
                                    <div class="flex items-start justify-between px-6 py-4 border-b">
                                        <h2 class="text-lg font-semibold text-gray-900">
                                            Tem certeza que deseja apagar esta turma?
                                        </h2>

                                        <button @click="showDeleteModal = false" class="text-gray-400 hover:text-gray-600">
                                            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M6 18L18 6M6 6l12 12"/>
                                            </svg>
                                        </button>
                                    </div>

                                    <!-- Footer -->
                                    <div class="px-6 py-4 bg-gray-50 flex justify-end gap-3">

                                        <!-- Botão cancelar -->
                                        <button @click="showDeleteModal = false"
                                                type="button"
                                                class="px-4 py-2 text-sm bg-white border rounded-md shadow-sm hover:bg-gray-100">
                                            Cancelar
                                        </button>

                                        <!-- Botão apagar -->
                                        <form action="{{ route('classes.destroy', $class) }}" method="POST">
                                            @csrf
                                            @method('DELETE')

                                            <button type="submit"
                                                    class="px-4 py-2 text-sm bg-red-600 text-white rounded-md shadow-sm hover:bg-red-700">
                                                Sim, Apagar
                                            </button>
                                        </form>
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