<x-main-view sectionTitle="Devolutivas - Detalhes">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Painel</a></li>
        <li class="breadcrumb-item"><a href="{{ route('reports.index') }}">Devolutivas</a></li>
        <li class="breadcrumb-item active">Detalhes</li>
    </ol>

    <div class="py-1">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <!-- Cabeçalho com título e botão voltar -->
                    <div class="flex items-center justify-between mb-8">
                        <h1 class="text-2xl font-semibold text-gray-900">
                            Devolutiva - {{ $report->report_date }}
                        </h1>
                        <x-deletion-modal
                                backHref="{{ route('reports.index') }}"
                                editHref="{{ route('reports.edit', $report) }}"
                                deleteHref="{{ route('reports.destroy', $report) }}"> 
                            Tem certeza que deseja apagar essa devolutiva?
                        </x-deletion-modal>
                    </div>

                    <!-- Card com informações principais -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                        <div class="bg-gray-50 rounded-lg p-1">
                            <dt class="text-sm font-medium text-gray-500">Instrutor</dt>
                            <dd class="mt-1 text-lg font-semibold text-gray-900">{{ $report->instructor->name }}</dd>
                        </div>

                        <div class="bg-gray-50 rounded-lg p-1">
                            <dt class="text-sm font-medium text-gray-500">Data da devolutiva</dt>
                            <dd class="mt-1 text-lg font-semibold text-gray-900">
                                {{ $report->report_date }}
                            </dd>
                        </div>

                        <div class="bg-gray-50 rounded-lg p-1">
                            <dt class="text-sm font-medium text-gray-500">Atividade extra</dt>
                            <dd class="mt-1 text-lg font-semibold text-gray-900">
                                <span class="{{ $report->extra_activity ? 'text-green-600' : 'text-red-600' }}">
                                    {{ $report->extra_activity ? 'Sim' : 'Não' }}
                                </span>
                            </dd>
                        </div>
                        <div class="bg-gray-50 rounded-lg p-1">
                            <dt class="text-sm font-medium text-gray-500">Os Materiais foram fornecidos</dt>
                            <dd class="mt-1 text-lg font-semibold text-gray-900">
                                <span class="{{ $report->materials_provided ? 'text-green-600' : 'text-red-600' }}">
                                    {{ $report->materials_provided ? 'Sim' : 'Não' }}
                                </span>
                            </dd>
                        </div>
                        <div class="bg-gray-50 rounded-lg p-1">
                            <dt class="text-sm font-medium text-gray-500">Estava de Acordo com a Grade</dt>
                            <dd class="mt-1 text-lg font-semibold text-gray-900">
                                <span class="{{ $report->grid_provided ? 'text-green-600' : 'text-red-600' }}">
                                    {{ $report->grid_provided ? 'Sim' : 'Não' }}
                                </span>
                            </dd>
                        </div>
                    </div>

                    <!-- Seção de Oficinas Realizadas -->

                    <div class="mt-10">
                        <h2 class="text-xl font-semibold text-gray-900 mb-4">Feedback</h2>
                        <div class="bg-gray-50 rounded-lg p-6">
                            <p class="text-gray-700 whitespace-pre-wrap">{{ $report->feedback }}</p>
                        </div>
                    </div>

                    @if($report->observations ?? false)
                        <div class="mt-10">
                            <h2 class="text-xl font-semibold text-gray-900 mb-4">Observações</h2>
                            <div class="bg-gray-50 rounded-lg p-6">
                                <p class="text-gray-700 whitespace-pre-wrap">{{ $report->observations }}</p>
                            </div>
                        </div>
                    @endif
                                        <div class="mt-10">
                        <h2 class="text-xl font-semibold text-gray-900 mb-4">
                            Oficinas Realizadas ({{ $report->unique_workshops_count }})
                        </h2>

                        @if($report->unique_workshops_count > 0)
                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th class="px-6 py-3 text-left text-xs font-medium te37xt-gray-500 uppercase tracking-wider">Turma</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Escola</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tema</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Hora</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        @foreach($report->schoolClasses as $class)
                                            <tr class="hover:bg-gray-50">
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                    {{ $class->schoolClass->name }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                    {{ $class->schoolClass->origin->name }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                    {{ $class->workshop_theme ?? '—' }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                    {{ $class->time ?? '—' }}
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <p class="text-gray-500 italic">Nenhuma oficina associada a esta devolutiva.</p>
                        @endif
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-main-view>