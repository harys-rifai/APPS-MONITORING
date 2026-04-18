@props(['messages'])

@if ($messages)
    @foreach ((array) $messages as $message)
        <div {{ $attributes->merge(['class' => 'mt-2 text-sm text-red-600 dark:text-red-500 shake-error p-2 bg-red-50/80 backdrop-blur-sm rounded-xl border-l-4 border-red-500 animate-pulse']) }}>
            {{ $message }}
        </div>
    @endforeach
@endif
