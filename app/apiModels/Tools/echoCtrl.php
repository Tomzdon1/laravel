<?php

namespace App\apiModels\Tools;
use Log;
use Cache;
use Laravel\Lumen\Routing\Controller as BaseController;
use App\Http\Controllers\RequestCtrl;
use Illuminate\Http\Request;
//use Symfony\Component\HttpFoundation\Response as Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;



//RequestCtrl
class echoCtrl extends  BaseController{

  public function request(Request $request)    
  {
      Log::debug('File='.__FILE__);        
      
      $content_xml = file_get_contents("C:\\Projekty\\PHP\\PrintOut\\Dane\\dane.xml");
      $template_name = "TESTCOM";
      $pdf =  app()->make('PrintOut')->PrintSingleFile( $template_name,$content_xml);
       
      return (new Response($pdf))->header('Content-Type','application/pdf');
      //return new JsonResponse(["data"=>"data"]);
      //return \DateTime::createFromFormat('U.u', microtime(true))->format("YmdHisu");
    }

  
    
}
