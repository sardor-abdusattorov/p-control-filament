<x-filament-panels::page.simple>
    {{-- Language and Theme Switchers --}}
    <div class="mb-6 space-y-4">
        <div class="flex items-center justify-center gap-4">
            @livewire('language-switcher')
        </div>
        <div class="flex items-center justify-center">
            @livewire('theme-switcher')
        </div>
    </div>

    {{-- Password Reset Request Form --}}
    <x-filament-panels::form wire:submit="request">
        {{ $this->form }}

        <x-filament-panels::form.actions
            :actions="$this->getCachedFormActions()"
            :full-width="$this->hasFullWidthFormActions()"
        />
    </x-filament-panels::form>
</x-filament-panels::page.simple>
