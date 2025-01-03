<?php

declare(strict_types=1);

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
        'start_time',
        'req_time'
    ];
}
