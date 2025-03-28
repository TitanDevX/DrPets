<?php

namespace App\Enums;
enum InvoiceStatus: int {

    case PENDING = 1;
    case CANCELLED = 2;
    case PAID = 3;
    public static function fromName($name)
    {
        return constant("self::$name");
    }

}