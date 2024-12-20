<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

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

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function taskHistory(): HasMany
    {
        return $this->hasMany(TaskHistory::class, 'task_id');
    }
}
