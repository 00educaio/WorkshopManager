<x-main-view sectionTitle="Devolutivas">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Painel</a></li>
      <li class="breadcrumb-item active">Devolutivas</li>
    </ol>
    <div class="pb-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
             <div class="flex justify-between mb-6 mt-8">
                <div class="flex items-center gap-3">
                    <span class="text-3xl font-bold text-gray-900">Devolutivas</span>
                </div>
                <x-create-button href="{{ route('reports.create') }}">
                    Devolutiva
                </x-create-button>
            </div>
            <div class="bg-white overflow-hidden shadow sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <div class="mb-6">
                        <form method="GET" action="{{ route('reports.index') }}" class="w-full">
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">

                                <!-- Data início -->
                                <div class="w-full">
                                    <label class="block text-sm font-medium text-gray-700">Data início</label>
                                    <input
                                        type="date"
                                        name="start_date"
                                        value="{{ request('start_date') }}"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                    >
                                </div>

                                <!-- Data fim -->
                                <div class="w-full">
                                    <label class="block text-sm font-medium text-gray-700">Data fim</label>
                                    <input
                                        type="date"
                                        name="end_date"
                                        value="{{ request('end_date') }}"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                    >
                                </div>

                                @if(auth()->user()->hasAnyRole(['admin', 'manager']))
                                <div class="w-full">
                                    <label class="block text-sm font-medium text-gray-700">Instrutor</label>
                                    <input
                                        type="text"
                                        name="instructor"
                                        value="{{ request('instructor') }}"
                                        placeholder="Nome do oficineiro"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                    >
                                </div>
                                @else
                                <!-- Div vazia apenas para manter alinhamento  -->
                                <div class="hidden lg:block"></div>
                                @endif

                                <div class="flex items-end gap-2 h-full">
                                    <button
                                        type="submit"
                                        class="flex-1 lg:flex-none justify-center inline-flex items-center gap-2 rounded-md bg-indigo-600 px-4 py-2 text-white font-semibold hover:bg-indigo-500 transition duration-150 ease-in-out"
                                    >
                                        <i class="fas fa-search"></i>
                                        Buscar
                                    </button>
                                    
                                    <a
                                        href="{{ route('reports.index') }}"
                                        class="flex-1 lg:flex-none justify-center inline-flex items-center gap-2 rounded-md bg-gray-300 px-4 py-2 text-gray-800 font-semibold hover:bg-gray-400 transition duration-150 ease-in-out"
                                    >
                                        <i class="fas fa-eraser"></i>
                                        Limpar
                                    </a>
                                </div>

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
                                            {{ $report->formatted_report_date ?? '-' }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-base font-medium text-gray-500">
                                            {{ $report->day_of_week }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-base {{ $report->instructor->trashed() ? 'text-red-500' : 'text-gray-500' }}">
                                            {{ $report->instructor_name }}
                                            @if($report->instructor->trashed())
                                                <span class="text-xs italic">(Inativo)</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-base text-gray-500">
                                            {{ $report->unique_workshops_count }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-base text-gray-500">
                                            @if ($report->extra_activities)
                                                <span class="inline-flex items-center px-3 py-1 bg-green-600 text-white text-sm font-semibold rounded-full">
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

                    <div class="mt-6">
                        {{ $reports->onEachSide(1)->links() }}
                    </div> 
                </div>
            </div>
        </div>
    </div>
</x-main-view>