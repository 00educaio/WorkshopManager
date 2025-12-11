<x-main-view sectionTitle="Turmas - Adicionar">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Painel</a></li>
        <li class="breadcrumb-item"><a href="{{ route('classes.index') }}">Turmas</a></li>
        <li class="breadcrumb-item active">Adicionar</li>
    </ol>

    <div class="py-8">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 lg:p-8">
                    <div class="flex justify-between mb-4">
                        <h2 class="text-xl font-semibold text-gray-900">
                            Nova Turma
                        </h2>
                        <x-back-button href="{{ route('classes.index') }}"></x-back-button>
                    </div>

                    <x-form-post-classes href="{{ route('classes.store') }}" :origins="$origins"></x-form-post-classes>
                    

                </div>
            </div>
        </div>
    </div>
</x-main-view>