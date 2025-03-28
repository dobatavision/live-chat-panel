<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Middleware\Authenticate;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ManageController;
use App\Http\Controllers\MessageController;

Route::get('/', function () {
    if (Auth::check()) {
        return redirect()->route('manage');
    }
    return view('home');
})->name('home');

Route::get('/login', function () {
    return redirect()->route('home');
    //
})->name('login');

Route::get('/register', function () {
    return redirect()->route('home');
    //
})->name('register');


Route::post('/login', [UserController::class, 'login']);
Route::post('/register', [UserController::class, 'register']);

Route::post('/logout', [UserController::class, 'logout'])->name('logout');

Route::get('/manage', [ManageController::class, 'index'])->name('manage')->middleware('auth');

Route::post('/user/{user}/send', [MessageController::class, 'sendMessage']);

Route::post('/manage/update', [ManageController::class, 'update'])->name('updateUsers')->middleware( ['auth','role:admin']);
