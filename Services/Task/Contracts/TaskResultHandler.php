<?php

namespace App\Services\Task\Contracts;

/**
 * Interface TaskResultHandler
 * @package App\Services\Task\Contracts
 */
interface TaskResultHandler
{
    /**
     * Check task result, success or fail
     *
     * @param array $taskData
     * @param array $resultData
     * @return bool
     */
    public function handle(array $taskData, array $resultData): bool;
}
