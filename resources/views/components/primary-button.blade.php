<button {{ $attributes->merge(['type' => 'submit', 'class' => 'horizon-btn w-full flex items-center justify-center']) }}>
    {{ $slot }}
</button>