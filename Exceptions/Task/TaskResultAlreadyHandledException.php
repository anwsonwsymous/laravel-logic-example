<?php

namespace App\Exceptions\Task;

use App\Exceptions\AbstractServiceException;
use Throwable;

/**
 * Class TaskResultAlreadyHandledException
 * @package App\Exceptions\Task
 */
class TaskResultAlreadyHandledException extends AbstractServiceException
{
    public function __construct(
        array      $context = [],
        string     $message = "Task Result already has been handled/processed.",
        int        $code = 0,
        ?Throwable $previous = null
    )
    {
        parent::__construct($context, $message, $code, $previous);
    }
}
