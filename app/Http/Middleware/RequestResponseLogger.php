<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Exception\HttpResponseException;

class RequestResponseLogger
{

    private $requestDate;
    private $requestBody;
    private $responseBody;
    private $requestLog = [];

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $this->requestDate = $this->getFormattedTime($request->server('REQUEST_TIME'));
        $requestBody = json_decode($request->getContent());

        if (isset($requestBody->quote_ref)) {
            $this->requestLog = app('db')->collection('quotes')->find(substr($requestBody->quote_ref, 0, 24));
        }

        if (empty($this->requestLog)) {
            $this->requestLog['partnerCode'] = $request->input('customer_id');
            $this->requestLog['startPath'] = $request->getPathInfo();

            $this->requestLog['_id'] = app('db')->collection('quotes')->insertGetId($this->requestLog);
        }

        if ($request->has('request_id')) {
            $this->requestLog[$request->getPathInfo()][$this->requestDate]['esb_id'] = $request->input('request_id');
        }

        $this->requestLog[$request->getPathInfo()][$this->requestDate]['request'] = $requestBody;


        app('db')->collection('quotes')->where('_id', $this->requestLog['_id'])->update($this->requestLog);

        $request->attributes->add(['requestId' => (string) $this->requestLog['_id']]);

        return $next($request);
    }

    /**
     * Execute after the response has been sent to the browser.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Illuminate\Http\Response  $response
     * @return mixed
     */
    public function terminate($request, $response)
    {
        $this->responseBody = json_decode($response->getContent());

        $this->requestLog[$request->getPathInfo()][$this->requestDate]['response_time']
            = $this->getFormattedTime(microtime(true));
        $this->requestLog[$request->getPathInfo()][$this->requestDate]['response'] = $this->responseBody;

        try {
            app('db')->collection('quotes')->where('_id', $this->requestLog['_id'])->update($this->requestLog);
        } catch (\Exception $e) {
            app('log')->error('Can not log response to database');
        }
    }

    private function getFormattedTime($timestamp)
    {
        return \DateTime::createFromFormat('U.u', sprintf("%.6F", $timestamp))->format("YmdHisu");
    }
}
