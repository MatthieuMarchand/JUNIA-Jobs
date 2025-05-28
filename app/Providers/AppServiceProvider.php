<?php

namespace App\Providers;

use App\Enums\UserRole;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use function config;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        Carbon::setLocale(config('app.locale'));
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        ResetPassword::createUrlUsing(function (User $user, string $token) {
            return route('password-reset.create', ['token' => $token]);
        });

        Gate::define('view-admin-dashboard', function (User $user) {
            return $user->role === UserRole::Administrator;
        });
    }
}
