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
                        <div class="flex items-center gap-4 min-w-0">
                            <div class="w-16 h-16 rounded-full bg-gray-200 flex items-center justify-center text-gray-600 text-2xl">                              
                              <img class="w-16 h-16 rounded-full" src="{{ asset('/avatars/default-avatar.png') }}" alt="Ícone da Turma">

                            </div>
                            <div class="min-w-0">
                                <h1 class="text-xl font-semibold text-gray-900 truncate">{{ $class->name }}</h1>
                                <span class="text-sm text-gray-500">{{ $class->grade ?? 'Série não informada' }}</span>
                            </div>
                        </div>

                        <x-deletion-modal
                                backHref="{{ route('classes.index') }}"
                                editHref="{{ route('classes.edit', $class) }}"
                                deleteHref="{{ route('classes.destroy', $class) }}"> 
                            Tem certeza que deseja apagar <strong>{{ $class->name }}</strong>?
                        </x-deletion-modal>
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

                    @if($recentWorkshops)
                        <h2 class="text-xl font-semibold text-gray-900 mb-4 mt-10">
                            Devolutivas Recentes
                        </h2>
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
                                    @forelse($recentWorkshops as $report)
                                        <tr class="hover:bg-gray-50">
                                            <td class="px-6 py-4 whitespace-nowrap text-base font-medium text-gray-900">
                                                {{ $report->formatted_report_date ?? '-' }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-base font-medium text-gray-500">
                                                {{ $report->day_of_week }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-base text-gray-500">
                                                {{ $report->schoolClasses->count() }}
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
                            <div class="mt-6">
                                {{ $recentWorkshops->onEachSide(1)->links() }}
                            </div>
                        </div>
            
                    @elseif($classInfo)
                        <h2 class="text-xl font-semibold text-gray-900 mb-4 mt-10">
                            Oficineiros e Total de Oficinas
                        </h2>
                            {{-- Mostrar todos os instrutores e contagem --}}
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead>
                                <tr>
                                    <th>Oficineiro</th>
                                    <th>Total de Oficinas</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($classInfo as $instructor)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                            {{ $instructor->instructor_name }} 
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $instructor->total_workshops }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                    
                </div>
            </div>


        </div>
    </div>
</x-main-view>