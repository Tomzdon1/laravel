<?php

namespace App\Http\Controllers\travel\v2;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\apiModels\travel\v2\Mappers\OptionDefinitionMapper;
use App\TravelOffer;
use App\apiModels\internal\v2 as internal;

class OptionDefinitionController extends Controller
{
	/**
     * Option definitions index for passed product_id
     * 
     * @return OptionDefinition[]
     */
    public function index(Request $request)
    {
        $OptionDefinitionRequest = $request->attributes->get('deserializedRequestObject');

        $partnerCode = app('auth')->user()->code;
        $offer = TravelOffer::find($OptionDefinitionRequest->getProductId())->where('partner', $partnerCode)->first();

        if ($offer) {
            return OptionDefinitionMapper::fromModels($offer->options);
        }
    }
}
