<?php

namespace App\apiModels\travel\v2\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\TravelOffer;
use App\apiModels\travel\v2\Mappers\QuoteMapper;

class QuoteController extends Controller
{
    public function index(Request $request)
    {
    	$quoteRequest = $request->attributes->get('deserializedRequestObject');

        $partnerCode = app('auth')->user()->code;
        $offers = TravelOffer::where('partner', $partnerCode)->get();

        $quotes = [];
        $quoteNumber = 0;

        foreach (QuoteMapper::fromModels($offers) as $quote) {
            $quote->setQuoteId(app('request')->attributes->get('requestId') . $quoteNumber++);
            $quote->setCalculateRequest($quoteRequest);
            $quote->setPromoCodeValid(false);
            $quote->recalculatePremiums();
            $quotes[] = $quote;
        }

        return $quotes;
    }
}
