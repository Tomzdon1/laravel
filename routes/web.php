<?php

$app->get('echo', function () {
    return 'echo';
});

$app->group([
    'prefix' => 'travel/v1',
    'middleware' => ['auth', 'request_validate:' . env('API_DEFINITION_TRAVEL_V1') . ',' . env('ERROR_MODEL_IMPL_TRAVEL_V1'), 'deserialize_request_object:' . env('API_PROTOTYPES_NAMESPACES_TRAVEL_V1'), 'request_object_validate:' . env('ERROR_MODEL_IMPL_TRAVEL_V1')],
    'namespace' => 'travel\v1'
    ], function ($app) {
        $app->post('import_policies', 'PolicyController@import');
});

$app->group([
    'prefix' => 'insurance/v2',
    'middleware' => ['auth', 'request_validate:' . env('API_DEFINITION_TRAVEL_V2') . ',' . env('ERROR_MODEL_IMPL_TRAVEL_V2'), 'deserialize_request_object:' . env('API_PROTOTYPES_NAMESPACES_TRAVEL_V2'), 'request_object_validate:' . env('ERROR_MODEL_IMPL_TRAVEL_V2')],
    'namespace' => 'travel\v2'
    ], function ($app) {
        $app->post('option-definitions', 'OptionDefinitionController@index');
        $app->post('quotes', 'QuoteController@index');
        $app->post('policies/calculate', 'PolicyController@calculate');
        $app->post('policies/purchase', 'PolicyController@purchase');
        $app->post('policies/issue', 'PolicyController@issue');
        $app->post('policies/import', 'PolicyController@import');
        $app->post('policies/print', 'PolicyController@print');
        $app->post('orders/status', 'OrderStatusController@show');
});
