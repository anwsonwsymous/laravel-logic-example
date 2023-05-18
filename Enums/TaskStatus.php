<?php

namespace App\Enums;

/**
 * Enum TaskStatus
 * @package App\Enums
 */
enum TaskStatus: int
{
    case NEW = 1;
    case SUCCEEDED = 2;
    case FAILED = 3;
    case PAID = 4; // Paid after task succeeded
    case PAYMENT_FAILED = 5; // Failed while trying to process payment
}
