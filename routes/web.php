<?php

use App\Http\Controllers\RegistrationController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('registration.register');
});

Route::post('/register', RegistrationController::class)->name('registration.store');
Route::get('/lucky-page/{token}')->name('lucky-page');
