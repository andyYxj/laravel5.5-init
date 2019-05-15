<?php

namespace App\Console;

use App\Console\Commands\Task\Admin\Demo\TaskThree;
use App\Console\Commands\Task\Admin\Demo\TaskTwo;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Console\Commands\Task\Admin\Demo\TaskOne;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        TaskOne::class,
        TaskTwo::class,
        TaskThree::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        //admim模块下的demo测试任务
        $schedule->command('task_admin_demo_taskone')->everyMinute()->withoutOverlapping();//admim模块下的demo测试任务1
        $schedule->command('task_admin_demo_tasktwo')->everyMinute()->withoutOverlapping();//admim模块下的demo测试任务2
        $schedule->command('task_admin_demo_taskthree')->everyFiveMinutes()->withoutOverlapping();//admim模块下的demo测试任务3

        //xx模块xx任务

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
