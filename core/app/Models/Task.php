<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Task extends Model
{
    protected $fillable = [
        'name',
        'priority',
        'description',
        'status',
        'send_notify',
        'start_time',
        'req_time'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function history(): HasMany
    {
        return $this->hasMany(TaskHistory::class);
    }

    public function taskHistory(): HasMany
    {
        return $this->hasMany(TaskHistory::class, 'task_id');
    }
}
