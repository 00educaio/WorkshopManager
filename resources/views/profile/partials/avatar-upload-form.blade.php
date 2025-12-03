<section class="space-y-6">
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Foto de Perfil') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __('Envie uma nova foto de perfil. Arquivos devem ser imagens de até 2MB.') }}
        </p>
    </header>

    {{-- Foto atual --}}
    <div class="flex items-center gap-4">
        <img 
            src="{{ $user->avatar ? asset('storage/' . $user->avatar) : 'https://placehold.co/600x400/png' }}" 
            class="w-20 h-20 rounded-full object-cover shadow"
        >
    </div>

    {{-- Form simples --}}
    <form method="post" action="{{ route('profile.updateAvatar') }}" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @method('patch')

        <div>
            <x-input-label for="avatar" value="{{ __('Nova imagem') }}" />

            <input 
                id="avatar" 
                name="avatar" 
                type="file" 
                accept="image/*" 
                class="mt-1 block w-full text-sm text-gray-900"
            />

            <x-input-error :messages="$errors->get('avatar')" class="mt-2" />
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>
                {{ __('Salvar Foto') }}
            </x-primary-button> 

            @if (session('status') === 'avatar-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600"
                >{{ __('Imagem Salva') }}</p>
            @endif
        </div>
    </form>
</section>
