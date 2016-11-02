<?php

namespace App\apiModels\travel\v2\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App;
use Symfony\Component\HttpFoundation\Response as Response;
use App\apiModels\travel\v2\Implementations;
use App\apiModels\travel\v2\Mappers;

class PolicyController extends Controller
{
    public function calculate(Request $request)
    {
        $calculateRequest = $request->attributes->get('deserializedRequestObject');
        
        $offer = App\TravelOffer::find($calculateRequest->getProductId());
        
        // @todo uncomment below after add feauture (przeniesienie kalkulacji do uslugi kalkulacji)
        // $calculationCalaculator = app()->make('calculationCalaculator');
        // $calculatedCalculation = $calculationCalaculator->calculate($calculateRequest);
        // $calucaltedPremiums = $calculatedCalculation->getPremiums();
        
        // @todo remove below block after add feauture (przeniesienie kalkulacji do uslugi kalkulacji)
        $calculateRequest->setCalculateRequest($calculateRequest);
        $calculateRequest->setOffer($offer);
        $calculatedPremiums = $calculateRequest->calculatePremiums();
        // remove this and above
        
        $calculationPolicyResponse = new Implementations\CalculationPolicyImpl;
        $calculationPolicyResponse->setPremium($calculatedPremiums['premium']);
        $calculationPolicyResponse->setTariffPremium($calculatedPremiums['tariff_premium']);
        
        $calculatedDueDate = new \DateTime();
        $calculatedDueDate->add(new \DateInterval($offer->configuration['calculationMaxExpirationTime']));
        $startDate = $calculateRequest->getData()->getStartDate();
        $dueDate = min($calculatedDueDate, $startDate);
        $calculationPolicyResponse->setDueDate($dueDate->format(\DateTime::ATOM));

        //@todo brak obslugi checksum - wyliczanie i zapisywanie
        //$calculationPolicyResponse->setChecksum();
        
        $calculation = Mappers\CalculationMapper::fromCalculationPolicy($calculationPolicyResponse, $calculateRequest);
        $calculation->partner_id = app('auth')->user()->id;
        $calculation->save();
        
        $calculationPolicyResponse->setCalculationId($calculation->id);
        
        return $calculationPolicyResponse;
    }

    public function purchase(Request $request)
    {
        return Response::HTTP_NOT_IMPLEMENTED;
    }

    public function issue(Request $request)
    {
        $issuePolicyRequest = $request->attributes->get('deserializedRequestObject');
        
        $calculation = App\Calculation::find($issuePolicyRequest->getCalculationId());
        
        // // @todo uncomment below after add feauture (przeniesienie kalkulacji do uslugi kalkulacji)
        // // $calculationCalaculator = app()->make('calculationCalaculator');
        // // $calculatedCalculation = $calculationCalaculator->calculate($calculateRequest);
        // // $calucaltedPremiums = $calculatedCalculation->getPremiums();
        
        // // @todo remove below block after add feauture (przeniesienie kalkulacji do uslugi kalkulacji)
        // $calculateRequest->setCalculateRequest($calculateRequest);
        // $calculateRequest->setOffer($offer);
        // $calculatedPremiums = $calculateRequest->calculatePremiums();
        // // remove this and above
        
        // $calculationPolicyResponse = new Implementations\CALCULATIONPOLICYImpl;
        // $calculationPolicyResponse->setPremium($calculatedPremiums['premium']);
        // $calculationPolicyResponse->setTariffPremium($calculatedPremiums['tariff_premium']);
        
        // $calculatedDueDate = new \DateTime();
        // $calculatedDueDate->add(new \DateInterval($offer->configuration['calculationMaxExpirationTime']));
        // $startDate = $calculateRequest->getData()->getStartDate();
        // $dueDate = min($calculatedDueDate, $startDate);
        // $calculationPolicyResponse->setDueDate($dueDate->format(\DateTime::ATOM));

        // //@todo brak obslugi checksum - wyliczanie i zapisywanie
        // //$calculationPolicyResponse->setChecksum();
        
        // $calculation = Mappers\CalculationMapper::fromCalculationPolicy($calculationPolicyResponse, $calculateRequest);
        // $calculation->partner_id = app('auth')->user()->id;
        // $calculation->save();
        
        // $calculationPolicyResponse->setCalculationId($calculation->id);
        
        // return $calculationPolicyResponse;
    }

    public function import(Request $request)
    {
        $importStatuses = [];
        $importRequests = $request->attributes->get('deserializedRequestObject');
        
        // @todo uncomment below after add feauture (przeniesienie kalkulacji do uslugi kalkulacji)
        // $policyCalaculator = app()->make('PolicyCalaculator');

        foreach ($importRequests as $importRequest) {
            // @todo uncomment below after add feauture (przeniesienie kalkulacji do uslugi kalkulacji)
            // $calculatedPolicy = $policyCalaculator->calculate($importRequest);
            // $calucaltedPremiums = $calculatedPolicy->getPremiums();
            
            // @todo remove below block after add feauture (przeniesienie kalkulacji do uslugi kalkulacji)
            $importRequest->setCalculateRequest($importRequest);
            $importRequest->setOffer(App\TravelOffer::find($importRequest->getProductId()));
            $importRequest->setWithNettoPremium(true);
            $calculatedPremiums = $importRequest->calculatePremiums();

            $validator = app('validator')->make(app('request')->input()[0], $importRequest::$warningValidators, [], ['calculatedAmounts' => $calculatedPremiums]);

            $importPolicyStatusResponse = new Implementations\ImportPolicyStatusImpl;

            if ($validator->fails()) {
                foreach ($validator->errors()->toArray() as $property => $error) {
                    $importPolicyStatusResponse->addMessage($property, implode(', ', $error));
                }
                $importPolicyStatusResponse->setStatus($importPolicyStatusResponse::STATUS_WARN);
            } else {
                $importPolicyStatusResponse->setStatus($importPolicyStatusResponse::STATUS_OK);
            }
            
            $requestedPolicy = new App\Policy;
            // @todo mapper na policy per api (na pewno bez importPolicyStatus)
            $requestedPolicy->fillFromImportRequest($importRequest, $importPolicyStatusResponse);
            $requestedPolicy->save();

            $importPolicyStatusResponse->setPolicyId($requestedPolicy->id);
            $importStatuses[] = $importPolicyStatusResponse;
        }

        return $importStatuses;
    }

    public function printPolicy(Request $request, $policyId)
    {
        return Response::HTTP_NOT_IMPLEMENTED;
        
        $policy = App\Policy::find($policyId)->first();

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

        return App\Policy::find($policyId)->first();
    }
}
