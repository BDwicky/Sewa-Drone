<?php

namespace App\Providers;

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
        if (str_contains(database_path(), '[') || str_contains(database_path(), ']')) {
            $this->loadMigrationsFrom(strtr(database_path('migrations'), ['[' => '[[]', ']' => '[]]']));
        }
    }
}
