<?php

namespace App\apiModels\travel\v1\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\RequestCtrl;
use App\Printout\PrintOutService;
use App\Http\Partner;

class printPolicyCtrl extends RequestCtrl
{

    public function request(Request $request, $parter_id = null, $request_id = null, $create_new_quote_log = null)
    {
        parent::request($request, $parter_id, $request_id);

        $policy = app('db')->collection(CP_POLICIES)->
            find($this->data['policy_ref'])->where('quote_ref', $this->data['quote_ref']);

        if ($policy) {
            try {
                $template_name = $this->partner->getPartnerData()['apis']['travel']['printTemplateSettings']['name'];
            } catch (\Exception $e) {
                $template_name = $this->partner->getStdPartnerData()['apis']['travel']['printTemplateSettings']['name'];
            }

            $printing = app()->make('PdfPrinter');

            $pdf = $printing->getDocumentFromArray($template_name, $policy);

            if ($pdf->IsError()) {
                app('log')->error($pdf->ErrorMsg());
                abort(Response::HTTP_INTERNAL_SERVER_ERROR);
            }

            $this->response = (new Response($pdf->File()))->header('Content-Type', $pdf->ContentType());

            return $this->response;
        } else {
            abort(Response::HTTP_NOT_FOUND);
        }
    }
}
