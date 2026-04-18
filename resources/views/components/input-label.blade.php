<label class="floating-label peer-placeholder-shown:text-base peer-placeholder-shown:top-4 {{ $attributes->getData('class') }}">
    {{ $slot->isEmpty() ? __('Input Label') : $slot }}
</label>
