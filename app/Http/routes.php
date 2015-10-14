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
    'middleware' => 'request_validate:'.env('API_DEFINITION_TRAVEL_V1').','.env('ERROR_MODEL_IMPL_TRAVEL_V1'), 
    // Namespace kontrolerów powinien być zgodny z namespacem modeli -> prościej.
    // Wówczas tworzenie obiektu błędu (w kontrolerze np. walidacja) nie będzie wymagało znajomości ścieżki.
    'namespace' => 'App\Http\Controllers'
    ], function ($app) {
        $app->post('get_quotes','getQuotesCtrl@request');
});