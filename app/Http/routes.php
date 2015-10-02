<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$app->post('cp/public/api/travel/v1/getquotest/{partnerId}/{requestId}','getQuotesCtrl@request');
$app->post('cp/public/api/travel/v1/{methode}/{partnerId}/{requestId}','testCtrl@request');
//do usunieca, tylko testowo
$app->get('cp/public/api/500', function(){
	abort(500);
});
// dotąd
$app->post('{path:.*}', 'whoamiCtrl@showPost');
$app->get('{path:.*}', 'whoamiCtrl@show');
