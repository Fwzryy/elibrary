<?php

namespace App\Filament\Pages;

use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Pages\Auth\Login as BaseAuthLogin;
use Illuminate\Validation\ValidationException;
use Filament\Facades\Filament;
use Filament\Http\Responses\Auth\Contracts\LoginResponse;

use Filament\Forms\Components\Actions;
use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Components\Actions\Action\Size as ActionSize;



class LoginPage extends BaseAuthLogin
{
    // ...

    public function authenticate(): ?LoginResponse
    {
        $data = $this->form->getState();

        $loginField = filter_var($data['login'], FILTER_VALIDATE_EMAIL) ? 'email' : 'name';

        $credentials = [
            $loginField => $data['login'],
            'password' => $data['password'],
        ];

        if (! Filament::auth()->attempt($credentials, $data['remember'] ?? false)) {
            throw ValidationException::withMessages([
                  'data.login' => ('Data Kredensial anda tidak cocok. Silakan coba lagi'),
            ]);
        }

        return app(LoginResponse::class);
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('login')
                    ->label('Email atau Username') // Label manual
                    ->placeholder('Masukkan Email atau Username 📧')
                    ->required()
                    ->autocomplete('username')
                    ->autofocus()
                    ->extraInputAttributes(['tabindex' => '1']),
                TextInput::make('password')
                    ->label('Password') 
                    ->placeholder('Masukkan Password 🔑')
                    ->password()
                    ->autocomplete('current-password')
                    ->extraInputAttributes(['tabindex' => '2']),
                Actions::make([
                    Action::make('forgot_password')
                        ->label('Reset Password?')
                        ->link()
                        ->url(route('filament.admin.auth.password-reset.request')) 
                        ->extraAttributes(['tabindex' => '3'])
                        ->color('primary'),
                ])->alignStart(),
                
                Checkbox::make('remember')
                    ->label('Remember me'), 
            ])
            ->statePath('data');
    }
}