<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center px-5 py-2 border border-transparent text-base font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition', 'onclick' => 'this.disabled=true; this.form.submit();']) }}>
    <i class="fas fa-save mr-2"></i>
    {{ $slot }}
</button>
