<?php

namespace App\apiModels\travel\v2\Mappers;

use App\apiModels\travel\v2\Implementations\QUOTE_impl;
use App\TravelOffer;
use App\apiModels\travel\v2\Mappers\DetailMapper;

class QuoteMapper
{
    public static function fromModels($offers)
    {
    	$qoutes = [];
        foreach ($offers as $offer) {
        	$qoutes[] = self::fromModel($offer);
        }
        return $qoutes;
    }

    public static function fromModel(TravelOffer $offer)
    {
		$quote = new QUOTE_impl();
        $quote->setOffer($offer);
        $quote->setProductId($offer->id);
        !isset($offer->name) ?: $quote->setDescription($offer->name);
		!isset($offer->details) ? $quote->setDetails([]) : $quote->setDetails(DetailMapper::fromModels($offer->details));
		return $quote;
    }
}
