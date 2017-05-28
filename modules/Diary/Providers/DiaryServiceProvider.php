<?php

namespace Diary\Providers;

use App\Entry;
use App\Journal;
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
        Route::model('entry', Entry::class);
        Route::model('journal', Journal::class);
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
             ->namespace('Diary\Api\Http\Controllers')
             ->group(base_path('modules/Diary/routes/api.php'));
    }
}
