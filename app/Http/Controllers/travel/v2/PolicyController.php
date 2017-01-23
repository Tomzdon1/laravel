<?php

namespace App\Http\Controllers\travel\v2;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\TravelOffer;
use App\Policy;
use Symfony\Component\HttpFoundation\Response as Response;
use App\apiModels\travel\v2\Implementations;
use App\apiModels\travel\v2\Mappers;

class PolicyController extends Controller
{
    public function calculate(Request $request)
    {
        $calculateRequest = $request->attributes->get('deserializedRequestObject');
        
        $offer = TravelOffer::find($calculateRequest->getProductId());

        if (!$offer) {
            $error = new Implementations\ErrorImpl();
            $error->setDescription('Forbidden');
            
            return response([$error], Response::HTTP_FORBIDDEN);
        }
        
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
        $calculationMaxExpirationTime = $offer->configuration->calculationMaxExpirationTime;
        
        if ($calculationMaxExpirationTime == 'P0D') {
            $calculatedDueDate->modify('tomorrow midnight');
        } else {
            $calculatedDueDate->add(new \DateInterval($offer->configuration->calculationMaxExpirationTime));
        }

        $startDate = $calculateRequest->getData()->getStartDate();
        $dueDate = min($calculatedDueDate, $startDate);
        $calculationPolicyResponse->setDueDate($dueDate->format(\DateTime::ATOM));

        $calculation = Mappers\CalculationMapper::fromCalculationPolicy($calculationPolicyResponse, $calculateRequest);
        $calculation->partner_id = app('auth')->user()->id;
        $calculation->checksum = md5($calculation);
        $calculation->save();

        $calculationPolicyResponse->setCalculationId($calculation->id);
        $calculationPolicyResponse->setChecksum($calculation->checksum);
        
        return json_decode($calculationPolicyResponse, true);
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
        
        // $calculation
        //  = Mappers\CalculationMapper::fromCalculationPolicy($calculationPolicyResponse, $calculateRequest);
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
            $offer = TravelOffer::find($importRequest->getProductId());

            if (!$offer) {
                $error = new Implementations\ERRORImpl();
                $error->setDescription('Forbidden');
                return response([$error], Response::HTTP_FORBIDDEN);
            }
        }

        foreach ($importRequests as $importRequest) {
            // @todo uncomment below after add feauture (przeniesienie kalkulacji do uslugi kalkulacji)
            // $calculatedPolicy = $policyCalaculator->calculate($importRequest);
            // $calucaltedPremiums = $calculatedPolicy->getPremiums();
            
            // @todo remove below block after add feauture (przeniesienie kalkulacji do uslugi kalkulacji)
            $importRequest->setCalculateRequest($importRequest);
            $importRequest->setOffer(TravelOffer::find($importRequest->getProductId()));
            $importRequest->setWithNettoPremium(true);
            $calculatedPremiums = $importRequest->calculatePremiums();

            $validator = app('validator')->make(
                array_dot($importRequest),
                $importRequest::$warningValidators,
                [],
                ['calculatedAmounts' => $calculatedPremiums]
            );

            $importPolicyStatusResponse = new Implementations\ImportPolicyStatusImpl;

            if ($validator->fails()) {
                foreach ($validator->errors()->toArray() as $property => $error) {
                    $importPolicyStatusResponse->addMessage($property, implode(', ', $error));
                }
                $importPolicyStatusResponse->setStatus($importPolicyStatusResponse::STATUS_WARN);
            } else {
                $importPolicyStatusResponse->setStatus($importPolicyStatusResponse::STATUS_OK);
            }

            $requestedPolicy = Mappers\PolicyModelMapper::fromImportPolicyRequest($importRequest);
            $requestedPolicy->status = $importPolicyStatusResponse->getStatus();
            $requestedPolicy->errors = $importPolicyStatusResponse->getMessages();
            $requestedPolicy->partner = json_decode(app('auth')->user()->toJson());
            $requestedPolicy->product = json_decode(TravelOffer::find($importRequest->getProductId())->toJson());
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
}
