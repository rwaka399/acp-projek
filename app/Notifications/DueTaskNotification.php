<?php

namespace App\Notifications;

use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class DueTaskNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */

    protected $task;

    public function __construct($task)
    {
        $this->task = $task;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toDatabase(object $notifiable): array
    {
        $remaining = Carbon::parse($this->task->due_date)->diffForHumans();   
        
        return [
            'task_id' => $this->task->task_id,
            'task_name' => $this->task->task_name,
            'due_date' => $this->task->due_date,
            'remaining' => $remaining,
            'message' => "Task '{$this->task->task_name}' akan berakhir dalam waktu dekat",
        ];
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
