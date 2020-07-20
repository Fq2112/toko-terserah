<?php

namespace App\Providers;

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
        Schema::defaultStringLength(191);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        app()->setLocale('id');
        \Carbon\Carbon::setLocale('id');
        setlocale(LC_TIME, config('app.locale'));

        $this->app->bind('GlobalAuth', 'App\Support\GlobalAuth');
        $this->app->bind('NumberShorten', 'App\Support\NumberShorten');
        $this->app->bind('Rating', 'App\Support\Rating');
    }
}
