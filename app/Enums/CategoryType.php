<?php
namespace App\Enums;
enum CategoryType: int
{
    case PRODUCT = 1;
    case SERVICE = 2;

    public static function fromName($name)
    {
        return constant("self::$name");
    }
}