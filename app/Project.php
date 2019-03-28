<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\SluggableInterface;
use Cviebrock\EloquentSluggable\SluggableTrait;

class Project extends Model implements SluggableInterface
{
    use SluggableTrait;
    protected $sluggable = [
        'build_from' => 'title',
        'save_to' => 'slug',
    ];
    protected $table = 'projects';
    protected $fillable = [
        'title',
        'description',
        'keyword',
        'user_id',
        'group_id'
    ];
    public function user()
    {
        return $this->belongsTo('App\User');
    }
    public function group()
    {
        return $this->belongsTo('App\Group');
    }
    public function users()
    {
        return $this->belongsToMany('App\User');
    }
    public function groups()
    {
        return $this->belongsToMany('App\Group');
    }

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }

}
