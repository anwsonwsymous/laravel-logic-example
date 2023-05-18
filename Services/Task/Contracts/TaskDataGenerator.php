<?php

namespace App\Services\Task\Contracts;

/**
 * Interface TaskDataGenerator
 * @package App\Services\Task\Contracts
 */
interface TaskDataGenerator
{
    /**
     * Generate task data
     *
     * @return array
     */
    public function generate(): array;
}
