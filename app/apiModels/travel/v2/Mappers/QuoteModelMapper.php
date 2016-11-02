<?php

namespace App\apiModels\travel\v2\Mappers;

use App\apiModels\travel\v2\Implementations;
use App\Quote;

class QuoteModelMapper
{    
    public static function fromQuote(Implementations\QuoteImpl $quote, Implementations\QuotesRequestImpl $quotesRequest)
    {
		$quoteModel = new Quote();
        $quoteModel->data = $quotesRequest->getData();
        $quoteModel->prepersons = $quotesRequest->getPrepersons();
        $quoteModel->quote_id = $quote->getQuoteId();
        $quoteModel->product_id = $quote->getProductId();
        $quoteModel->premium = $quote->getPremium();
        $quoteModel->tariff_premium = $quote->getTariffPremium();
        !$quote->getPromoCodeValid() ?: $quoteModel->promo_code_valid = $quote->getPromoCodeValid();
        $quoteModel->description = $quote->getDescription();
        $quoteModel->details = $quote->getDetails();
		return $quoteModel;
    }
}
