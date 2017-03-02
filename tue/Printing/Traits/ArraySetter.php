<?php

namespace Tue\Printing\Traits;

use Carbon\Carbon;
use MongoDB\BSON\UTCDateTime;
trait ArraySetter {

    protected static function set(array &$array , $key , &$value) {

        if ($value instanceof UTCDateTime) {
             $array[$key] = Carbon::instance($value->toDateTime())->toRfc3339String();
        } else { 
            $array[$key] = isset($value) ? strval($value) : 'null';
        }
    }
}