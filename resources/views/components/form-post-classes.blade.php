<form method="POST" action="{{ $href }}" class="space-y-6">
    @csrf
    @if ($class->id)
        @method('PUT')
    @endif
    <!-- Nome da Turma -->
    <div>
        <x-input-label for="name" :value="__('Nome da Turma')" icon="fas fa-user" />
        <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" placeholder="Gratidão" :value="old('name', $class->name)" required autocomplete="name" />
        <x-input-error class="mt-2" :messages="$errors->get('name')" />
    </div>

    <!-- Série -->
    <div>
        <x-input-label for="grade" :value="__('Série')" icon="fas fa-layer-group" />
        <x-text-input id="grade" name="grade" type="text" class="mt-1 block w-full" placeholder="2° Ano" :value="old('grade', $class->grade)" required autocomplete="grade" />
        <x-input-error class="mt-2" :messages="$errors->get('grade')" />
    </div>


    <!-- Select de School Origin -->

    <div>
        <x-input-label for="school_class_origin_id" :value="__('Origem Escolar')" icon="fas fa-school" />
        <x-select-form id="school_class_origin_id" 
                       name="school_class_origin_id"
                       :options="$origins"
                       :selected="old('school_class_origin_id', $class->school_class_origin_id)" />
        <x-input-error class="mt-2" :messages="$errors->get('school_class_origin_id')" />

        @error('school_class_origin_id')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>


    <!-- Botões de ação -->
    <div class="flex items-center justify-end space-x-4 pt-6 border-t border-gray-200">
        <x-save-button>
            {{ $class->id ? __('Atualizar Turma') : __('Salvar Turma') }}
        </x-save-button>
    </div>
</form>