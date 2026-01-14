<form method="POST" action="{{ $href }}" class="space-y-6">
    @csrf
    @if ($instructor->id)
        @method('PUT')
    @endif
    <!-- Nome completo -->
    <div>
        <x-input-label for="name" :value="__('Nome completo')" icon="fas fa-user" />
        <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" placeholder="Maria Clara Silva" :value="old('name', $instructor->name)" required autocomplete="name" />
        <x-input-error class="mt-2" :messages="$errors->get('name')" />
    </div>

    <!-- E-mail -->
    <div>
        <x-input-label for="email" :value="__('E-mail')" icon="fas fa-envelope" />
        <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" placeholder="clara@gmail.com" :value="old('email', $instructor->email)" required autocomplete="email" />
        <x-input-error class="mt-2" :messages="$errors->get('email')" />
    </div>

    <!-- Telefone / WhatsApp -->
    <div>
        <x-input-label for="phone" :value="__('Telefone / WhatsApp')" icon="fas fa-phone" />
        <x-text-input id="phone" name="phone" type="text" class="mt-1 block w-full" placeholder="(00) 00000-0000" :value="old('phone', $instructor->phone)" required autocomplete="phone" />
        <x-input-error class="mt-2" :messages="$errors->get('phone')" />
    </div>

    <!-- CPF -->
    <div>
        <x-input-label for="cpf" :value="__('CPF')" icon="fas fa-id-card" />
        <x-text-input id="cpf" name="cpf" type="text" class="mt-1 block w-full" placeholder="000.000.000-00" :value="old('cpf', $instructor->cpf)" required autocomplete="cpf" />
        <x-input-error class="mt-2" :messages="$errors->get('cpf')" />
    </div>

    <!-- Botões de ação -->
    <div class="flex items-center justify-end space-x-4 pt-6 border-t border-gray-200">
        <x-save-button>
            {{ $instructor->id ? __('Atualizar Instrutor') : __('Salvar Instrutor') }}
        </x-save-button>
    </div>
</form>