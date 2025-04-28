<?php

namespace App\Enums;
enum InvoiceTypeEnum: int {

    case ORDER = 1;
    case BOOKING = 2;

    public static function fromName($name)
    {
        return constant("self::$name");
    }

}