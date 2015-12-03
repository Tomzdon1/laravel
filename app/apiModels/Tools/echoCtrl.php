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
      $content_xml = file_get_contents("C:\\Projekty\\PHP\\PrintOut\\Dane\\dane.xml");
      $template_name = "TESTCOM";
            
      /* @var $printout PrintOutService */   
      $printout = app()->make('PrintOut');
      
     
      $pdf =  app()->make('PrintOut')->PrintSingleFile( $template_name,$content_xml);
       
      return (new Response($pdf->getFile()))->header('Content-Type',$pdf->getContentType());
      //return new JsonResponse(["data"=>"data"]);
      //return \DateTime::createFromFormat('U.u', microtime(true))->format("YmdHisu");
    }

  
    
}
