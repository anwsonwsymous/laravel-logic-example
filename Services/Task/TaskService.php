<?php

namespace App\Services\Task;

use App\Enums\TaskStatus;
use App\Enums\TaskType;
use App\Exceptions\AbstractServiceException;
use App\Exceptions\Task\TaskDayLimitReachedException;
use App\Exceptions\Task\TaskResultAlreadyHandledException;
use App\Exceptions\Task\TaskResultNotFoundException;
use App\Models\Account;
use App\Models\Task;
use App\Services\BalanceService;
use Illuminate\Support\Facades\Log;

/**
 * Class TaskService
 * @package App\Services\Task
 */
class TaskService
{
    const TASK_LIMIT_PER_DAY = 20;
    const ALLOWED_MIN_BALANCE = 0.001;
    const MINIMAL_PRICE = 0.00000001;

    /**
     * TaskService constructor.
     *
     * @param BalanceService $balanceService
     */
    public function __construct(private readonly BalanceService $balanceService)
    {
    }

    /**
     * Generate new task for account of type $type based on limits.
     *
     * @param Account $account
     * @param TaskType|null $type
     * @return Task
     * @throws TaskDayLimitReachedException
     */
    public function generate(Account $account, ?TaskType $type = null): Task
    {
        // Get random task if type not set
        if (is_null($type)) {
            $type = TaskType::random();
        }

        // Check latest task is completed
        $latestTask = Task::forAccount($account->id)->latest()->first();
        if ($latestTask && $latestTask->status === TaskStatus::NEW) {
            return $latestTask;
        }

        // Check daily limit reached
        if (Task::forAccount($account->id)->today()->count() >= self::TASK_LIMIT_PER_DAY) {
            throw new TaskDayLimitReachedException($account->toArray());
        }

        // Mark task as Free if account's balance is less than allowed min balance
        if ($account->balance < self::ALLOWED_MIN_BALANCE) {
            $isFree = true;
        }

        // Generate task data based on type
        $taskData = $type->toGenerator()->generate();

        /** @var Task $task */
        $task = Task::query()->create([
            'account_id' => $account->id,
            'type' => $type,
            'status' => TaskStatus::NEW,
            'data' => $taskData,
            'is_free' => $isFree ?? false
        ]);

        return $task;
    }

    /**
     * Handle task result and change its status based on answer
     *
     * @param Task $task
     * @return Task
     * @throws TaskResultNotFoundException
     * @throws TaskResultAlreadyHandledException
     */
    public function handleResult(Task $task): Task
    {
        if (!$task->result) {
            throw new TaskResultNotFoundException($task->toArray());
        }

        if ($task->status !== TaskStatus::NEW) {
            throw new TaskResultAlreadyHandledException($task->toArray());
        }

        // Check task result
        $result = $task->type->toHandler()->handle($task->data, $task->result->data);
        if ($result) {
            $task->status = TaskStatus::SUCCEEDED;
            $task->account_balance = $task->account->balance;
            $task->price = $task->is_free ?
                self::MINIMAL_PRICE :
                (float) number_format($task->account_balance * $task->type->percent() / 100, 8)
            ;
        } else {
            $task->status = TaskStatus::FAILED;
        }
        $task->save();

        return $task;
    }

    /**
     * @param Task $task
     * @return void
     */
    public function process(Task $task): void
    {
        if ($task->status !== TaskStatus::SUCCEEDED) {
            return;
        }

        try {
            $this->balanceService->processSucceededTask($task);
        } catch (AbstractServiceException $e) {
            Log::error($e->getMessage(), $e->context());

            // Balance Service Failed
            $task->update([
                'status' => TaskStatus::PAYMENT_FAILED
            ]);
        }
    }
}
