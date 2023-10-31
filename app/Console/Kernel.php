<?php

namespace App\Console;

use App\Ldap\Scopes\Utilisateurs;
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
        $schedule->call(new ImportOrgsFromOracle())->everyFourHours();
        $schedule->command('ldap:import users',[
            '--chunk' => 500,
            '--attributes' => "company,mail,name,samaccountname"
        ])->everyFourHours();
        $schedule->call(new ImportUsersFromOracle())->everyFourHours();
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
