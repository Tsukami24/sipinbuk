<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Schedule::command('reminder:borrow')->everyFifteenMinutes();
Schedule::command('fine:check')->hourly();
Schedule::command('report:generate')->daily();
Schedule::command('app:update-borrow-status')->daily();
