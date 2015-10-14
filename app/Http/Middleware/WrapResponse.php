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
        $response = $next($request);

        $content = json_decode($response->getContent());
        $wrapped = json_encode(['status' => $response->getStatusCode(), 'data' => $content]);
        $response->setContent($wrapped);
        $response->setStatusCode(Response::HTTP_OK);

        return $response;
    }
}
