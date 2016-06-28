<?php

namespace App\Http\Middleware;

use Closure;
use Symfony\Component\HttpFoundation\Response as Response;

class WrapResponse
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        /* @var $response Response */        
        $response = $next($request);                
        
        $content = json_decode($response->getContent()) ?: $response->getContent();
        $response->setContent(['status' => $response->getStatusCode(), 'data' => $content]);
        $response->setStatusCode(Response::HTTP_OK);
        
        return $response;
    }
}
