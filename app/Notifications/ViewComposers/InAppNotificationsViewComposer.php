<?php

namespace App\Notifications\ViewComposers;

use Auth;
use App\Notifications\SendAppNotification\Notification;
use Illuminate\Contracts\View\View;

class InAppNotificationsViewComposer
{
    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
        if (!Auth::guest()) {
            $n = Notification::byUser(Auth::user())->unread()->get();
            $view->with('notifications', [
                'count' => $n->count(),
                'notifications' => $n
            ]);
        }
    }
}
