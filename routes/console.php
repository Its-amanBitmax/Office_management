<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;
use App\Models\Attendance;
use Carbon\Carbon;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();

Artisan::command('attendance:auto-mark-out', function () {
    $timezone = config('attendance.timezone', 'Asia/Kolkata');
    $targetDate = Carbon::today($timezone)->format('Y-m-d');
    $markOutTime = config('attendance.auto_mark_out_time');

    $now = Carbon::now($timezone);
    $targetDateTime = Carbon::createFromFormat(
        'Y-m-d H:i:s',
        $targetDate . ' ' . $markOutTime,
        $timezone
    );

    if ($now->lt($targetDateTime)) {
        $this->info('Auto mark out skipped: configured time not reached yet.');
        return;
    }

    $updatedCount = Attendance::where('date', $targetDate)
        ->whereNotNull('mark_in')
        ->whereNull('mark_out')
        ->update([
            'mark_out' => $markOutTime,
            'marked_time' => $markOutTime,
            'marked_by_type' => 'Admin',
        ]);

    $this->info("Auto mark out completed. Updated rows: {$updatedCount}");
})->purpose('Auto mark out pending attendance after configured time.');

Schedule::command('attendance:auto-mark-out')
    ->everyFiveSeconds()
    ->timezone(config('attendance.timezone', 'Asia/Kolkata'))
    ->withoutOverlapping();
