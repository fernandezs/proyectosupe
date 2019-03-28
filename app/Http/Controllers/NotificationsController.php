<?php
namespace App\Http\Controllers;
use Auth;
use Carbon\Carbon;
use App\Notifications\SendAppNotification\Notification;
use App\Notifications\SendAppNotification\Events\NotificationWasReaded;
use App\Notifications\SendAppNotification\Events\NotificationWasOpened;

/**
 * Class NotificationsController
 * @package Hechoenlaravel\JarvisFoundation\Http\Controllers
 */
class NotificationsController extends Controller
{
    
    /**
     * Lists notifications
     * @return $this
     */
    public function index()
    {
        $n = Notification::byUser(Auth::user())->orderBy('readed_at', 'asc')->get();
            return view('notifications.index')->with('notifications', [
                'count' => $n->count(),
                'notifications' => $n
            ]);
    }


    /**
     * Read a notification
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function read($id)
    {
        $notification = Notification::findOrFail($id);
        //$notification->readed_at= null;
        //$notification->save();
        if ($notification->user_id != Auth::user()->id) {
            abort(403);
        }
        if (empty($notification->readed_at)) {
            $notification->readed_at = Carbon::now();
            $notification->save();
            event(new NotificationWasReaded($notification));
        }
        event(new NotificationWasOpened($notification));
        if (!empty($notification->link)) {
            return redirect()->to($notification->link);
        }
        return redirect()->route('notifications');
    }
}