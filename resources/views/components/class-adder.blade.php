@props([
    'report',
    'schoolClasses' => []
    ])
@php
    // Dados baseados no seu Seeder para popular os selects
    $workshopTimes = ['08:00', '08:45', '09:30', '10:15', '13:00', '13:45', '14:30', '15:15'];
    $workshopThemes = ['Dança', 'Música', 'Literatura', 'Socialização', 'Fotografia', 'Artesanato', 'Robótica', 'Tecnologia'];
    
    // Preparar dados para o AlpineJS (caso seja edição ou erro de validação)
    $oldWorkshops = old('workshops', $report->schoolClasses ?? []);
@endphp

<div>
    <div class="flex justify-between items-center mb-4">
        <h3 class="text-lg font-medium text-gray-900"><i class="fas fa-users mr-1"></i> Turmas Atendidas</h3>
        <button type="button" @click="addWorkshop()" 
                class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-medium rounded-full shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none">
            <i class="fas fa-plus mr-1"></i> Adicionar Turma
        </button>
    </div>

    <div class="space-y-3">
        <template x-for="(workshop, index) in workshops" :key="index">
            <div class="flex flex-col sm:flex-row gap-3 items-start sm:items-end bg-gray-50 p-3 rounded-md border border-gray-200">
                
                <div class="w-full sm:w-1/3">
                    <label class="block text-xs font-medium text-gray-500 mb-1">Turma</label>
                    <select :name="'workshops['+index+'][school_class_id]'" x-model="workshop.school_class_id" required
                            class="block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        <option value="">Selecione a Turma</option>
                        @foreach($schoolClasses as $class)
                            <option value="{{ $class->id }}">{{ $class->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="w-full sm:w-1/4">
                    <label class="block text-xs font-medium text-gray-500 mb-1">Horário</label>
                    <select :name="'workshops['+index+'][time]'" x-model="workshop.time" required
                            class="block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        <option value="">Horário</option>
                        @foreach($workshopTimes as $time)
                            <option value="{{ $time }}">{{ $time }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="w-full sm:w-1/3">
                    <label class="block text-xs font-medium text-gray-500 mb-1">Tema da Oficina</label>
                    <select :name="'workshops['+index+'][workshop_theme]'" x-model="workshop.workshop_theme" required
                            class="block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        <option value="">Tema</option>
                        @foreach($workshopThemes as $theme)
                            <option value="{{ $theme }}">{{ $theme }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Botão Remover -->
                <div class="pb-1">
                    <button type="button" @click="removeWorkshop(index)" class="text-red-600 hover:text-red-900">
                        <i class="fas fa-trash-alt"></i>
                    </button>
                </div>
            </div>
        </template>
        
        <!-- Mensagem se não houver turmas -->
        <div x-show="workshops.length === 0" class="text-center text-gray-500 py-4 text-sm italic border-2 border-dashed border-gray-300 rounded-md">
            Nenhuma turma adicionada a este relatório. Clique em "Adicionar Turma".
        </div>
    </div>

    <x-input-error class="mt-2" :messages="$errors->get('workshops.*')" />
</div>


<!-- Scripts Alpine.js -->
<script>
    function reportForm() {
        return {
            extraActivities: '{{ old('extra_activities', $report->extra_activities ?? 0) }}',
            workshops: @json(old('workshops', isset($report) && $report->schoolClasses ? $report->schoolClasses : [])),
            
            addWorkshop() {
                this.workshops.push({
                    school_class_id: '',
                    time: '',
                    workshop_theme: ''
                });
            },
            removeWorkshop(index) {
                this.workshops.splice(index, 1);
            }
        }
    }
</script>