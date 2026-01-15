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

        <x-class-adder 
            :report="$report" 
            :school-classes="$schoolClasses"
        />

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
