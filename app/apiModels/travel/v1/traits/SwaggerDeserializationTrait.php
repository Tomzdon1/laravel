<?php

namespace App\apiModels\travel\v1\Traits;

trait SwaggerDeserializationTrait {
    public static function swaggerTypes()
    {
        return self::$swaggerTypes;
    }

    public static function attributeMap()
    {
        return self::$attributeMap;
    }

    public static function setters()
    {
        return self::$setters;
    }

    public static function getters()
    {
        return self::$getters;
    }
}