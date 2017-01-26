<?php

namespace App\Http\Controllers\travel\v2;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\apiModels\travel\v2\Mappers\OptionDefinitionMapper;
use App\apiModels\travel\v2\Implementations\ErrorImpl;
use App\TravelOffer;
use App\apiModels\internal\v2 as internal;
use Symfony\Component\HttpFoundation\Response as Response;

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

        $offer = TravelOffer::find($OptionDefinitionRequest->getProductId());

        if ($offer) {
            return OptionDefinitionMapper::fromModels($offer->options);
        } else {
            $error = new ErrorImpl();
            $error->setDescription('Forbidden');
            
            return response([$error], Response::HTTP_FORBIDDEN);
        }
    }
}
