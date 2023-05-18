<?php

namespace App\Services\Task\TaskResultHandlers;

use App\Services\Task\Contracts\TaskResultHandler;

/**
 * Class BasicImageClassificationHandler
 * @package App\Services\Task\TaskResultHandlers
 */
abstract class BasicImageClassificationHandler implements TaskResultHandler
{
    public function handle(array $taskData, array $resultData): bool
    {
        return $taskData['label'] === ($resultData['label'] ?? null);
    }
}
