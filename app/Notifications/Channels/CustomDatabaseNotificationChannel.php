<?php
namespace App\Notifications\Channels;


use Illuminate\Notifications\Notification;

class CustomDatabaseNotificationChannel
{
    /**
     * @param $notifiable
     * @param Notification $notification
     * @return mixed
     */
    public function send($notifiable, Notification $notification)
    {
        $data = $notification->toArray($notifiable);

        return $notifiable->routeNotificationFor('database')->create([
            'id'         => $notification->id,
            'created_by' => $data['created_by'],

            'type'    => get_class($notification),
            'data'    => $data,
            'read_at' => null,
        ]);
    }
}