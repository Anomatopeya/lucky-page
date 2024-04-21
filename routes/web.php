<?php

use App\Http\Controllers\GameController;
use App\Http\Controllers\RegistrationController;
use App\Http\Middleware\CheckAccessLink;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('registration.register');
})->name('homepage');

Route::post('/register', RegistrationController::class)->name('registration.store');

Route::middleware([CheckAccessLink::class])->group(function () {
    Route::get('/lucky-page/{token}', [GameController::class, 'getPage'])->name('lucky-page');
    Route::post('/lucky-page/{token}/generate-new-link', [GameController::class, 'generateNewLink'])->name('lucky-page.generate-new-link');
    Route::post('/lucky-page/{token}/deactivate-link', [GameController::class, 'deactivateLink'])->name('lucky-page.deactivate-link');
    Route::get('/lucky-page/{token}/play-game', [GameController::class, 'playGame'])->name('lucky-page.play-game');
    Route::get('/lucky-page/{token}/history', [GameController::class, 'history'])->name('lucky-page.history');
});

