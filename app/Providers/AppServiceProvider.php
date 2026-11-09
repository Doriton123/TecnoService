<?php

namespace App\Providers;

use App\Models\Solicitud;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        Route::model('solicitud', Solicitud::class);
        // Registrar la carpeta de traducciones de TecnoService
        app('translation.loader')->addPath(lang_path());
    }
}
