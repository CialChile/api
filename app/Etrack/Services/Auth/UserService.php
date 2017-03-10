<?php
namespace App\Etrack\Services\Auth;

use App\Etrack\Entities\Auth\User;
use App\Mail\UserRegistered;
use Mail;

class UserService
{
    public function generateRandomPassword()
    {
        return str_random(8);
    }

    public function sendUserWasRegisteredMail(User $user, string $randomPassword)
    {
        return Mail::to($user->email)->send(new UserRegistered($user, $randomPassword));
    }
}