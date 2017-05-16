<?php
namespace App\Etrack\Entities\Notification;

use App\Etrack\Entities\Auth\User;
use Illuminate\Notifications\DatabaseNotification;

class Notification extends DatabaseNotification
{

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}