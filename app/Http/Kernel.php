<?php

namespace App\Console;

use Cron\MinutesField;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Models\Auction;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        $schedule->call(function() {
            Auction::where('end_date', '<', now())  // if it is now closed
                   ->where('status', '!=','Ended')      // but it is not closed yet
                   ->update(['status' => 'Ended']); // update auction state
        })->everyMinute();

        $schedule->call(function(){
            Auction::where('start_date', '<', now())    // if it is now open
                   ->where('status', '!=','Active')      // but it is not opened yet
                   ->update(['status' => 'Active']); // update auction state
        })->everyMinute();

        $schedule->call(function(){
            Auction::where('end_date', '<', now()->addMinutes(15))    // if it is now open
                   ->where('status', '!=','Ending')      // but it is not opened yet
                   ->update(['status' => 'Ending']); // update auction state
        })->everyMinute();
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
