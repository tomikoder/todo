<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TaskHistory extends Model
{
    protected $table = 'tasks_history';
    protected $fillable = [
        'name',
        'priority',
        'deadline',
        'description',
        'status',
        'task_id'
    ];
}
