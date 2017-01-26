<?php

use FR3D\SwaggerAssertions\SchemaManager;
use JsonSchema\Validator;
use Symfony\Component\HttpFoundation\Response as Response;
use FR3D\SwaggerAssertions\PhpUnit\AssertsTrait;

class GetQuotesTest extends TestCase
{
	use AssertsTrait;

	/**
     * @var SchemaManager
     */
	protected static $schemaManager;

	public static function setUpBeforeClass()
	{
		$uri = 'file://' . env('API_DEFINITION_TRAVEL_V2');
		self::$schemaManager = new SchemaManager($uri);
	}

	public function getRequest(callable $callback = null)
	{
		$validJsonRequest = '{"data":{"promo_code":"TESTOWY_KOD","abroad":true,"start_date":"","end_date":"","destination":"PL","options":[{"code":"TWCHP","value":"true"}]},"prepersons":[{"birth_date":"","options":[{"code": "student", "value": "true"}]},{"birth_date":""}]}';
		$request = json_decode($validJsonRequest);

		$request->data->start_date =  date('c', strtotime('+10 days'));
		$request->data->end_date =  date('c', strtotime('+20 days', strtotime($request->data->start_date)));
		$request->prepersons[0]->birth_date =  date('Y-m-d', strtotime('-20 years'));
		$request->prepersons[1]->birth_date =  date('Y-m-d', strtotime('-20 years'));

		if ($callback) {
			$callback($request);
		}

		return $request;
	}

	/**
	 * Function provide request to test response schema validation of get_quotes resource
	 * 
	 * This function only merge data providers (schema should be valid for every response)
	 * 
	 * @return Array
	 */
	public function allRequestsProvider()
	{
		return array_merge(
			$this->requestForResponseCode400Provider(),
			$this->requestForResponseCode422Provider(),
			$this->requestForResponseCode200Provider());
	}

	/**
	 * Function provide request to test response code 400 (schema validation fail) of get_quotes resource
	 * 
	 * @return Array
	 */
	public function requestForResponseCode400Provider()
	{
		return [
		'None request' => [400, null],
		'None data' => [400, $this->getRequest(function(&$request){unset($request->data);})],
		'None data.start_date' => [400, $this->getRequest(function(&$request){unset($request->data->start_date);})],
		'None data.end_date' => [400, $this->getRequest(function(&$request){unset($request->data->end_date);})],
		'None data.options.code' => [400, $this->getRequest(function(&$request){unset($request->data->options[0]->code);})],
		'None data.options.value' => [400, $this->getRequest(function(&$request){unset($request->data->options[0]->value);})],
		'None prepersons' => [400, $this->getRequest(function(&$request){unset($request->prepersons);})],
		'None prepersons.birth_date' => [400, $this->getRequest(function(&$request){unset($request->prepersons[0]->birth_date);})],
		'None prepersons.options.code' => [400, $this->getRequest(function(&$request){unset($request->prepersons[0]->options[0]->code);})],
		'None prepersons.options.value' => [400, $this->getRequest(function(&$request){unset($request->prepersons[0]->options[0]->value);})],

		'Empty request object' => [400, (object) []],
		'Empty data' => [400, $this->getRequest(function(&$request){$request->data = (object) [];})],
		'Empty data.start_date' => [400, $this->getRequest(function(&$request){$request->data->start_date = '';})],
		'Empty data.end_date' => [400, $this->getRequest(function(&$request){$request->data->end_date = '';})],
		'Empty data.options.code' => [400, $this->getRequest(function(&$request){$request->data->options[0]->code = '';})],
		'Empty prepersons' => [400, $this->getRequest(function(&$request){$request->prepersons = [];})],
		'Empty prepersons.birth_date' => [400, $this->getRequest(function(&$request){$request->prepersons[0]->birth_date = '';})],
		'Empty prepersons.options.code' => [400, $this->getRequest(function(&$request){$request->prepersons[0]->options[0]->code = '';})],

		'Invalid type of request' => [400, []],
		'Invalid type of data' => [400, $this->getRequest(function(&$request){$request->data = [];})],
		'Invalid type of data.promo_code' => [400, $this->getRequest(function(&$request){$request->data->promo_code = [];})],
		'Invalid type of data.start_date' => [400, $this->getRequest(function(&$request){$request->data->start_date = [];})],
		'Invalid type of data.end_date' => [400, $this->getRequest(function(&$request){$request->data->end_date = [];})],
		'Invalid type of data.abroad' => [400, $this->getRequest(function(&$request){$request->data->abroad = [];})],
		'Invalid type of data.destination' => [400, $this->getRequest(function(&$request){$request->data->destination = [];})],
		'Invalid type of data.options' => [400, $this->getRequest(function(&$request){$request->data->options = (object) [];})],
		'Invalid type of data.options.code' => [400, $this->getRequest(function(&$request){$request->data->options[0]->code = [];})],
		'Invalid type of data.options.value' => [400, $this->getRequest(function(&$request){$request->data->options[0]->value = [];})],
		'Invalid type of data.options.sub_options' => [400, $this->getRequest(function(&$request){$request->data->options[0]->sub_options = (object) [];})],
		'Invalid type of prepersons' => [400, $this->getRequest(function(&$request){$request->prepersons = (object) [];})],
		'Invalid type of prepersons.birth_date' => [400, $this->getRequest(function(&$request){$request->prepersons[0]->birth_date = (object) [];})],
		'Invalid type of prepersons.options' => [400, $this->getRequest(function(&$request){$request->prepersons[0]->options = (object) [];})],
		'Invalid type of prepersons.options.code' => [400, $this->getRequest(function(&$request){$request->prepersons[0]->options[0]->code = [];})],
		'Invalid type of prepersons.options.value' => [400, $this->getRequest(function(&$request){$request->prepersons[0]->options[0]->value = [];})],
		'Invalid type of prepersons.options.sub_options' => [400, $this->getRequest(function(&$request){$request->prepersons[0]->options[0]->sub_options = (object) [];})],

		'Invalid value pattern of data.start_date' => [400, $this->getRequest(function(&$request){$request->data->start_date = '';})],
		'Invalid value pattern of data.start_date' => [400, $this->getRequest(function(&$request){$request->data->start_date = '2016-10-30';})],
		'Invalid value pattern of data.end_date' => [400, $this->getRequest(function(&$request){$request->data->end_date = '';})],
		'Invalid value pattern of data.end_date' => [400, $this->getRequest(function(&$request){$request->data->end_date = '2016-10-30';})],
		'Invalid value pattern of data.destination' => [400, $this->getRequest(function(&$request){$request->data->destination = '';})],
		'Invalid value pattern of data.destination' => [400, $this->getRequest(function(&$request){$request->data->destination = 'A';})],
		'Invalid value pattern of data.destination' => [400, $this->getRequest(function(&$request){$request->data->destination = 'ABC';})],
		'Invalid value pattern of data.promo_code' => [400, $this->getRequest(function(&$request){$request->data->promo_code = '';})],
		'Invalid value pattern of prepersons.birth_date' => [400, $this->getRequest(function(&$request){$request->prepersons[0]->birth_date = '';})],
		'Invalid value pattern of prepersons.birth_date' => [400, $this->getRequest(function(&$request){$request->prepersons[0]->birth_date = '2016-11-30T12:12:12+01:00';})],
		];
	}

    /**
	 * Function provide request to test response code 422 (laravel/bussiness validation fail) of get_quotes resource
	 * 
	 * @return Array
	 */
    public function requestForResponseCode422Provider()
    {
    	return [
    	'Invalid value of data.destination (Unassigned)' => [422, $this->getRequest(function(&$request){$request->data->destination = 'AB';})],
    	'Invalid value of data.destination (Not used)' => [422, $this->getRequest(function(&$request){$request->data->destination = 'AP';})],
    	'Invalid value of data.destination (Indeterminately reserved)' => [422, $this->getRequest(function(&$request){$request->data->destination = 'DY';})],
    	'Invalid value of data.destination (Exceptionally reserved)' => [422, $this->getRequest(function(&$request){$request->data->destination = 'AC';})],
    	'Invalid value of data.destination (User-assigned)' => [422, $this->getRequest(function(&$request){$request->data->destination = 'AA';})],
    	'Invalid value of data.start_date (yesterday)' => [422, $this->getRequest(function(&$request){$request->data->start_date =  date('c', strtotime('-1 day'));})],
    	'Invalid value of data.start_date (-10 years)' => [422, $this->getRequest(function(&$request){$request->data->start_date =  date('c', strtotime('-10 years'));})],
    	'Invalid value of data.end_date (before start_date)' => [422, $this->getRequest(function(&$request){$request->data->start_date =  date('c'); $request->data->end_date =  date('c', strtotime('-1 sec'));})],
    	'Invalid value of data.end_date (equal start_date)' => [422, $this->getRequest(function(&$request){$request->data->start_date =  date('c'); $request->data->end_date =  date('c');})],
    	'Invalid value of prepersons.birth_date (now)' => [422, $this->getRequest(function(&$request){$request->prepersons[0]->birth_date =  date('Y-m-d');})],
    	'Invalid value of prepersons.birth_date (tommorow)' => [422, $this->getRequest(function(&$request){$request->prepersons[0]->birth_date =  date('Y-m-d', strtotime('+1 day'));})],
    	'Invalid value of prepersons.birth_date (+10 years)' => [422, $this->getRequest(function(&$request){$request->prepersons[0]->birth_date =  date('Y-m-d', strtotime('+10 years'));})],
    	];
    }

	/**
	 * Function provide request to test response code 200 (without any fails) of get_quotes resource
	 * 
	 * @return Array
	 */
	public function requestForResponseCode200Provider()
	{
		return [
		'Valid request' => [200, $this->getRequest()],
		'Valid request without data.promo_code' => [200, $this->getRequest(function(&$request){unset($request->data->promo_code);})],
		'Valid request without data.abroad' => [200, $this->getRequest(function(&$request){unset($request->data->abroad);})],
		'Valid request without data.destination' => [200, $this->getRequest(function(&$request){unset($request->data->destination);})],
		'Valid request without data.options' => [200, $this->getRequest(function(&$request){unset($request->data->options);})],
		'Valid request without prepersons.options' => [200, $this->getRequest(function(&$request){unset($request->prepersons[0]->options);})],

		'Valid empty data.options' => [200, $this->getRequest(function(&$request){$request->data->options = [];})],
		'Valid empty data.options.value' => [200, $this->getRequest(function(&$request){$request->data->options[0]->value = '';})],
		'Valid empty prepersons.options' => [200, $this->getRequest(function(&$request){$request->prepersons[0]->options = [];})],
		'Valid empty prepersons.options.value' => [200, $this->getRequest(function(&$request){$request->prepersons[0]->options[0]->value = '';})],

		'Valid value of data.promo_code (char)' => [200, $this->getRequest(function(&$request){$request->data->promo_code = 'A';})],
		'Valid value of data.promo_code (special chars)' => [200, $this->getRequest(function(&$request){$request->data->promo_code = '!@#$%^&*(),./;:"[]{}|<>?~`\\-+=_';})],
		'Valid value of data.promo_code (digit)' => [200, $this->getRequest(function(&$request){$request->data->promo_code = '1';})],
		'Valid value of data.promo_code (string)' => [200, $this->getRequest(function(&$request){$request->data->promo_code = 'ABCDEFGHIJKLMNOPQRSTUWXYZ';})],
		'Valid value of data.promo_code (number)' => [200, $this->getRequest(function(&$request){$request->data->promo_code = '12345678910111213141516171819120';})],
		'Valid value of data.start_date (today midnight)' => [200, $this->getRequest(function(&$request){$request->data->start_date =  date('c', strtotime('midnight')); $request->data->end_date =  date('c', strtotime('+1 sec', strtotime($request->data->start_date)));})],
		'Valid value of data.start_date (now)' => [200, $this->getRequest(function(&$request){$request->data->start_date =  date('c'); $request->data->end_date =  date('c', strtotime('+1 sec', strtotime($request->data->start_date)));})],
		'Valid value of data.start_date (tommorow)' => [200, $this->getRequest(function(&$request){$request->data->start_date =  date('c', strtotime('+1 day')); $request->data->end_date =  date('c', strtotime('+1 sec', strtotime($request->data->start_date)));})],
		'Valid value of data.start_date (+10 years)' => [200, $this->getRequest(function(&$request){$request->data->start_date =  date('c', strtotime('+10 years')); $request->data->end_date =  date('c', strtotime('+1 sec', strtotime($request->data->start_date)));})],
		'Valid value of data.end_date (start_date +1 sec)' => [200, $this->getRequest(function(&$request){$request->data->start_date =  date('c'); $request->data->end_date =  date('c', strtotime('+1 sec', strtotime($request->data->start_date)));})],
		'Valid value of data.end_date (start_date +1 day)' => [200, $this->getRequest(function(&$request){$request->data->start_date =  date('c'); $request->data->end_date =  date('c', strtotime('+1 day', strtotime($request->data->start_date)));})],
		'Valid value of data.end_date (start_date +100 year)' => [200, $this->getRequest(function(&$request){$request->data->start_date =  date('c'); $request->data->end_date =  date('c', strtotime('+10 years', strtotime($request->data->start_date)));})],
		'Valid value of data.abroad (true)' => [200, $this->getRequest(function(&$request){$request->data->abroad = true;})],
		'Valid value of data.abroad (false)' => [200, $this->getRequest(function(&$request){$request->data->abroad = false;})],
		'Valid value of data.destination (WR)' => [200, $this->getRequest(function(&$request){$request->data->destination = 'WR';})],
		'Valid value of data.destination (EU)' => [200, $this->getRequest(function(&$request){$request->data->destination = 'EU';})],
		'Valid value of data.destination (AD)' => [200, $this->getRequest(function(&$request){$request->data->destination = 'AD';})],
		'Valid value of data.destination (PL)' => [200, $this->getRequest(function(&$request){$request->data->destination = 'PL';})],
		'Valid value of data.destination (ZW)' => [200, $this->getRequest(function(&$request){$request->data->destination = 'ZW';})],
		'Valid value of data.options.code (char)' => [200, $this->getRequest(function(&$request){$request->data->options[0]->code = 'A';})],
		'Valid value of data.options.code (special chars)' => [200, $this->getRequest(function(&$request){$request->data->options[0]->code = '!@#$%^&*(),./;:"[]{}|<>?~`\\-+=_';})],
		'Valid value of data.options.code (digit)' => [200, $this->getRequest(function(&$request){$request->data->options[0]->code = '1';})],
		'Valid value of data.options.code (string)' => [200, $this->getRequest(function(&$request){$request->data->options[0]->code = 'ABCDEFGHIJKLMNOPQRSTUWXYZ';})],
		'Valid value of data.options.code (number)' => [200, $this->getRequest(function(&$request){$request->data->options[0]->code = '12345678910111213141516171819120';})],
		'Valid value of data.options.value (char)' => [200, $this->getRequest(function(&$request){$request->data->options[0]->value = 'A';})],
		'Valid value of data.options.value (special chars)' => [200, $this->getRequest(function(&$request){$request->data->options[0]->value = '!@#$%^&*(),./;:"[]{}|<>?~`\\-+=_';})],
		'Valid value of data.options.value (digit)' => [200, $this->getRequest(function(&$request){$request->data->options[0]->value = '1';})],
		'Valid value of data.options.value (string)' => [200, $this->getRequest(function(&$request){$request->data->options[0]->value = 'ABCDEFGHIJKLMNOPQRSTUWXYZ';})],
		'Valid value of data.options.value (number)' => [200, $this->getRequest(function(&$request){$request->data->options[0]->value = '12345678910111213141516171819120';})],
		'Valid value of prepersons.birth_date (yesterday)' => [200, $this->getRequest(function(&$request){$request->prepersons[0]->birth_date =  date('Y-m-d', strtotime('-1 day'));})],
		'Valid value of prepersons.birth_date (-10 years)' => [200, $this->getRequest(function(&$request){$request->prepersons[0]->birth_date =  date('Y-m-d', strtotime('-10 years'));})],
		'Valid value of prepersons.options.code (char)' => [200, $this->getRequest(function(&$request){$request->prepersons[0]->options[0]->code = 'A';})],
		'Valid value of prepersons.options.code (special chars)' => [200, $this->getRequest(function(&$request){$request->prepersons[0]->options[0]->code = '!@#$%^&*(),./;:"[]{}|<>?~`\\-+=_';})],
		'Valid value of prepersons.options.code (digit)' => [200, $this->getRequest(function(&$request){$request->prepersons[0]->options[0]->code = '1';})],
		'Valid value of prepersons.options.code (string)' => [200, $this->getRequest(function(&$request){$request->prepersons[0]->options[0]->code = 'ABCDEFGHIJKLMNOPQRSTUWXYZ';})],
		'Valid value of prepersons.options.code (number)' => [200, $this->getRequest(function(&$request){$request->prepersons[0]->options[0]->code = '12345678910111213141516171819120';})],
		'Valid value of prepersons.options.value (char)' => [200, $this->getRequest(function(&$request){$request->prepersons[0]->options[0]->value = 'A';})],
		'Valid value of prepersons.options.value (special chars)' => [200, $this->getRequest(function(&$request){$request->prepersons[0]->options[0]->value = '!@#$%^&*(),./;:"[]{}|<>?~`\\-+=_';})],
		'Valid value of prepersons.options.value (digit)' => [200, $this->getRequest(function(&$request){$request->prepersons[0]->options[0]->value = '1';})],
		'Valid value of prepersons.options.value (string)' => [200, $this->getRequest(function(&$request){$request->prepersons[0]->options[0]->value = 'ABCDEFGHIJKLMNOPQRSTUWXYZ';})],
		'Valid value of prepersons.options.value (number)' => [200, $this->getRequest(function(&$request){$request->prepersons[0]->options[0]->value = '12345678910111213141516171819120';})],
		];
	}

	/**
	 * Function provide request to test quote_ref value in response of get_quotes resource
	 * 
	 * @return Array
	 */
	public function quoteRefValuesProvider()
	{
		// Not implement yet
	}

	/**
	 * Function provide request to test amount value in response of get_quotes resource
	 * 
	 * @return Array
	 */
	public function amountValuesProvider()
	{
		// return [
		// 'Valid request' => [200, $this->getRequest(function(&$request){
		// 		$request->data->start_date =  date('c', strtotime('+10 days')); 
		// 		$request->data->end_date =  date('c', strtotime('+20 days', strtotime($request->data->start_date)));
		// 		$request->prepersons[0]->birth_date =  date('Y-m-d', strtotime('-20 years'));
		// 		unset($request->prepersons[1]);
		// 	}), 'amount'=>['value_base' => 12.33] ],
		// ];
		// Not implement yet
	}

	/**
	 * Function provide request to test promo_code_valid value in response of get_quotes resource
	 * 
	 * @return Array
	 */
	public function promoCodeValidValuesProvider()
	{
		// Not implement yet
	}

	/**
	 * Function provide request to test description value in response of get_quotes resource
	 * 
	 * @return Array
	 */
	public function descriptionauleProvider()
	{
		// Not implement yet
	}

	/**
	 * Function provide request to test details value in response of get_quotes resource
	 * 
	 * @return Array
	 */
	public function detailsValuesProvider()
	{
		// Not implement yet
	}

	/**
	 * Function provide request to test option_definitions value in response of get_quotes resource
	 * 
	 * @return Array
	 */
	public function optionDefinitionsValuesProvider()
	{
		// Not implement yet
	}

	/**
	 * Function provide request to test options value in response of get_quotes resource
	 * 
	 * @return Array
	 */
	public function optionValuesValuesProvider()
	{
		// Not implement yet
	}

	/**
     * Test resource for valid schema of response
     * 
     * @dataProvider allRequestsProvider
     * @return void
     */
	public function testResponseSchema($expectedHttpCode, $request)
	{
		$httpMethod = 'POST';
		$path = '/travel/v2/quotes?customer_id=e4913f9229914b9a846f44a7ef1db6ba';

		$response = $this->call($httpMethod, $path, [], [], [], ['CONTENT_TYPE' => 'application/json'], (is_null($request) ? null : json_encode($request)));
		$responseBody = json_decode($response->getContent());
		$httpCode = $responseBody->status;

		$this->assertResponseBodyMatch($responseBody->data, self::$schemaManager, $path, $httpMethod, $httpCode);
	}

    /**
     * Test resource for response code 400 (schema validation fail)
     * 
     * @dataProvider requestForResponseCode400Provider
     * @return void
     */
    public function testResponseCode400($expectedHttpCode, $request)
    {
    	$httpMethod = 'POST';
    	$path = '/travel/v2/quotes?customer_id=e4913f9229914b9a846f44a7ef1db6ba';

    	$response = $this->call($httpMethod, $path, [], [], [], ['CONTENT_TYPE' => 'application/json'], (is_null($request) ? null : json_encode($request)));
    	$responseBody = json_decode($response->getContent());
		$httpCode = $responseBody->status;

    	$this->assertEquals($expectedHttpCode, $httpCode);
    }

    /**
     * Test resource for response code 422 (laravel/bussiness validation fail)
     * 
     * @dataProvider requestForResponseCode422Provider
     * @return void
     */
    public function testResponseCode422($expectedHttpCode, $request)
    {
    	$httpMethod = 'POST';
    	$path = '/travel/v2/quotes?customer_id=e4913f9229914b9a846f44a7ef1db6ba';

    	$response = $this->call($httpMethod, $path, [], [], [], ['CONTENT_TYPE' => 'application/json'], (is_null($request) ? null : json_encode($request)));
    	$responseBody = json_decode($response->getContent());
    	$httpCode = $responseBody->status;

    	$this->assertEquals($expectedHttpCode, $httpCode);
    }

    /**
     * Test resource for response code 200 (without any fails)
     * 
     * @dataProvider requestForResponseCode200Provider
     * @return void
     */
    public function testResponseCode200($expectedHttpCode, $request)
    {
    	$httpMethod = 'POST';
    	$path = '/travel/v2/quotes?customer_id=e4913f9229914b9a846f44a7ef1db6ba';

    	$response = $this->call($httpMethod, $path, [], [], [], ['CONTENT_TYPE' => 'application/json'], (is_null($request) ? null : json_encode($request)));
    	$responseBody = json_decode($response->getContent());
    	$httpCode = $responseBody->status;

    	$this->assertEquals($expectedHttpCode, $httpCode);
    }
}