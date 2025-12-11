<div class="flex items-center justify-end space-x-4 pt-6 border-t border-gray-200">
    <a href="{{ $href }}"
            class="inline-flex items-center gap-2 px-3 py-2 border border-transparent text-base font-medium rounded-md shadow-sm text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition">
        <i class="fas fa-trash"></i>
        {{ $slot }}
    </a>
</div>