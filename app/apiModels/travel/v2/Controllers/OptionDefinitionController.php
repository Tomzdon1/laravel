<?php

namespace App\apiModels\travel\v2\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\apiModels\travel\v2\Mappers\OptionDefinitionMapper;
use App\TravelOffer;
use Tue\Sending;
use App\apiModels\internal\v2 as internal;

class OptionDefinitionController extends Controller
{
	/**
     * Option definitions index for passed product_id
     * 
     * @return OPTIONDEFINITION[]
     */
    public function index(Request $request)
    {
        $quoteRequest = $request->attributes->get('deserializedRequestObject');

        $partnerCode = app('auth')->user()->code;
        $offer = TravelOffer::find($quoteRequest->getProductId())->where('partner', $partnerCode)->first();

        if ($offer) {
            return OptionDefinitionMapper::fromModels($offer->options);
        }
    }
}
