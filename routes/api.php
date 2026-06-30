<?php

use App\Http\Controllers\Api\MeetingApiController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->name('api.')->group(function () {
    Route::get('/meetings', [MeetingApiController::class, 'meetings'])->name('meetings');
    Route::get('/meeting-requests', [MeetingApiController::class, 'meetingRequests'])->name('meeting-requests');
    Route::post('/meeting-requests', [MeetingApiController::class, 'storeMeetingRequest'])->name('meeting-requests.store');
    Route::put('/meeting-requests/{meetingRequest}', [MeetingApiController::class, 'updateMeetingRequest'])->name('meeting-requests.update');
});
