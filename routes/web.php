<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EmailLogController;
use App\Http\Controllers\HistoryController;
use App\Http\Controllers\PayrollController;
use App\Http\Controllers\PayrollImportController;
use App\Http\Controllers\PayrollPreviewController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return auth()->check() ? redirect('/dashboard') : redirect('/login');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::prefix('payroll')->name('payroll.')->group(function () {
        Route::get('/upload', [PayrollImportController::class, 'create'])->name('upload');
        Route::post('/upload', [PayrollImportController::class, 'store'])->name('store');
        Route::delete('/{import}', [PayrollImportController::class, 'destroy'])->name('destroy');
        Route::get('/{import}/preview', [PayrollPreviewController::class, 'index'])->name('preview');
        Route::post('/{import}/generate', [PayrollController::class, 'generate'])->name('generate');
        Route::get('/{import}', [PayrollController::class, 'show'])->name('show');
        Route::get('/detail/{detail}/download', [PayrollController::class, 'downloadPdf'])->name('download-pdf');

        Route::get('/{import}/progress-json', [PayrollController::class, 'progressJson'])->name('progress-json');
        Route::get('/{import}/email-logs', [EmailLogController::class, 'index'])->name('email-logs');
        Route::post('/email-logs/{detail}/retry', [EmailLogController::class, 'retry'])->name('email-retry');
        Route::post('/{import}/retry-all', [EmailLogController::class, 'retryAll'])->name('email-retry-all');
    });

    Route::prefix('history')->name('history.')->group(function () {
        Route::get('/', [HistoryController::class, 'index'])->name('index');
        Route::get('/{import}', [HistoryController::class, 'show'])->name('show');
    });
});

require __DIR__.'/auth.php';
