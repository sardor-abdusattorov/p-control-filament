<?php

namespace App\Livewire;

use Filament\Support\Facades\FilamentView;
use Livewire\Component;

class ThemeSwitcher extends Component
{
    public string $theme = 'light';

    public function mount(): void
    {
        $this->theme = session('theme', 'light');
    }

    public function toggleTheme(): void
    {
        $this->theme = $this->theme === 'light' ? 'dark' : 'light';
        session(['theme' => $this->theme]);

        $this->dispatch('theme-changed', theme: $this->theme);

        // Reload to apply theme changes
        $this->redirect(request()->header('Referer'));
    }

    public function render()
    {
        return view('livewire.theme-switcher');
    }
}
