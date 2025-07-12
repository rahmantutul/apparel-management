<?php

use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return view('auth.login');
});

Auth::routes(['register' => false]);
Auth::routes();



Route::middleware(['auth'])->group(function () {
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::get('/users/{id}/edit', [UserController::class, 'edit'])->name('users.edit');
    Route::put('/users/{id}', [UserController::class, 'update'])->name('users.update');
    Route::delete('/users/delete/{id}', [UserController::class, 'destroy'])->name('users.destroy');
    Route::post('/users/store', [UserController::class, 'store'])->name('users.store');
    Route::get('/profile/edit', [UserController::class, 'profile_edit'])->name('profile.edit');
    Route::post('/profile/edit/{id}', [UserController::class, 'update'])->name('profile.update');
    // Roles
    Route::resource('roles', RoleController::class);
});



