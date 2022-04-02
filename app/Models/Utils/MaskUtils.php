<?php

namespace App\Models\Utils;

class MaskUtils
{
    public static function decimalToSql($value){
        return str_replace(',', '.', str_replace(".", "", $value));
    }
}
