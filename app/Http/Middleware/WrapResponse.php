<?php

namespace App\Http\Middleware;

use Closure;

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

        return $response;
    }
}
