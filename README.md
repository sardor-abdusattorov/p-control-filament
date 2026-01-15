# FilaStarter Kit

Стартовый набор для [Filament](https://github.com/filamentphp/filament) с преднастроенными пакетами и конфигами для быстрого старта TALL‑стека.

---

## 📦 Используемые технологии

- [Laravel 12](https://github.com/laravel/laravel)
- [Livewire 3](https://github.com/livewire/livewire)
- [Filament 3](https://github.com/filamentphp/filament)
- [Vite](https://vitejs.dev/)

---

## 🧩 Установленные пакеты

### Filament & TALL

- [`awcodes/filament-curator`](https://github.com/awcodes/filament-curator)
- [`aymanalhattami/filament-slim-scrollbar`](https://github.com/aymanalhattami/filament-slim-scrollbar)
- [`bezhansalleh/filament-shield`](https://github.com/bezhansalleh/filament-shield)
- [`cmsmaxinc/filament-system-versions`](https://github.com/cmsmaxinc/filament-system-versions)
- [`diogogpinto/filament-auth-ui-enhancer`](https://github.com/diogogpinto/filament-auth-ui-enhancer)
- [`hasnayeen/themes`](https://github.com/hasnayeen/filament-themes) (Sunset theme по умолчанию)
- [`joaopaulolndev/filament-edit-profile`](https://github.com/joaopaulolndev/filament-edit-profile)
- [`mohamedsabil83/filament-forms-tinyeditor`](https://github.com/mohamedsabil83/filament-forms-tinyeditor)
- [`njxqlus/filament-progressbar`](https://github.com/njxqlus/filament-progressbar)
- [`outerweb/filament-settings`](https://github.com/outerweb/filament-settings)
- [`outerweb/filament-translatable-fields`](https://github.com/outerweb/filament-translatable-fields)
- [`pboivin/filament-peek`](https://github.com/pboivin/filament-peek)
- [`sinnbeck/markdom`](https://github.com/sinnbeck/markdom)
- [`z3d0x/filament-logger`](https://github.com/z3d0x/filament-logger)

### Laravel & Dev

- [`barryvdh/laravel-ide-helper`](https://github.com/barryvdh/laravel-ide-helper)
- [`barryvdh/laravel-debugbar`](https://github.com/barryvdh/laravel-debugbar)
- [`laravel/sanctum`](https://github.com/laravel/sanctum)
- [`laravel/tinker`](https://github.com/laravel/tinker)
- [`mcamara/laravel-localization`](https://github.com/mcamara/laravel-localization)
- [`tightenco/duster`](https://github.com/tighten/duster)
- [`fakerphp/faker`](https://github.com/FakerPHP/Faker)
- [`laravel/pint`](https://github.com/laravel/pint)
- [`laravel/sail`](https://github.com/laravel/sail)
- [`mockery/mockery`](https://github.com/mockery/mockery)
- [`nunomaduro/collision`](https://github.com/nunomaduro/collision)

---

## 🚀 Быстрый старт

```sh
git clone https://github.com/ТВОЙ_РЕПОЗИТОРИЙ/fila-starter.git project
cd project

composer install
cp .env.example .env
php artisan key:generate
php artisan project:init
php artisan project:update
php artisan project:cache

npm install
npm run build
