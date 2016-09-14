<?php

$app->get('echo', function () {
    return 'echo';
});

$app->group([
    'prefix' => 'travel/v1',
    'middleware' => ['auth', 'request_validate:' . env('API_DEFINITION_TRAVEL_V1') . ',' . env('ERROR_MODEL_IMPL_TRAVEL_V1'), 'deserialize_request_object:' . env('API_PROTOTYPES_NAMESPACES_TRAVEL_V1'), 'request_response_logger'],
    'namespace' => 'App\apiModels\travel\v1\Controllers'
    ], function ($app) {
        $app->post('get_quotes', 'QuoteController@get');
        $app->post('calculate_policy', 'PolicyController@calculate');
        $app->post('issue_policy', 'PolicyController@issue');
        $app->post('import_policies', 'PolicyController@import');
        $app->post('print_policy', 'PolicyController@printPolicy');
        $app->post('search_policies', 'PolicyController@searchPolicy');
});
