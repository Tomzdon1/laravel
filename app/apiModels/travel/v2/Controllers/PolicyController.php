<?php

namespace App\apiModels\travel\v2\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Policy;
use Symfony\Component\HttpFoundation\Response as Response;

class PolicyController extends Controller
{
    public function calculate(Request $request)
    {
        $calculateRequest = $request->attributes->get('deserializedRequestObject');
        return $calculateRequest->calculate();
    }

    public function purchase(Request $request)
    {
        return Response::HTTP_NOT_IMPLEMENTED;

        $purchaseRequest = $request->attributes->get('deserializedRequestObject');
        return $purchaseRequest->purchaseRequest();
    }

    public function issue(Request $request)
    {
        // @todo usunąć po zaimplementowaniu
        return Response::HTTP_NOT_IMPLEMENTED;

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

    public function printPolicy(Request $request, $policyId)
    {
        return Response::HTTP_NOT_IMPLEMENTED;
        
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

    public function show(Request $request, $policyId=null)
    {
        return Response::HTTP_NOT_IMPLEMENTED;

        return Policy::find($policyId)->first();
    }
}
