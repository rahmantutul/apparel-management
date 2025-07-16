<?php

use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\DesignationController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ShiftController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return view('auth.login');
});

Auth::routes(['register' => false]);
Auth::routes();



Route::middleware(['auth'])->group(function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home');
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::get('/users/{id}/edit', [UserController::class, 'edit'])->name('users.edit');
    Route::put('/users/{id}', [UserController::class, 'update'])->name('users.update');
    Route::delete('/users/delete/{id}', [UserController::class, 'destroy'])->name('users.destroy');
    Route::post('/users/store', [UserController::class, 'store'])->name('users.store');
    Route::get('/profile/edit', [UserController::class, 'profile_edit'])->name('profile.edit');
    Route::put('/profile/update/{id}', [UserController::class, 'update'])->name('profile.update');
    // Roles
    Route::resource('roles', RoleController::class);


    // Department
    Route::resource('departments', DepartmentController::class);

    // Designation
    Route::resource('designations', DesignationController::class);

    // Shifts
    Route::resource('employee-shifts', ShiftController::class);

    // Employee
    Route::get('/employees/create', [EmployeeController::class, 'create'])->name('employees.create');
    Route::post('/employees', [EmployeeController::class, 'store'])->name('employees.store');
    Route::get('/employees/{employee}/edit', [EmployeeController::class, 'edit'])->name('employees.edit');
    Route::put('/employees/{employee}', [EmployeeController::class, 'update'])->name('employees.update');
    
});



