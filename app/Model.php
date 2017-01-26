<?php

namespace App;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;
use Carbon\Carbon;

class Model extends Eloquent
{
    
    /**
     * Get associative array as object.
     *
     * @param  string  $key
     * @return mixed
     */
    public function getAttributeValue($key)
    {
        $value = parent::getAttributeValue($key);

        // If value is or has associative array then it will be convert to object
        // In another case won't be converted
        if (is_array($value)) {
            return self::associativeArraysToObject($value);
        }

        return $value;
    }

    /**
     * Convert associative array to object.
     *
     * @param  array  $array
     * @return array
     */
    static function associativeArraysToObject($array)
    {
        foreach ($array as $key => &$value) {
            if (is_array($value)) {
                $value = self::associativeArraysToObject($value);
            }
        }

        if (is_array($array) && self::is_assoc($array)) {
            $array = (object) $array;
        }

        return $array;
    }

    /**
     * Check if array is associative.
     *
     * @param  array  $array
     * @return bool
     */
    static function is_assoc(array $array) {
        return count(array_filter(array_keys($array), 'is_string')) > 0;
    }

    /**
     * Save the model to the database.
     *
     * Added serialize Carbon objects to strings.
     *
     * @param  array  $options
     * @return bool
     */
    public function save(array $options = [])
    {
        $this->serializeCarbon($this->attributes);
        return parent::save($options);
        
    }
    
    /**
     * Serialize Carbon dates to string.
     *
     * @param  array  $attributes
     * @return array
     */
    protected function serializeCarbon(&$attributes)
    {
        foreach ($attributes as $key => &$value) {
            if ($value instanceof Carbon) {
                $value = $this->fromDateTime($value);
            } elseif (is_array($value) || is_object($value)) {
                $this->serializeCarbon($value);
            }
        }
    }
}