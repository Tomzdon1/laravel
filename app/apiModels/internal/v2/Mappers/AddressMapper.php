<?php

namespace App\apiModels\internal\v2\Mappers;

use App\apiModels\internal\v2\Model\Address;

class AddressMapper
{
    public static function fromObjects(array $Addresses)
    {
    	$mappedAddresss = [];
        foreach ($Addresses as $address) {
        	$mappedAddresss[] = self::fromObject($address);
        }
        return $mappedAddresss;
    }

    public static function fromObject($address, Address $mappedAddress = null)
    {   
        if (!$mappedAddress) {
            $mappedAddress = new Address();
        }
        
        !isset($address->country) ?: $mappedAddress->setCountry(strval($address->country));
        !isset($address->post_code) ?: $mappedAddress->setPostCode(strval($address->post_code));
        !isset($address->city) ?: $mappedAddress->setCity(strval($address->city));
        !isset($address->street) ?: $mappedAddress->setStreet(strval($address->street));
        !isset($address->house_no) ?: $mappedAddress->setHouseNo(strval($address->house_no));
        !isset($address->flat_no) ?: $mappedAddress->setFlatNo(strval($address->flat_no));

		return $mappedAddress;
    }
}
