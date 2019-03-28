<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\SluggableInterface;
use Cviebrock\EloquentSluggable\SluggableTrait;

class Group extends Model implements SluggableInterface
{
    use SluggableTrait;
    protected $sluggable = [
        'build_from' => 'name',
        'save_to' => 'slug',
    ];
    protected $table = 'groups';
    protected $fillable = [
        'name',
        'user_id',
        'owner'
    ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function users()
    {
        return $this->belongsToMany('App\User');
    }
    public function projects()
    {
        return $this->hasMany('App\Project');
    }
}
