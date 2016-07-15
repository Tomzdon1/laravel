<?php

$app->get('echo', function(){
	return 'echo';
});

$app->group([
    'prefix' => 'travel/v1',
    'middleware' => ['auth', 'request_validate:'.env('API_DEFINITION_TRAVEL_V1').','.env('ERROR_MODEL_IMPL_TRAVEL_V1')],
    'namespace' => 'App\apiModels\travel\v1\Controllers'
    ], function ($app) {
        $app->post('get_quotes','getQuotesCtrl@request');
        $app->post('calculate_policy','calculatePolicyCtrl@request');
        $app->post('issue_policy','issuePolicyCtrl@request');
        $app->post('import_policies','importPoliciesCtrl@request');
        $app->post('print_policy','printPolicyCtrl@request');
});
