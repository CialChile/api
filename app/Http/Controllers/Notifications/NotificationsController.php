<?php

namespace App\Http\Controllers\Notifications;

use App\Etrack\Transformers\Notifications\NotificationTransformer;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;

class NotificationsController extends Controller
{
    public function index(Request $request)
    {
        $user = $this->loggedInUser();
        $notifications = $user->notifications()->with('createdBy')
            ->latest()->simplePaginate(10);
        return $this->response->collection(collect($notifications->items()), new NotificationTransformer())->addMeta('hasMorePages', $notifications->hasMorePages());;
    }

    public function latest()
    {
        $user = $this->loggedInUser();
        $notifications = $user->notifications()->with('createdBy')
            ->latest()->take(5)->get();
        $unreadCount = $user->unreadNotifications()->count();

        return $this->response->collection($notifications, new NotificationTransformer())->addMeta('unreadCount', $unreadCount);
    }

    public function read($id)
    {
        $user = $this->loggedInUser();
        if ($id == 'all') {
            $user->unreadNotifications()->update(['read_at' => Carbon::now()]);
        } else {
            $user->unreadNotifications()->find($id)->markAsRead();
        }

        return $this->latest();

    }
}
