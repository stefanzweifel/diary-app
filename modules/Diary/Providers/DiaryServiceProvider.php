<?php

namespace Diary\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class DiaryServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        Route::prefix('api')
             ->middleware('api')
             ->namespace('App\Http\Controllers')
             ->group(base_path('modules/Diary/routes/api.php'));
    }
}
