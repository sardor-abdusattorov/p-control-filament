<?php

namespace App\Filament\Pages\Auth;

use Carbon\Carbon;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Pages\Auth\EditProfile as BaseEditProfile;
use Filament\Support\Enums\Alignment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Jenssegers\Agent\Agent;

class EditProfile extends BaseEditProfile
{
    public static function getSessions(): array
    {
        if (config('session.driver') !== 'database') {
            return [];
        }

        return collect(
            DB::connection(config('session.connection'))->table(config('session.table', 'sessions'))
                ->where('user_id', Auth::user()->getAuthIdentifier())
                ->latest('last_activity')
                ->get()
        )->map(function ($session): object {
            $agent = self::createAgent($session);

            return (object) [
                'device' => [
                    'browser' => $agent->browser(),
                    'desktop' => $agent->isDesktop(),
                    'mobile' => $agent->isMobile(),
                    'tablet' => $agent->isTablet(),
                    'platform' => $agent->platform(),
                ],
                'ip_address' => $session->ip_address,
                'is_current_device' => $session->id === request()->session()->getId(),
                'last_active' => Carbon::createFromTimestamp($session->last_activity)->diffForHumans(),
            ];
        })->toArray();
    }

    public static function logoutOtherBrowserSessions($password): void
    {
        if (! Hash::check($password, Auth::user()->password)) {
            Notification::make()
                ->danger()
                ->title('Неверный пароль')
                ->send();

            return;
        }

        Auth::guard()->logoutOtherDevices($password);

        request()->session()->put([
            'password_hash_' . Auth::getDefaultDriver() => Auth::user()->getAuthPassword(),
        ]);

        self::deleteOtherSessionRecords();

        Notification::make()
            ->success()
            ->title('Вы вышли из всех других сессий в браузерах.')
            ->send();
    }

    protected static function createAgent(mixed $session)
    {
        return tap(
            new Agent,
            fn ($agent) => $agent->setUserAgent($session->user_agent)
        );
    }

    protected static function deleteOtherSessionRecords()
    {
        if (config('session.driver') !== 'database') {
            return;
        }

        DB::connection(config('session.connection'))->table(config('session.table', 'sessions'))
            ->where('user_id', Auth::user()->getAuthIdentifier())
            ->where('id', '!=', request()->session()->getId())
            ->delete();
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Grid::make('')
                    ->schema([
                        Forms\Components\FileUpload::make('avatar_url')
                            ->label('Аватар')
                            ->directory('avatars')
                            ->disk('public')
                            ->image()
                            ->panelAspectRatio('5:4')
                            ->panelLayout('integrated')
                            ->inlineLabel(false)
                            ->optimize('webp'),
                    ])
                    ->columnSpan(2)
                    ->columns(1),
                Forms\Components\Fieldset::make('Данные пользователя')
                    ->schema([
                        $this->getNameFormComponent()
                            ->label('Имя')
                            ->inlineLabel(false)
                            ->columnSpan(2),
                        $this->getEmailFormComponent()
                            ->label('Почта')
                            ->inlineLabel(false)
                            ->columnSpan(2),
                        Forms\Components\TextInput::make('Current password')
                            ->label('Текущий пароль')
                            ->password()
                            ->required()
                            ->currentPassword()
                            ->revealable()
                            ->inlineLabel(false)
                            ->columnSpan(2),
                        $this->getPasswordFormComponent()
                            ->label('Новый пароль')
                            ->inlineLabel(false),
                        $this->getPasswordConfirmationFormComponent()
                            ->label('Подтверждение пароля')
                            ->inlineLabel(false)
                            ->visible(true),
                    ])
                    ->columnSpan(4)
                    ->columns(2),
                Forms\Components\Section::make('Сессии в браузерах')
                    ->description('Управляйте своими активными сессиями и выходите из других браузеров и устройств.')
                    ->schema([
                        Forms\Components\ViewField::make('browserSessions')
                            ->hiddenLabel()
                            ->view('filament-edit-profile::forms.components.browser-sessions')
                            ->viewData(['data' => self::getSessions()])
                            ->columnSpan(1),
                        Forms\Components\Actions::make([
                            Forms\Components\Actions\Action::make('deleteBrowserSessions')
                                ->label('Выйти из других сессий')
                                ->requiresConfirmation()
                                ->modalHeading('Выйти из других сессий')
                                ->modalDescription('Введите свой пароль для подтверждения выхода из других сессий в браузерах.')
                                ->modalSubmitActionLabel('Выйти')
                                ->form([
                                    Forms\Components\TextInput::make('password')
                                        ->password()
                                        ->revealable()
                                        ->label('Пароль')
                                        ->required(),
                                ])
                                ->action(function (array $data) {
                                    self::logoutOtherBrowserSessions($data['password']);
                                })
                                ->modalWidth('2xl'),
                        ]),
                    ]),
            ])->columns(6);
    }

    public function getFormActionsAlignment(): string|Alignment
    {
        return Alignment::End;
    }
}
