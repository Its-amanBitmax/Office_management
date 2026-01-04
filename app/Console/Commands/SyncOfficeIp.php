<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\AttendanceController;

class SyncOfficeIp extends Command
{
    protected $signature = 'sync:office-ip';
    protected $description = 'Sync Office IP daily';

    public function handle()
    {
        $controller = new AttendanceController();
        $controller->syncOfficeIp();

        $this->info('Office IP synced successfully.');
    }
}
