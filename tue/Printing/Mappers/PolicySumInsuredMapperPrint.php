<?php

namespace Tue\Printing\Mappers;

use Tue\Printing\Traits\ArraySetter;
use stdClass;

class PolicySumInsuredMapperPrint
{

    use ArraySetter;

    public static function sumInsured(stdClass $sumInsured, $prefix = '')
    {
    	$flattenSumInsureds = [];

        self::set($flattenSumInsureds, $prefix.'value', $sumInsured->value);
        self::set($flattenSumInsureds, $prefix.'currency', $sumInsured->currency);

        return $flattenSumInsureds;
    }
}
