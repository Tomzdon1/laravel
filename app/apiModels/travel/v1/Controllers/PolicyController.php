<?php

namespace App\apiModels\travel\v1\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Policy;
use Symfony\Component\HttpFoundation\Response as Response;

class PolicyController extends Controller
{
    public function calculate(Request $request)
    {
        // deprecated API
        return Response::HTTP_GONE;

        $calculateRequest = $request->attributes->get('deserializedRequestObject');
        return $calculateRequest->calculate();
    }

    public function issue(Request $request)
    {
        // deprecated API
        return Response::HTTP_GONE;

        $issueRequest = $request->attributes->get('deserializedRequestObject');
        return $issueRequest->issue();
    }

    public function import(Request $request)
    {
        $importStatuses = [];
        $importRequests = $request->attributes->get('deserializedRequestObject');

        foreach ($importRequests as $importRequest) {
            $importStatuses[] = $importRequest->import(); 
        }

        return $importStatuses;
    }

    public function printPolicy(Request $request, $policyId = null)
    {
        // deprecated API
        return Response::HTTP_GONE;
        
        $policy = Policy::find($policyId)->first();

        try {
            $template_name = $request->user()->apis['travel']['printTemplateSettings']['name'];
        } catch (\Exception $e) {
            abort(Response::HTTP_METHOD_NOT_ALLOWED);
        }

        $printing = app()->make('PdfPrinter');

        $pdf = $printing->getDocumentFromArray($template_name, $policy);

        if ($pdf->IsError()) {
            app('log')->error($pdf->ErrorMsg());
            abort(Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return (new Response($pdf->File()))->header('Content-Type', $pdf->ContentType());
    }

    public function searchPolicy(Request $request)
    {
        // deprecated API
        return Response::HTTP_GONE;
    }
}
