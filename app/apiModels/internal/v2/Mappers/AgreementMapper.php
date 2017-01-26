<?php

namespace App\apiModels\internal\v2\Mappers;

use App\apiModels\internal\v2\Model\Agreement;

class AgreementMapper
{
    public static function fromObjects(array $agreements)
    {
    	$mappedAgreements = [];
        foreach ($agreements as $agreement) {
        	$mappedAgreements[] = self::fromObject($agreement);
        }
        return $mappedAgreements;
    }

    public static function fromObject($agreement, Agreement $mappedAgreement = null)
    {   
        if (!$mappedAgreement) {
            $mappedAgreement = new Agreement();
        }
        
        !isset($agreement->description) ?: $mappedAgreement->setDescription(strval($agreement->description));
        !isset($agreement->value) ?: $mappedAgreement->setValue(boolval($agreement->value));
        !isset($agreement->code) ?: $mappedAgreement->setCode(strval($agreement->code));

		return $mappedAgreement;
    }
}
