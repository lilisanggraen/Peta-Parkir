<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL; // 1. Tambahkan baris ini

class AppServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        // 2. Tambahkan logika ini
        if (config('app.env') === 'production') {
            URL::forceScheme('https');
        }
    }
}
