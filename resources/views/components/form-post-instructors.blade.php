<form method="POST" action="{{ $href }}" class="space-y-6">
    @csrf
    @if ($instructor->id)
        @method('PUT')
    @endif
    <!-- Nome completo -->
    <div>
        <label for="name" class="block text-base font-medium text-gray-700">
            <i class="fas fa-user mr-1"></i> Nome completo
        </label>
        <input type="text" name="name" id="name" value="{{ $instructor->name ?? old('name') }}" required
                class="mt-1 block w-full rounded-md border- shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm @error('name') border-red-500 @enderror"
                placeholder="Ex: Maria Clara Araujo">
        @error('name')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <!-- E-mail -->
    <div>
        <label for="email" class="block text-base font-medium text-gray-700">
            <i class="fas fa-envelope mr-1"></i> E-mail
        </label>
        <input type="email" name="email" id="email" value="{{ $instructor->email ?? old('email') }}"
                class="mt-1 block w-full rounded-md border-red-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm @error('email') border-red-500 @enderror"
                placeholder="exemplo@dominio.com">
        @error('email')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <!-- Telefone / WhatsApp -->
    <div>
        <label for="phone" class="block text-base font-medium text-gray-700">
            <i class="fas fa-phone mr-1"></i> Telefone / WhatsApp
        </label>
        <input type="text" name="phone" id="phone" value="{{ $instructor->phone ?? old('phone') }}"
                class="mt-1 block w-full rounded-md border-red-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm @error('phone') border-red-500 @enderror"
                placeholder="(99) 99999-9999">
        @error('phone')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <!-- CPF -->
    <div>
        <label for="cpf" class="block text-base font-medium text-gray-700">
            <i class="fas fa-id-card mr-1"></i> CPF 
        </label>
        <input type="text" name="cpf" id="cpf" value="{{ $instructor->cpf ?? old('cpf') }}"
                class="mt-1 block w-full rounded-md border-red-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                placeholder="000.000.000-00">
    </div>

    <!-- Botões de ação -->
    <div class="flex items-center justify-end space-x-4 pt-6 border-t border-gray-200">
        <button type="submit"
                class="inline-flex items-center px-5 py-2 border border-transparent text-base font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition">
            <i class="fas fa-save mr-2"></i>
            {{ $instructor->id ? 'Salvar Alterações' : 'Salvar Oficineiro' }}
        </button>
    </div>
</form>