<div class="flex flex-col gap-1" x-data="{ showDeleteModal: false }">
    <x-back-button href="{{ $backHref }}"></x-back-button>

    <x-edit-button href="{{ $editHref }}"></x-edit-button>

    <!-- ADICIONADO: Botão de Apagar -->
    <button @click="showDeleteModal = true"
            type="button"
            class="inline-flex  items-center px-4 py-2 gap-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-aqueles">
        <i class="fas fa-trash"></i>
        Apagar
    </button>

    <!-- MODAL -->
    <div x-show="showDeleteModal"
        x-transition.opacity
        class="fixed inset-0 z-50 flex items-start justify-center pt-20 bg-black bg-opacity-50"
        style="display: none;">

        <!-- Caixa do modal -->
        <div @click.away="showDeleteModal = false"
            x-transition
            class="bg-white rounded-lg shadow-xl w-full max-w-lg">

            <!-- Header -->
            <div class="flex items-start justify-between px-6 py-4 border-b">
                <h2 class="text-lg font-semibold text-gray-900">
                    {{ $slot ?? 'Tem certeza que deseja apagar este item?' }}
                </h2>

                <button @click="showDeleteModal = false" class="text-gray-400 hover:text-gray-600">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>

            <!-- Footer -->
            <div class="px-6 py-4 bg-gray-50 flex justify-end gap-3">

                <!-- Botão cancelar -->
                <button @click="showDeleteModal = false"
                        type="button"
                        class="px-4 py-2 text-sm bg-white border rounded-md shadow-sm hover:bg-gray-100">
                    Cancelar
                </button>

                <!-- Botão apagar -->
                <form action="{{ $deleteHref }}" method="POST">
                    @csrf
                    @method('DELETE')

                    <button type="submit"
                            class="px-4 py-2 text-sm bg-red-600 text-white rounded-md shadow-sm hover:bg-red-700">
                        Sim, Apagar
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- FIM DO MODAL -->

</div>