<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Schedule::command('queue:work --queue=default --tries=1 --timeout=0 --stop-when-empty')
    ->everyMinute()
    ->withoutOverlapping()
    ->sendOutputTo(storage_path('logs/queue-default.log'));

Schedule::command('queue:work --queue=email --tries=3 --timeout=300 --stop-when-empty')
    ->everyMinute()
    ->withoutOverlapping()
    ->sendOutputTo(storage_path('logs/queue-email.log'));
