@props([
    'value',
    'icon' => null,
    'size' => 'md',
    ])

<label {{ $attributes->merge(['class' => 'block font-medium text-' . $size . ' text-gray-700']) }}>
    @if ($icon)
        <i class="fas {{ $icon }} mr-1"></i>
    @endif
    {{ $value ?? $slot }}
</label>
