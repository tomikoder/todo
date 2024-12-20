<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $fillable = [
        'user_id',
        'name',
        'priority',
        'deadline',
        'description',
        'status',
        'send_notify'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    public function taskHistory()
    {
        return $this->hasMany(TaskHistory::class, 'task_id');
    }
}
