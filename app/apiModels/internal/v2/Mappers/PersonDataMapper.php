<?php

namespace App\apiModels\internal\v2\Mappers;

use App\apiModels\internal\v2\Model\PersonData;
use Carbon\Carbon;

class PersonDataMapper
{
    public static function fromObjects(array $personDatas)
    {
    	$mappedPersonDatas = [];
        foreach ($personDatas as $personData) {
        	$mappedPersonDatas[] = self::fromObject($personData);
        }
        return $mappedPersonDatas;
    }

    public static function fromObject($personData, PersonData $mappedPersonData = null)
    {   
        if (!$mappedPersonData) {
            $mappedPersonData = new PersonData();
        }
        
        !isset($personData->first_name) ?: $mappedPersonData->setFirstName(strval($personData->first_name));
        !isset($personData->last_name) ?: $mappedPersonData->setLastName(strval($personData->last_name));
        !isset($personData->birth_date) ?: $mappedPersonData->setBirthDate(Carbon::instance($personData->birth_date->toDateTime())->toRfc3339String());
        !isset($personData->pesel) ?: $mappedPersonData->setPesel(strval($personData->pesel));
        !isset($personData->nationality) ?: $mappedPersonData->setNationality(strval($personData->nationality));
        !isset($personData->document_no) ?: $mappedPersonData->setDocumentNo(strval($personData->document_no));
        !isset($personData->business_name) ?: $mappedPersonData->setBusinessName(strval($personData->business_name));
        !isset($personData->short_business_name) ?: $mappedPersonData->setShortBusinessName(strval($personData->short_business_name));
        !isset($personData->nip) ?: $mappedPersonData->setNip(strval($personData->nip));
        !isset($personData->type) ?: $mappedPersonData->setType(strval($personData->type));

		return $mappedPersonData;
    }
}
