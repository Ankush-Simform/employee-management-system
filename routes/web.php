<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\EmployeeController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return auth()->check() ? redirect()->route('dashboard') : view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard', [
        'departmentCount' => auth()->user()->departments()->count(),
        'employeeCount' => auth()->user()->employees()->count(),
    ]);
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/employees/data', [EmployeeController::class, 'data'])->name('employees.data');
    Route::resource('departments', DepartmentController::class);
    Route::resource('employees', EmployeeController::class);
});

require __DIR__.'/auth.php';
