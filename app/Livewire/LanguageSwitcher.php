<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Session;
use Livewire\Component;

class LanguageSwitcher extends Component
{
    public string $currentLocale;

    public array $availableLocales = [
        'en' => 'English',
        'ru' => 'Русский',
        'uz' => 'O\'zbek',
    ];

    public function mount(): void
    {
        $this->currentLocale = app()->getLocale();
    }

    public function switchLocale(string $locale): void
    {
        if (array_key_exists($locale, $this->availableLocales)) {
            Session::put('locale', $locale);
            app()->setLocale($locale);
            $this->currentLocale = $locale;

            $this->dispatch('locale-switched', locale: $locale);

            // Reload the page to apply language changes
            $this->redirect(request()->header('Referer'));
        }
    }

    public function render()
    {
        return view('livewire.language-switcher');
    }
}
