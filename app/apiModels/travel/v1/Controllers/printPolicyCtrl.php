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

        $queryArray = [];
        $queryArray['_id'] = new \MongoId($this->data['policy_ref']);
        $queryArray['quote_ref'] = $this->data['quote_ref'];

        // Brak parametru policy_number w definicji API
        // if (isset($this->data['policy_number'])) {
        //     $queryArray['policy_number'] = $this->data['policy_number'];
        // }

        $collection = $this->mongoDB->selectCollection(CP_POLICIES);
        $policy = $collection->findOne($queryArray);

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
