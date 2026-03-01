<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LanguageController;

/*
|--------------------------------------------------------------------------
| Language Routes
|--------------------------------------------------------------------------
|
| Routes for handling language switching
|
*/

Route::prefix('lang')->group(function () {
    Route::get('/{locale}', [LanguageController::class, 'switch'])
        ->where('locale', 'ar|en')
        ->name('language.switch');
});
