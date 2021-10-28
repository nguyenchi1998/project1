<?php

namespace App\Console;

use App\Console\Commands\StartSchedule;
use Carbon\Carbon;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        StartSchedule::class
    ];

    /**
     * Define the application's command schedule.
     *
     * @param Schedule $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('class_credit:start')
            ->daily();
        $schedule->command('credit:open')
            ->daily()
            ->when(function () {
                return $this->compareDate(config('default.credit.open_register')[0])
                    || $this->compareDate(config('default.credit.open_register')[1]);
            });
    }

    private function compareDate($date)
    {
        return Carbon::createFromFormat('d/m/y', Carbon::createFromFormat('d/m', $date)->format('d/m/y'))
            ->eq(Carbon::createFromFormat('d/m/y', Carbon::now()->format('d/m/y')));
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
