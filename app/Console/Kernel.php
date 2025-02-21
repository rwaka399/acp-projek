<?php

namespace App\Console;

use App\Models\Task;
use App\Notifications\DueTaskNotification;
use App\Services\TaskService;
use Carbon\Carbon;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    // protected function schedule(Schedule $schedule): void
    // {
    //     // $schedule->command('inspire')->hourly();
    // }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }


    protected function schedule(Schedule $schedule)
    {
        $schedule->call(function () {
            $now = Carbon::now();

            // Get tasks due in the next 1 hour
            $tasksInOneHour = Task::where('due_date', '>', $now)
                                  ->where('due_date', '<=', $now->addHour())
                                  ->get();

            // Get tasks due in the next 2 hours
            $tasksInTwoHours = Task::where('due_date', '>', $now)
                                   ->where('due_date', '<=', $now->addHours(5))
                                   ->get();

            // Get tasks due in the next 1 day
            $tasksInOneDay = Task::where('due_date', '>', $now)
                                 ->where('due_date', '<=', $now->addDay())
                                 ->get();

            // Send notifications for tasks within each timeframe
            foreach ($tasksInOneHour as $task) {
                $task->user->notify(new DueTaskNotification($task)); // Send notification for tasks in 1 hour
            }

            foreach ($tasksInTwoHours as $task) {
                $task->user->notify(new DueTaskNotification($task)); // Send notification for tasks in 2 hours
            }

            foreach ($tasksInOneDay as $task) {
                $task->user->notify(new DueTaskNotification($task)); // Send notification for tasks in 1 day
            }

        })->everyMinute();  // This will run the task every minute
    }

}
