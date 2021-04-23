<?php

namespace App\Console;

use App\Mail\DailySummary;
use App\Quote;
use DateTime;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Mail;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->call(function() {
            // created >= this time yesterday to catch any quotes added late in the day after yesterday's report
            $recentQuotes = Quote::where('created_at', '>=', new DateTime('-1 day'))->get();
            if ($recentQuotes->count() == 0) {
                // don't send an email if there's nothing to report
                return;
            }

            $mailable = new DailySummary($recentQuotes);
            Mail::to(Config::get('mail.dailyReportTo'))->send($mailable);
        })->dailyAt('18:00');
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
