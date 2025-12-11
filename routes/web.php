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
    Route::prefix('profile')->group(function () {
        Route::get('/', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/', [ProfileController::class, 'destroy'])->name('profile.destroy');
        Route::patch('/avatar', [ProfileController::class, 'updateAvatar'])->name('profile.updateAvatar');
    });
    
    Route::get('/reports', [WorkshopReportController::class, 'index'])->name('reports.index');
    Route::get('/reports/{report}', [WorkshopReportController::class, 'show'])->name('reports.show');
    
    Route::prefix('classes')->group(function () {
        Route::get('/', [SchoolClassController::class, 'index'])->name('classes.index');
        Route::get('/new', [SchoolClassController::class, 'create'])->name('classes.create');
        
        Route::middleware('role:admin,manager')->group(function () {
            Route::post('/store', [SchoolClassController::class, 'store'])->name('classes.store');
            Route::get('/trashed', [SchoolClassController::class, 'trashed'])->name('classes.trashed');
            Route::patch('/{class}/restore', [SchoolClassController::class, 'restore'])->name('classes.restore')->withTrashed();
            Route::get('/{class}/edit', [SchoolClassController::class, 'edit'])->name('classes.edit');
            Route::put('/{class}', [SchoolClassController::class, 'update'])->name('classes.update');
            Route::delete('/{class}', [SchoolClassController::class, 'destroy'])->name('classes.destroy');
            
        });
        Route::get('/{class}', [SchoolClassController::class, 'show'])->name('classes.show');
    });
    
    Route::middleware('role:admin,manager')->group(function () {
        Route::prefix('instructors')->group(function () {
            Route::get('/', [InstructorController::class, 'index'])->name('instructors.index');
            Route::get('/new', [InstructorController::class, 'create'])->name('instructors.create');
            Route::post('/store', [InstructorController::class, 'store'])->name('instructors.store');
            Route::get('/trashed', [InstructorController::class, 'trashed'])->name('instructors.trashed');
            
            Route::get('/{instructor}', [InstructorController::class, 'show'])->name('instructors.show');
            Route::get('/{instructor}/edit', [InstructorController::class, 'edit'])->name('instructors.edit');
            Route::put('/{instructor}', [InstructorController::class, 'update'])->name('instructors.update');
            Route::delete('/{instructor}', [InstructorController::class, 'destroy'])->name('instructors.destroy');
            Route::patch('/{instructor}/restore', [InstructorController::class, 'restore'])->name('instructors.restore')->withTrashed();
        });
    });
});

require __DIR__.'/auth.php';
