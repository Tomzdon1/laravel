<?php

namespace Tue\Printing\Mappers;

use Tue\Printing\Traits\ArraySetter;
use stdClass;

class PolicySumInsuredMapperPrint
{

    use ArraySetter;

    public static function sumInsured(stdClass $sumInsured)
    {
    	$flattenSumInsureds = [];

        self::set($flattenSumInsureds, 'value', $sumInsured->value);
        self::set($flattenSumInsureds, 'currency', $sumInsured->currency);

        return $flattenSumInsureds;
    }
}
