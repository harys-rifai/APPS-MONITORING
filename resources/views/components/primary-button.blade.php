<button {{ $attributes->merge(['type' => 'submit', 'class' => 'btn-login group font-["figtree"] text-base']) }}>
    <span class="relative z-10 flex items-center justify-center w-full h-full">
        {{ $slot }}
    </span>
</button>
