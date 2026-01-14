@props([
    'options' => [],
    'selected' => null,
])

<select {{ $attributes->merge(['class' => 'mt-1 block w-full rounded-md border-red-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm']) }}>
    @foreach ($options as $option)
        <option value="{{ $option->id }}" @selected($selected == $option->id)>
            {{ $option->name }}
        </option>
    @endforeach
</select>