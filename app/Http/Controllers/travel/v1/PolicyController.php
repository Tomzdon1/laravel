<?php

namespace App\Http\Controllers\travel\v1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Policy;
use Symfony\Component\HttpFoundation\Response as Response;

class PolicyController extends Controller
{

    public function import(Request $request)
    {
        $importStatuses = [];
        $importRequests = $request->attributes->get('deserializedRequestObject');

        foreach ($importRequests as $importRequest) {
            $importStatuses[] = $importRequest->import();
        }

        return $importStatuses;
    }
}
