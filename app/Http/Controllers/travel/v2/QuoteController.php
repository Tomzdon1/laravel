<?php

namespace App\Http\Controllers\travel\v2;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\TravelOffer;
use App\apiModels\travel\v2\Mappers;

class QuoteController extends Controller
{
    public function index(Request $request)
    {
    	$quoteRequest = $request->attributes->get('deserializedRequestObject');

        $partnerCode = app('auth')->user()->code;
        
        $offersQuery = TravelOffer::where('partner', $partnerCode);

        if (is_array($quoteRequest->getData()->getOptions())) {
            $optionsToFind = [];
            
            foreach ($quoteRequest->getData()->getOptions() as $option) {
                $optionsToFind[] = ['$elemMatch' => ["code" => $option->getCode()]];
            }

            $offersQuery = $offersQuery->where('options', 'all', $optionsToFind);
        }

        $offers = $offersQuery->get();

        $quotes = [];
        $quoteNumber = 0;

        foreach (Mappers\QuoteMapper::fromOfferModels($offers) as $quote) {
            $quote->setCalculateRequest($quoteRequest);
            $quote->setPromoCodeValid(false);
            $quote->recalculatePremiums();
            
            $quoteModel = Mappers\QuoteModelMapper::fromQuote($quote, $quoteRequest);
            $quoteModel->save();
            
            $quote->setQuoteId($quoteModel->id);
            $quotes[] = $quote;           
        }

        return $quotes;
    }
}
