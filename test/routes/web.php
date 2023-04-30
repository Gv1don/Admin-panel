<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\VisitController;
use App\Http\Controllers\UserController;

Route::get('/home', [VisitController::class, 'index'])->name('home');

Route::get('/login', [VisitController::class, 'saveVisit'])->name('login')->middleware('check.referrer');

Route::post('/login', [LoginController::class, 'login']);

Route::get('/registration', function(){
    return view('registration');
})->name('registration');

Route::post('/registration', [RegistrationController::class, 'registration']);

Route::post('/logout', function(){
    Auth::logout();
    return redirect()->route('login');
})->name('logout');

Route::get('/data', [UserController::class, 'index'])->middleware('auth')->name('data');

Route::post('/data/filter', [UserController::class, 'filtration'])->middleware('auth')->name('filter');