@props(['status'])

@if ($status)
    <div {{ $attributes->merge(['class' => 'mb-4 font-medium text-sm text-green-600 dark:text-green-400']) }}>
        {{ $status }}
    </div>
@endif
