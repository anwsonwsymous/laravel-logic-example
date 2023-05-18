<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class TaskResult
 * @property Task $task
 * @package App\Models
 */
class TaskResult extends Model
{
    protected $fillable = [
        'task_id',
        'data',
    ];

    protected $casts = [
        'data' => 'json'
    ];

    public function task(): BelongsTo
    {
        return $this->belongsTo(Task::class);
    }
}
