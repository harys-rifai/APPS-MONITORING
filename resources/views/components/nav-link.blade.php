@props(['active'])

@php
$classes = ($active ?? false)
            ? 'sidebar-item active'
            : 'sidebar-item';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
