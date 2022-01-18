<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\SoapClass;

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
       // $this->app->bind('SoapClass',SoapClass::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
