<?php

namespace App\apiModels\travel\v2\Mappers;

use App\apiModels\travel\v2\Implementations\QuoteImpl;
use App\TravelOffer;
use App\apiModels\travel\v2\Mappers\DetailMapper;

class QuoteMapper
{

    public static function fromOfferModels($offers)
    {
        $qoutes = [];
        foreach ($offers as $offer) {
            $qoutes[] = self::fromOfferModel($offer);
        }
        return $qoutes;
    }

    public static function fromOfferModel(TravelOffer $offer)
    {
        $quote = new QuoteImpl();
        $quote->setOffer($offer);
        $quote->setProductId($offer->id);
        !isset($offer->name) ? : $quote->setDescription($offer->name);
        !isset($offer->details)
            ? $quote->setDetails([])
            : $quote->setDetails(DetailMapper::fromModels($offer->details));
        return $quote;
    }
}
