<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Lanz\Commentable\Commentable;
use Cviebrock\EloquentSluggable\SluggableInterface;
use Cviebrock\EloquentSluggable\SluggableTrait;
use Carbon\Carbon;
use Jenssegers\Date\Date;
class Task extends Model implements SluggableInterface
{
    use SluggableTrait;
    protected $sluggable = [
        'build_from' => 'title',
        'save_to' => 'slug',
    ];

    protected $table='tasks';
    protected $fillable = [
        'title',
        'description',
        'status',
        'start_date',
        'end_date',
        'project_id',
        'user_id'
    ];

    //para que retornen un objeto Carbon (dates)
    protected $dates = ['start_date', 'end_date'];

    public function setStartDateAttribute($date)
    {
        return $this->attributes['start_date'] = Carbon::createFromFormat('d/m/Y', $date)->format('Y-m-d H:i:s');
    }
    /*
    public function getStartDateAttribute($date)
    {
        return Carbon::createFromFormat('Y-m-d H:i:s', $date)->format('d/m/Y');
    }*/
    public function setEndDateAttribute($date)
    {
        return $this->attributes['end_date'] = Carbon::createFromFormat('d/m/Y', $date)->format('Y-m-d H:i:s');
    }
    /*
    public function getEndDateAttribute($date)
    {
        Date::setLocale('es');
        return Date::createFromTimestamp(strtotime($date))->diffForHumans();
        //return Carbon::createFromFormat('Y-m-d H:i:s', $date)->format('d/m/Y');
    }
    */

    public function project()
    {
        return $this->belongsTo(Project::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function files()
    {
        return $this->hasMany(File::class);
    }

    use Commentable;

}
