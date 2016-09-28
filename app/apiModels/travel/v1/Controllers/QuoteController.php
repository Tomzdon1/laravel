<?php

namespace App\apiModels\travel\v1\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Symfony\Component\HttpFoundation\Response as Response;

class QuoteController extends Controller
{
    public function get(Request $request)
    {
    	// deprecated API
        return Response::HTTP_GONE;

        $quoteRequest = $request->attributes->get('deserializedRequestObject');
        return $quoteRequest->getQuotes();
    }
}
