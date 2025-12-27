<?php

namespace App\Providers;
use Carbon\Carbon;
use Illuminate\Support\Facades\Schema;
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
    public function boot()
    {
        // Tambahkan 3 baris ini untuk memaksa WIB & Bahasa Indonesia
        config(['app.locale' => 'id']);
        Carbon::setLocale('id');
        date_default_timezone_set('Asia/Jakarta');
        
        // Settingan default string (opsional, bawaan laravel biasanya ada)
        Schema::defaultStringLength(191);
    }
}
