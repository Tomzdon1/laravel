<?php

namespace App\apiModels\Tools;
use Laravel\Lumen\Routing\Controller as BaseController;
use Illuminate\Http\Request;
//use Symfony\Component\HttpFoundation\Response as Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use App\Printout\PrintOutService;



//RequestCtrl
class echoCtrl extends  BaseController{

  public function request(Request $request)    
  {
      \Log::debug('File='.__FILE__);        
      \Log::debug('Dir='.__DIR__);
      \Log::debug(var_export(app()->path(),true));
      $content_xml = file_get_contents(app()->path().'/../tests/rawTestData/PrintOut/dane.xml');      
      $template_name = "TESTCOM";
            
      /* @var $printing Tue\Printing\Printer */   
      $printing = app()->make('PdfPrinter');
      
     
      $pdf =  $printing->getDocument($template_name,$content_xml);
       
      return (new Response($pdf->File()))->header('Content-Type',$pdf->ContentType());
      //return new JsonResponse(["data"=>"data"]);
      //return \DateTime::createFromFormat('U.u', microtime(true))->format("YmdHisu");
    }

  
    
}
