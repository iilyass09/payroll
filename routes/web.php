<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DivisionController;
use App\Http\Controllers\EmailLogController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\HistoryController;
use App\Http\Controllers\PayrollController;
use App\Http\Controllers\PayrollImportController;
use App\Http\Controllers\PayrollPreviewController;

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return auth()->check() ? redirect('/dashboard') : redirect('/login');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::prefix('hris')->name('hris.')->group(function () {
        Route::resource('employees', EmployeeController::class);
        Route::post('/employees/{employee}/photo', [EmployeeController::class, 'uploadPhoto'])->name('employees.upload-photo');
        Route::post('/employees/{employee}/documents', [EmployeeController::class, 'storeDocument'])->name('employees.store-document');
        Route::get('/employees/{employee}/documents/{document}/download', [EmployeeController::class, 'downloadDocument'])->name('employees.download-document');
        Route::delete('/employees/{employee}/documents/{document}', [EmployeeController::class, 'destroyDocument'])->name('employees.destroy-document');

        Route::post('/employees/{employee}/contracts', [EmployeeController::class, 'storeContract'])->name('employees.store-contract');
        Route::get('/employees/{employee}/contracts/{contract}', [EmployeeController::class, 'getContract'])->name('employees.get-contract');
        Route::delete('/employees/{employee}/contracts/{contract}', [EmployeeController::class, 'destroyContract'])->name('employees.destroy-contract');
        Route::put('/employees/{employee}/contracts/{contract}', [EmployeeController::class, 'updateContract'])->name('employees.update-contract');

        Route::post('/employees/{employee}/position-histories', [EmployeeController::class, 'storePositionHistory'])->name('employees.store-position-history');
        Route::delete('/employees/{employee}/position-histories/{positionHistory}', [EmployeeController::class, 'destroyPositionHistory'])->name('employees.destroy-position-history');

        Route::get('/divisions', [DivisionController::class, 'index'])->name('divisions.index');
    });

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

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
