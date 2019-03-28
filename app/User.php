<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username', 'email','role', 'password','image',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function getAvatarImageUrl()
    {
        return $this->image;
    }
    public function groups()
    {
        return $this->hasMany('App\Group');
    }

    public function projects()
    {
        return $this->hasManyThrough('App\Project','App\Group');
    }

    public function tasks()
    {
        return $this->hasMany('App\Task');
    }


    public function isAdmin()
    {
        return $this->role == 'admin';
    }
    public function isDirector()
    {
        return $this->role == 'director';
    }
    public function isInvestigator()
    {
        return $this->role == 'investigador';
    }
    public function isScholar()
    {
        return $this->role == 'becario';
    }
    

}
