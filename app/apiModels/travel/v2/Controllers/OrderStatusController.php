<?php

namespace App\apiModels\travel\v2\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class OrderStatusController extends Controller
{
    public function show(Request $request)
    {
    	// @todo usunąć po zaimplementowaniu
        return Response::HTTP_NOT_IMPLEMENTED;

        $quoteRequest = $request->attributes->get('deserializedRequestObject');
        return $quoteRequest->show();
    }
}
