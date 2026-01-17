<div class="flex gap-2 items-center justify-center">
    @foreach($availableLocales as $locale => $name)
        <button
            wire:click="switchLocale('{{ $locale }}')"
            type="button"
            class="px-3 py-1.5 text-sm font-medium rounded-lg transition-all duration-200
                {{ $currentLocale === $locale
                    ? 'bg-primary-600 text-white dark:bg-primary-500'
                    : 'bg-gray-100 text-gray-700 hover:bg-gray-200 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700'
                }}"
        >
            {{ $name }}
        </button>
    @endforeach
</div>
