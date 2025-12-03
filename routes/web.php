<?php

use App\Http\Controllers\InstructorController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SchoolClassController;
use App\Http\Controllers\WorkshopReportController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/classes', [SchoolClassController::class, 'index'])->name('classes.index');

    Route::get('/reports', [WorkshopReportController::class, 'index'])->name('reports.index');
    Route::get('/reports/{report}', [WorkshopReportController::class, 'show'])->name('reports.show');

    Route::get('/instructors', [InstructorController::class, 'index'])->name('instructors.index');
    Route::get('/instructors/new', [InstructorController::class, 'create'])->name('instructors.create');
    Route::post('/instructors/store', [InstructorController::class, 'store'])->name('instructors.store');
    Route::post('/instructors/update', [InstructorController::class, 'update'])->name('instructors.update');
    Route::get('/instructors/{instructor}', [InstructorController::class, 'show'])->name('instructors.show');
    Route::get('/instructors/{instructor}/edit', [InstructorController::class, 'edit'])->name('instructors.edit');
});

require __DIR__.'/auth.php';
