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

$app->group([
    'prefix' => 'travel/v1', 
    //'middleware' => 'request_validate:'.env('API_DEFINITION_TRAVEL_V1').','.env('ERROR_MODEL_IMPL_TRAVEL_V1'), 
    'namespace' => 'App\apiModels\travel\v1\Controllers'
    ], function ($app) {
        $app->post('get_quotes','getQuotesCtrl@request');
        $app->post('calculate_policy','calculatePolicyCtrl@request');
        $app->post('issue_policy','issuePolicyCtrl@request');
        $app->post('import_policies','importPoliciesCtrl@request');

//        $app->post('{path:.*}', 'whoamiCtrl@showPost');
    

});
