
<x-main-view sectionTitle="Oficineiros - Editar">

    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Painel</a></li>
        <li class="breadcrumb-item"><a href="{{ route('instructors.index') }}">Oficineiros</a></li>
        <li class="breadcrumb-item active">Editar</li>
    </ol>
    <div class="py-8">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 lg:p-8">
                    <div class="flex justify-between mb-4">
                        <h2 class="text-xl font-semibold text-gray-900">
                            Novo Oficineiro
                        </h2>
                        <x-back-button href="{{ route('instructors.index') }}"></x-back-button>
                    </div>
                    <x-form-post-instructors href="{{ route('instructors.update' , ['instructor' => $instructor->id]) }}" :instructor="$instructor"></x-form-post-instructors>
                </div>
            </div>
        </div>
    </div>
</x-main-view>