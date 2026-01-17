<div class="flex items-center justify-center">
    <button
        wire:click="toggleTheme"
        type="button"
        class="relative inline-flex h-10 w-20 items-center rounded-full transition-colors duration-200
            {{ $theme === 'dark' ? 'bg-primary-600 dark:bg-primary-500' : 'bg-gray-200 dark:bg-gray-700' }}"
        title="{{ $theme === 'dark' ? __('app.label.switch_to_light') : __('app.label.switch_to_dark') }}"
    >
        <span class="sr-only">{{ __('app.label.toggle_theme') }}</span>
        <span
            class="inline-block h-8 w-8 transform rounded-full bg-white transition-transform duration-200 flex items-center justify-center
                {{ $theme === 'dark' ? 'translate-x-11' : 'translate-x-1' }}"
        >
            @if($theme === 'dark')
                <svg class="h-5 w-5 text-gray-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
                </svg>
            @else
                <svg class="h-5 w-5 text-yellow-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
                </svg>
            @endif
        </span>
    </button>
</div>
