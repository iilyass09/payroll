<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DivisionController;
use App\Http\Controllers\EmailLogController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\HistoryController;
use App\Http\Controllers\ManualBookController;
use App\Http\Controllers\PayrollController;
use App\Http\Controllers\PayrollImportController;
use App\Http\Controllers\PayrollPreviewController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StrukturOrganisasiController;
use App\Livewire\AbsensiTable;
use App\Livewire\CutiIzinTable;
use App\Livewire\KontrakKerjaTable;
use App\Livewire\UserTable;
use App\Http\Controllers\ExportController;
use App\Http\Controllers\MeetingController;
use App\Http\Controllers\BonusController;
use App\Http\Controllers\PromotionController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return auth()->check() ? redirect('/dashboard') : redirect('/login');
});

Route::middleware(['auth'])->group(function () {
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

        Route::post('/employees/{employee}/promotions', [PromotionController::class, 'store'])->name('employees.store-promotion');
        Route::delete('/employees/{employee}/promotions/{promotion}', [PromotionController::class, 'destroy'])->name('employees.destroy-promotion');
        Route::get('/employees/{employee}/promotions/{promotion}/download', [PromotionController::class, 'downloadPdf'])->name('employees.download-promotion-pdf');

        Route::get('/divisions', [DivisionController::class, 'index'])->name('divisions.index');
        Route::get('/struktur-organisasi', [StrukturOrganisasiController::class, 'index'])->name('struktur-organisasi');
        Route::get('/absensi', AbsensiTable::class)->name('absensi');
        Route::get('/cuti-izin', CutiIzinTable::class)->name('cuti-izin');
        Route::get('/kontrak-kerja', KontrakKerjaTable::class)->name('kontrak-kerja');
        Route::get('/manual-book', [ManualBookController::class, 'index'])->name('manual-book');

        Route::prefix('export')->name('export.')->group(function () {
            Route::get('/employees', [ExportController::class, 'employees'])->name('employees');
            Route::get('/divisions', [ExportController::class, 'divisions'])->name('divisions');
            Route::get('/kontrak-kerja', [ExportController::class, 'kontrakKerja'])->name('kontrak-kerja');
        });
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

    Route::prefix('meeting')->name('meeting.')->group(function () {
        Route::get('/jadwal', [MeetingController::class, 'jadwal'])->name('jadwal');
        Route::get('/permintaan', [MeetingController::class, 'permintaan'])->name('permintaan');
        Route::post('/permintaan', [MeetingController::class, 'storePermintaan'])->name('permintaan.store');
        Route::put('/permintaan/{meetingRequest}/setujui', [MeetingController::class, 'setujui'])->name('permintaan.setujui');
        Route::put('/permintaan/{meetingRequest}/tolak', [MeetingController::class, 'tolak'])->name('permintaan.tolak');
    });

    Route::prefix('bonus')->name('bonus.')->group(function () {
        Route::get('/', [BonusController::class, 'index'])->name('index');
    });

    Route::get('/kelola-akun', UserTable::class)->name('kelola-akun');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::get('/profile/pin', [ProfileController::class, 'pin'])->name('profile.pin');
    Route::post('/profile/pin', [ProfileController::class, 'updatePin'])->name('profile.pin.update');

});

require __DIR__.'/auth.php';
