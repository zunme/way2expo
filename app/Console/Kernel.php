<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\DB;

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
        // $schedule->command('inspire')->hourly();
        $schedule->call(function () {
            $insertQuery = "
                INSERT INTO visit_uniq_ips
                select tmp.visitable_type, tmp.visitable_id, CURDATE() AS today , COUNT(1) AS cnt
                FROM (
                    SELECT a.visitable_type, a.visitable_id
                    FROM visits a
                    WHERE a.visitable_type IS NOT NULL 
                    AND a.created_at >= CURDATE()
                AND a.created_at < CURDATE() + INTERVAL 1 DAY
                ) tmp
                GROUP BY tmp.visitable_type, tmp.visitable_id
                ON DUPLICATE KEY UPDATE cnt =VALUES(cnt)
            ";
           DB::insert($insertQuery);
        })->everyMinute();
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
