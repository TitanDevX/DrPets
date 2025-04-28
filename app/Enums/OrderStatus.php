<?php

namespace App\Enums;
enum OrderStatus: int {

    case UN_PAID = 0;
    case IN_PREPARATION = 1;
    case IN_DELIVERY = 2;
    case DELIVERED = 3;
    public static function fromName($name)
    {
        return constant("self::$name");
    }

}