<?php

namespace App\Filament\Pages\Auth\PasswordReset;

use Filament\Pages\Auth\PasswordReset\RequestPasswordReset as BaseRequestPasswordReset;

class RequestPasswordReset extends BaseRequestPasswordReset
{
    protected static string $view = 'filament.pages.auth.password-reset.request-password-reset';
}
