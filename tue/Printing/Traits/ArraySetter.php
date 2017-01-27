<?php

namespace Tue\Printing\Traits;

trait ArraySetter {

    protected static function set(array &$array , $key , &$value) {
        $array[$key] = isset($value) ? strval($value) : 'null';
    }
}