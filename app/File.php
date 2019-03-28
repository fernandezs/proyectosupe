<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
class File extends Model
{
    protected $table = 'files';
    protected $fillable = [
        'filename','mime','original_filename','task_id'
    ];

    public function task()
    {
        return $this->belongsTo(Task::class);
    }
}
