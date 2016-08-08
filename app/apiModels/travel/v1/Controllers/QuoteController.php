<?php

namespace App\apiModels\travel\v1\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class QuoteController extends Controller
{
    public function get(Request $request)
    {
        $quoteRequest = $request->attributes->get('deserializedRequestObject');
        return $quoteRequest->getQuotes();
    }
}
