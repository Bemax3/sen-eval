<?php

namespace App\Console;

use App\Models\User;
use App\Oracle\ImportOrgsFromOracle;
use App\Oracle\ImportUsersFromOracle;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;


class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
         $schedule->call(new ImportOrgsFromOracle())->everyMinute();
         $schedule->call(new ImportUsersFromOracle())->everyMinute();
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
