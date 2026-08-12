<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Resource-specific policies will be added as Department and Employee
        // models are introduced in the following implementation steps.
        Gate::define('manage-departments', fn ($user): bool => $user !== null);
        Gate::define('manage-employees', fn ($user): bool => $user !== null);
    }
}
