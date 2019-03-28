<?php

namespace App\Notifications\SendAppNotification;

use Illuminate\Database\Eloquent\Model;
use Jenssegers\Date\Date;
/**
 * Class Notification
 * @package Hechoenlaravel\JarvisFoundation\Notifications\SendAppNotification
 */
class Notification extends Model
{
    /**
     * @var string
     */
    protected $table = "notifications";

    /**
     * @var array
     */
    protected $fillable = ['user_id', 'type', 'message', 'link', 'readed_at'];

    /**
     * @var array
     */
    protected $dates = ['created_at', 'updated_at', 'readed_at'];

    protected $types = [
        'success' => 'check',
        'info' => 'info',
        'danger' => 'times',
        'warning' => 'warning',
    ];

    /**
     * Filter by User
     * @param $query
     * @param $user
     * @return mixed
     */
    public function scopeByUser($query, $user)
    {
        return $query->where('user_id', $user->id);
    }

    /**
     * Filter the Unread Ones
     * @param $query
     */
    public function scopeUnread($query)
    {
        $query->where('readed_at');
    }

    /**
     * @return mixed
     */
    public function getTimeAgo()
    {
        Date::setLocale('es');
        return Date::createFromTimestamp(strtotime($this->created_at))->diffForHumans();
    }

    /**
     * @return string
     */
    public function getLink()
    {
        return route('notifications.read', ['id' => $this->id]);
    }

    /**
     * @return string
     */
    public function getIconByType()
    {
        if (!isset($this->types[$this->type])) {
            return null;
        }
        return $this->types[$this->type];
    }
}
