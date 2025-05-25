<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RegslikController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PdfReaderController;

Route::get('/', function () {
    return view('auth.login');
});

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::match(['GET', 'POST'], '/pdf-reader', [PdfReaderController::class, 'index'])->name('pdf-reader.index');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    
    Route::resource('users', UserController::class);

    Route::resource('regsliks', RegslikController::class);
    Route::get('regslik-export', [RegslikController::class, 'export'])->name('regslik-export');

    Route::resource('reports', ReportController::class);
    Route::get('report-export', [ReportController::class, 'export'])->name('report-export');

    
    
});

require __DIR__.'/auth.php';
