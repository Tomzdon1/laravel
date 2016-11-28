<?php

namespace App\apiModels\travel\v2\Mappers;

use App\Calculation;
use App\apiModels\travel\v2\Implementations;

class CalculationMapper
{

    public static function fromCalculationPolicy(
        Implementations\CalculationPolicyImpl $calculationPolicy,
        Implementations\CalculatePolicyRequestImpl $calculatePolicyRequest
    ) {
        $calculation = new Calculation();
        !$calculatePolicyRequest->getQuoteId() ? : $calculation->quote_id = $calculatePolicyRequest->getQuoteId();
        !$calculatePolicyRequest->getProductId() ? : $calculation->product_id = $calculatePolicyRequest->getProductId();
        $calculation->data = $calculatePolicyRequest->getData();
        $calculation->policy_holder = $calculatePolicyRequest->getPolicyHolder();
        $calculation->insured = $calculatePolicyRequest->getInsured();
        $calculation->premium = $calculationPolicy->getPremium();
        $calculation->tariff_premium = $calculationPolicy->getTariffPremium();
        $calculation->due_date = $calculationPolicy->getDueDate();
        !$calculationPolicy->getPromoCodeValid()
            ?
            : $calculation->promo_code_valid = $calculationPolicy->getPromoCodeValid();
        return $calculation;
    }
}
