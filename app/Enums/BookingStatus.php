<?php

namespace App\Enums;
enum BookingStatus: int {

    case UNSET = 0;
    case ACCEPTED = 1;
    case REJECTED = 2;
    case COMPLETED = 3;
    public static function fromName($name)
    {
        return constant("self::$name");
    }

}