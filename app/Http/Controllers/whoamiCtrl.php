<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
//use App\Connectors\ESB_connector as ESB_conn;

class whoamiCtrl extends Controller{
//  public function show($path, ESB_conn $esb){
  public function show($path){    
//    $esb = \App::make('ESB_conn');  
//    $esb = app('ESB_conn');
    \Log::info('Use ESB connector: '.app('ESB_conn')->show());
    
    print_r(app('ESB_conn')->doTestRequest());
    
    $html = '<h2>';
    $html .='<img class="sp_logo" src="http://tueuropa.pl/assets/images/sprite/logo.png" alt="TUEuropa.pl">Centrum produktowe TU EUROPA</h2>';
    $html .= '<p><a href="http://ndok/cp/testform/">Formularz testowy</a></p>';
    $html .= '<pre>'.$path.'</pre>';
    return $html;
  }
  
  public function showPost($path){
    $response = Array();
    $response['whoami'] = 'Centrum produktowe TU EUROPA';
    return response()->json($response);
  }
}

