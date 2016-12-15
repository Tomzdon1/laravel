<?php

namespace App\Http\Controllers\travel\v1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\TravelOffer;
use App\Policy;
use App\apiModels\travel\v1\implementations\ERRORImpl;
use Symfony\Component\HttpFoundation\Response as Response;

class PolicyController extends Controller
{

    public function import(Request $request)
    {
        $importStatuses = [];
        $importRequests = $request->attributes->get('deserializedRequestObject');

        foreach ($importRequests as $importRequest) {
            $offer = TravelOffer::find($importRequest->getProductRef());

            if (!$offer) {
                $error = new ERRORImpl();
                $error->setDescription('Forbidden');
                return response([$error], Response::HTTP_FORBIDDEN);
            }
        }

        foreach ($importRequests as $importRequest) {
            $importStatuses[] = $importRequest->import();
        }

        return $importStatuses;
    }
}
