<?php

namespace App\Enums;
enum BookingStatus: int {

    case PENDING = 0;
    case ACCEPTED = 1;
    case REJECTED = 2;
    case COMPLETED = 3;

    case CANCELLED = -1;
    public static function fromName($name)
    {
        return constant("self::$name");
    }

}