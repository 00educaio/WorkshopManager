<x-main-view sectionTitle="Home">
    <div class="py-8">

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    
                    <div class="flex items-center justify-between mb-8">
                        <h1 class="text-2xl font-semibold text-gray-900">
                            Bem-vindo, {{ auth()->user()->name }}!
                        </h1>
                    </div>
                    

                </div>
            </div>
        </div>
        
    </div>
</x-main-view>
