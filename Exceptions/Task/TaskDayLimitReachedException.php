<?php

namespace App\Exceptions\Task;

use App\Exceptions\AbstractServiceException;
use Throwable;

/**
 * Class TaskDayLimitReachedException
 * @package App\Exceptions\Task
 */
class TaskDayLimitReachedException extends AbstractServiceException
{
    public function __construct(
        array      $context = [],
        string     $message = "Account's per day task limit has bean reached.",
        int        $code = 0,
        ?Throwable $previous = null
    )
    {
        parent::__construct($context, $message, $code, $previous);
    }
}
