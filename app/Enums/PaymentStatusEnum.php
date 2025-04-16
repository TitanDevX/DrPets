<?php

namespace App\Enums;

enum PaymentStatusEnum: int
{
    case PENDING = 1;
    case PROGRESS = 2;
    case CANCELED = 3;
    case PAID = 4;
    case FAILED = 5;

    public static function fromName($name)
    {
        return constant("self::$name");
    }
}
