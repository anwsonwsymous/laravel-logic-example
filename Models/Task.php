<?php

namespace App\Models;

use App\Enums\TaskStatus;
use App\Enums\TaskType;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * Class Task
 * @property TaskStatus $status
 * @property TaskType $type
 * @property Account $account
 * @property TaskResult|null $result
 * @property float $account_balance
 * @property float $price
 * @property boolean $is_free
 * @method static Task|Builder forAccount(int $accountId)
 * @method static Task|Builder today()
 * @method static Task|Builder succeeded()
 * @package App\Models
 */
class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'account_id',
        'status',
        'type',
        'data',
        'account_balance',
        'price',
        'is_free',
    ];

    protected $casts = [
        'data' => 'json',
        'status' => TaskStatus::class,
        'type' => TaskType::class,
    ];

    public function account(): BelongsTo
    {
        return $this->belongsTo(Account::class);
    }

    public function result(): HasOne
    {
        return $this->hasOne(TaskResult::class);
    }

    public function scopeSucceeded(Builder $query): Builder
    {
        return $query->where('status', TaskStatus::SUCCEEDED);
    }

    public function scopeForAccount(Builder $query, int $accountId): Builder
    {
        return $query->where('account_id', $accountId);
    }

    public function scopeToday(Builder $query): Builder
    {
        return $query->whereDate('created_at', '=', Carbon::today());
    }
}
