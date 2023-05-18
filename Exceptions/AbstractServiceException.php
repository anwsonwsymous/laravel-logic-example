<?php

namespace App\Exceptions;

use Exception;
use Throwable;

/**
 * Class AbstractServiceException
 * @package App\Exceptions
 */
abstract class AbstractServiceException extends Exception
{
    protected array $context = [];

    /**
     * @param string $message
     * @param array $context
     * @param int $code
     * @param Throwable|null $previous
     */
    public function __construct(
        array      $context = [],
        string     $message = "",
        int        $code = 0,
        ?Throwable $previous = null
    )
    {
        $this->context = $context;

        parent::__construct($message, $code, $previous);
    }

    /**
     * @return array
     */
    public function context(): array
    {
        return $this->context;
    }
}
