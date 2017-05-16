<?php

namespace App\Notifications\Client\Activities;

use App\Etrack\Entities\Activity\ActivityScheduleExecution;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class ScheduleApproved extends Notification
{
    use Queueable;

    /**
     * @var ActivityScheduleExecution
     */
    private $scheduleExecution;

    /**
     * Create a new notification instance.
     *
     * @param ActivityScheduleExecution $scheduleExecution
     */
    public function __construct(ActivityScheduleExecution $scheduleExecution)
    {
        //
        $this->scheduleExecution = $scheduleExecution;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->line('The introduction to the notification.')
                    ->action('Notification Action', url('/'))
                    ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
