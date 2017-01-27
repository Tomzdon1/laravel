<?php

namespace Tue\Printing\Mappers;

use Tue\Printing\Traits\ArraySetter;
use stdClass;

class PolicyHolderMapperPrint
{

    use ArraySetter;

    public static function policyHolder(stdClass $policyHolder, $prefix = '')
    {
        $flattenPolicyHolder = [];

        !isset($policyHolder->data) ?:$flattenPolicyHolder = array_merge(PolicyDataMapperPrint::policyData($policyHolder->data, 'policy_holder_'), $flattenPolicyHolder);
        !isset($policyHolder->address) ?:$flattenPolicyHolder = array_merge(PolicyAddressMapperPrint::policyAddress($policyHolder->address, 'policy_holder_'), $flattenPolicyHolder);
        self::set($flattenPolicyHolder, $prefix . 'email', $policyHolder->email);
        self::set($flattenPolicyHolder, $prefix . 'telephone', $policyHolder->telephone);
        !isset($policyHolder->agreements) ?:$flattenPolicyHolder = array_merge(PolicyAgreementsMapperPrint::agreements($policyHolder->agreements, 'policy_holder_'), $flattenPolicyHolder);
        !isset($policyHolder->options) ?: $flattenPolicyHolder = array_merge(PolicyOptionsMapperPrint::options($policyHolder->options, 'policy_holder_'), $flattenPolicyHolder);
        !isset($policyHolder->addons) ?: $flattenPolicyHolder = array_merge(PolicyAddonsMapperPrint::addons( $policyHolder->addons, 'policy_holder_'), $flattenPolicyHolder);

        return $flattenPolicyHolder;
    }
}
