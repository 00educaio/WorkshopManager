<form method="POST" action="{{ $href }}" class="space-y-6">
    @csrf
    @if ($class->id)
        @method('PUT')
    @endif
    <!-- Nome da Turma -->
    <div>
        <label for="name" class="block text-base font-medium text-gray-700">
            <i class="fas fa-user mr-1"></i> Nome da Turma
        </label>
        <input type="text" name="name" id="name" value="{{ $class->name ?? old('name') }}" required
                class="mt-1 block w-full rounded-md border- shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm @error('name') border-red-500 @enderror"
                placeholder="Ex: Gratidão">
        @error('name')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <!-- Série -->
    <div>
        <label for="grade" class="block text-base font-medium text-gray-700">
            <i class="fas fa-envelope mr-1"></i> Série
        </label>
        <input type="text" name="grade" id="grade" value="{{ $class->grade ?? old('grade') }}"
                class="mt-1 block w-full rounded-md border-red-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm @error('email') border-red-500 @enderror"
                placeholder="2° Série/Ano">
        @error('grade')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>


    <!-- Select de School Origin -->

    <div>
        <label for="school_class_origin_id" class="block text-base font-medium text-gray-700">
            <i class="fas fa-school mr-1"></i> Origem Escolar
        </label>
        <select id="school_class_origin_id" name="school_class_origin_id" 
                class="mt-1 block w-full rounded-md border-red-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm @error('origin_id') border-red-500 @enderror">
            <option value="">Selecione a origem escolar</option>
            @foreach($origins as $origin)
                <option value="{{ $origin->id }}" {{ old('school_class_origin_id') == $origin->id ? 'selected' : '' }}>
                    {{ $origin->name }}
                </option>
            @endforeach
        </select>
        @error('school_class_origin_id')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>


    <!-- Botões de ação -->
    <div class="flex items-center justify-end space-x-4 pt-6 border-t border-gray-200">
        <button type="submit"
                class="inline-flex items-center px-5 py-2 border border-transparent text-base font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition">
            <i class="fas fa-save mr-2"></i>
            {{ $class->id ? 'Salvar Alterações' : 'Salvar Turma' }}
        </button>
    </div>
</form>