<?php

namespace App\apiModels\travel\v2\Mappers;

use App\apiModels\travel\v2\Implementations\DetailImpl;

class DetailMapper
{
    public static function fromModels(array $detailsArray)
    {
    	$details = [];
        foreach ($detailsArray as $detailArray) {
        	$details[] = self::fromModel($detailArray);
        }
        return $details;
    }

    public static function fromModel(array $detailArray)
    {
		$detail = new DetailImpl();
        !array_key_exists('name', $detailArray) ?: $detail->setName($detailArray['name']);
        !array_key_exists('value', $detailArray) ?: $detail->setValue($detailArray['value']);
		return $detail;
    }
}
