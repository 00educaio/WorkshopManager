@props(['value'])
@props(['icon'])

<label {{ $attributes->merge(['class' => 'block font-medium text-md text-gray-700']) }}>
    @if ($icon)
        <i class="fas {{ $icon }} mr-1"></i>
    @endif
    {{ $value ?? $slot }}
</label>
