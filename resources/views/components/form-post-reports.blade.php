@php
    // Dados baseados no seu Seeder para popular os selects
    $workshopTimes = ['08:00', '08:45', '09:30', '10:15', '13:00', '13:45', '14:30', '15:15'];
    $workshopThemes = ['Dança', 'Música', 'Literatura', 'Socialização', 'Fotografia', 'Artesanato', 'Robótica', 'Tecnologia'];
    
    // Preparar dados para o AlpineJS (caso seja edição ou erro de validação)
    $oldWorkshops = old('workshops', $report->schoolClasses ?? []);
@endphp

<form method="POST" action="{{ $href }}" 
      class="space-y-8 divide-y divide-gray-200"
      x-data="reportForm()">
    @csrf
    @if(isset($report->id))
        @method('PUT')
    @endif

    <div class="space-y-6 sm:space-y-5">
        
        <!-- Cabeçalho -->
        <div>
            <h3 class="text-lg leading-6 font-medium text-gray-900">Relatório de Oficina</h3>
            <p class="mt-1 max-w-2xl text-sm text-gray-500">Preencha os dados da devolutiva das oficinas realizadas.</p>
        </div>

        <!-- Grupo: Dados Principais -->
        <div class="grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6">
            
            <!-- Data do Relatório -->
            <div class="sm:col-span-3">
                <x-input-label for="report_date" :value="__('Data do Relatório')" icon="fas fa-calendar-alt" />
                <x-text-input id="report_date" name="report_date" type="date" class="mt-1 block w-full" :value="old('report_date', $report->report_date)" required autocomplete="report_date" />
                @error('report_date') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <!-- Instrutor -->
            <div class="sm:col-span-3">
                <x-input-label for="instructor_id" :value="__('Instrutor')" icon="fas fa-chalkboard-teacher" />
                <x-select-form id="instructor_id" 
                               name="instructor_id"
                               :options="$instructors"
                               :selected="old('instructor_id', $report->instructor_id ?? '')" />
                @error('instructor_id') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>
        </div>

        <!-- Grupo: Checkboxes e Booleanos -->
        <div class="grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-3 bg-gray-50 p-4 rounded-lg">
            <!-- Materiais Fornecidos -->
            <div>
                <x-input-label for="materials_provided" :value="__('Materiais Fornecidos?')" size="sm"/>
                <select id="materials_provided" name="materials_provided"
                        class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    <option value="1" {{ old('materials_provided', $report->materials_provided ?? '') == '1' ? 'selected' : '' }}>Sim</option>
                    <option value="0" {{ old('materials_provided', $report->materials_provided ?? '') == '0' ? 'selected' : '' }}>Não</option>
                </select>
                <x-input-error class="mt-2" :messages="$errors->get('materials_provided')" />
            </div>

            <!-- Acordo com a Grade -->
            <div>
                <label for="grid_provided" class="block text-sm font-medium text-gray-700">De acordo com a Grade?</label>
                <select id="grid_provided" name="grid_provided"
                        class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    <option value="1" {{ old('grid_provided', $report->grid_provided ?? '') == '1' ? 'selected' : '' }}>Sim</option>
                    <option value="0" {{ old('grid_provided', $report->grid_provided ?? '') == '0' ? 'selected' : '' }}>Não</option>
                </select>
                <x-input-error class="mt-2" :messages="$errors->get('grid_provided')" />
            </div>

            <!-- Atividade Extra (Com lógica condicional) -->
            <div>
                <label for="extra_activities" class="block text-sm font-medium text-gray-700">Houve Atividade Extra?</label>
                <select id="extra_activities" name="extra_activities" x-model="extraActivities"
                        class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    <option value="0" {{ old('extra_activities', $report->extra_activities ?? '') == '0' ? 'selected' : '' }}>Não</option>
                    <option value="1" {{ old('extra_activities', $report->extra_activities ?? '') == '1' ? 'selected' : '' }}>Sim</option>
                </select>
                <x-input-error class="mt-2" :messages="$errors->get('extra_activities')" />
            </div>
        </div>

        <!-- Descrição da Atividade Extra (Condicional) -->
        <div x-show="extraActivities == '1'" x-transition class="sm:col-span-6">
            <label for="extra_activities_description" class="block text-sm font-medium text-gray-700">Descrição da Atividade Extra</label>
            <div class="mt-1">
                <textarea id="extra_activities_description" name="extra_activities_description" rows="2" 
                          class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border border-gray-300 rounded-md">{{ old('extra_activities_description', $report->extra_activities_description ?? '') }}</textarea>
            </div>
            <x-input-error class="mt-2" :messages="$errors->get('extra_activities_description')" />
        </div>

        <hr class="border-gray-200">

        <!-- SEÇÃO DINÂMICA: Turmas e Horários -->
        <!-- Baseado em DB::table('workshop_report_school_classes') -->
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
                        
                        <!-- Seleção da Turma -->
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

                        <!-- Seleção do Horário (Baseado no array $workshopTimes do seeder) -->
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

                        <!-- Seleção do Tema (Baseado no array $workshopThemes do seeder) -->
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

        <hr class="border-gray-200">

        <!-- Feedbacks e Observações -->
        <div class="grid grid-cols-1 gap-y-6">
            <div>
                <label for="feedback" class="block text-sm font-medium text-gray-700">
                    Feedback Geral <span class="text-red-500">*</span>
                </label>
                <div class="mt-1">
                    <textarea id="feedback" name="feedback" rows="4" required
                              class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border border-gray-300 rounded-md">{{ old('feedback', $report->feedback ?? '') }}</textarea>
                </div>
                @error('feedback') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="observations" class="block text-sm font-medium text-gray-700">Observações Adicionais</label>
                <div class="mt-1">
                    <textarea id="observations" name="observations" rows="3"
                              class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border border-gray-300 rounded-md">{{ old('observations', $report->observations ?? '') }}</textarea>
                </div>
            </div>
        </div>

    </div>

    <!-- Rodapé com Botões -->
    <div class="pt-5 border-t border-gray-200">
        <div class="flex justify-end">
            <button type="button" onclick="window.history.back()"
                    class="bg-white py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                Cancelar
            </button>
            <button type="submit"
                    onclick="this.disabled=true; this.form.submit();"
                    class="ml-3 inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                <i class="fas fa-save mr-2 mt-0.5"></i>
                {{ isset($report->id) ? 'Atualizar Relatório' : 'Salvar Relatório' }}
            </button>
        </div>
    </div>
</form>

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