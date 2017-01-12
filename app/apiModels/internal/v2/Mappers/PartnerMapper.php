<?php

namespace App\apiModels\internal\v2\Mappers;

use App\apiModels\internal\v2\Model\Partner;

class PartnerMapper
{
    public static function fromObjects(array $partners)
    {
    	$mappedPartners = [];
        foreach ($partners as $partner) {
        	$mappedPartners[] = self::fromObject($partner);
        }
        return $mappedPartners;
    }

    public static function fromObject($partner, Solicitor $mappedPartner = null)
    {   
        if (!$mappedPartner) {
            $mappedPartner = new Partner();
        }
        
        !isset($partner->_id) ?: $mappedPartner->setId(strval($partner->_id));
        !isset($partner->code) ?: $mappedPartner->setCode(strval($partner->code));
        !isset($partner->name) ?: $mappedPartner->setName(strval($partner->name));

		return $mappedPartner;
    }
}
