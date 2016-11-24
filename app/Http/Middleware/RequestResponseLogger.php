<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Exception\HttpResponseException;
use App\Flow;

class RequestResponseLogger
{
    private $flow;
    private $recentPathIndex;

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $requestBody = json_decode($request->getContent());
        $quoteId = null;
        $path = [];
        
        if (isset($requestBody->quote_id)) {
            $quoteId = $requestBody->quote_id;
        }
        
        if ($quoteId) {
            $this->flow = Flow::whereRaw(['quoteIds' => ['$in' => [$quoteId]]])->first();
        }
        
        if (!$this->flow) {
            $this->flow = new Flow();
            $this->flow->partnerCode = $request->input('customer_id');
            
            if ($quoteId) {
                $this->flow->quoteIds = [$quoteId];
            }
        }
        
        $path['request'] = $requestBody;
        $path['path'] = $request->getPathInfo();

        if ($request->has('request_id')) {
            $path['esbId'] = $request->input('request_id');
        }

        if (!is_array($this->flow->paths)) {
            $this->flow->paths = [];
        }
        
        $this->flow->paths = array_merge($this->flow->paths, [$path]);
        $this->flow->save();

        $this->recentPathIndex = max(array_keys($this->flow->paths));

        $request->attributes->add(['flow' => (string) $this->flow]);

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
        $responseBody = json_decode($response->getContent());
        
        if ($this->flow) {
            if (is_array($responseBody)) {
                $quotes = $responseBody;
            } elseif (is_object($responseBody) && property_exists($responseBody, 'data') && is_array($responseBody->data)) {
                $quotes = $responseBody->data;
            }

            foreach ($quotes as $quote) {
                if (property_exists($quote, 'quote_id')) {
                    $this->flow->quoteIds = array_merge($this->flow->quoteIds ?: [], [$quote->quote_id]);
                }
            }
            
            $path['response'] = $responseBody;
            $path['response_time'] = $this->getFormattedTime(microtime(true));
            $paths = $this->flow->paths;
            $paths[$this->recentPathIndex] = array_merge($paths[$this->recentPathIndex], $path);
            $this->flow->paths = $paths;
            
            $this->flow->save();
        }
    }

    private function getFormattedTime($timestamp)
    {
        return \DateTime::createFromFormat('U.u', sprintf("%.6F", $timestamp))->format("YmdHisu");
    }
}
