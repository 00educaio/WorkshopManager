
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
                        <a href="{{ route('instructors.index') }}" 
                            class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-aqueles">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                            </svg>
                            Voltar
                        </a>
                    </div>
                    <x-form-post-instructors href="{{ route('instructors.update' , ['instructor' => $instructor->id]) }}" :instructor="$instructor"></x-form-post-instructors>
                </div>
            </div>
        </div>
    </div>
</x-main-view>