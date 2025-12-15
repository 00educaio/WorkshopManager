<x-main-view sectionTitle="Devolutivas - Adicionar">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Painel</a></li>
    <li class="breadcrumb-item"><a href="{{ route('reports.index') }}">Devolutivas</a></li>
    <li class="breadcrumb-item active">Editar</li>
  </ol>

  <div class="py-8">
    <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
      <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 lg:p-8">
          <div class="flex justify-between mb-4">
            <h2 class="text-xl font-semibold text-gray-900">
              Editar Devolutiva
            </h2>
            <x-back-button href="{{ route('reports.index') }}"></x-back-button>
          </div>

          <x-form-post-reports href="{{ route('reports.update' , ['report' => $report->id]) }}" :instructors="$instructors" :schoolClasses="$schoolClasses" :report="$report"></x-form-post-reports>
        </div>
      </div>
    </div>
  </div>
</x-main-view>