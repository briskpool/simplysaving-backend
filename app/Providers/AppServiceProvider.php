<?php

namespace App\Providers;

use Illuminate\Auth\Events\Lockout;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);
        ResetPassword::toMailUsing(function ($user, string $token) {
            $user_name = $user->first_name;
            $url = url('password/reset/' . $token . '?email=' . $user->email);
            return (new MailMessage)->view(
                'auth.forget_password_email',
                [
                    'url' => $url,
                    'name' => $user_name
                ]
            );
        });
    }
}
