<?php

namespace App\Exceptions\Task;

use App\Exceptions\AbstractServiceException;
use Throwable;

/**
 * Class TaskResultNotFoundException
 * @package App\Exceptions\Task
 */
class TaskResultNotFoundException extends AbstractServiceException
{
    public function __construct(
        array      $context = [],
        string     $message = "Result not found for this task.",
        int        $code = 0,
        ?Throwable $previous = null
    )
    {
        parent::__construct($context, $message, $code, $previous);
    }
}
