<?php

namespace Tue\Printing\Mappers;

use Tue\Printing\Traits\ArraySetter;

class PolicyInsuredMapperPrint
{

    use ArraySetter;

    public static function insureds(array $insureds, $prefix = '')
    {
    	$flattenInsureds = [];
        foreach ($insureds as $key=>$insured) {
        	$flattenInsureds[$key] =self::insured($insured, $prefix);
        }
        return $flattenInsureds;
    }

    public static function insured($insured, $prefix = '' )
    {   
        $flattenInsured= [];
        
        !isset($insured->data) ?: $flattenInsured = array_merge(PolicyDataMapperPrint::policyData($insured->data, 'insured_'), $flattenInsured);
        !isset($insured->address) ?: $flattenInsured = array_merge(PolicyAddressMapperPrint::policyAddress($insured->address, 'insured_'), $flattenInsured);
        !isset($insured->options) ?: $flattenInsured['options'] = PolicyOptionsMapperPrint::options($insured->options, 'insured_');
        !isset($insured->addons) ?: $flattenInsured['addons'] = PolicyAddonsMapperPrint::addons($insured->addons, 'insured_');
        
		return $flattenInsured;
    }
}

