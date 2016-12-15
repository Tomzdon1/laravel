<?php

namespace App\Http\Middleware;

use Closure;
use Symfony\Component\HttpFoundation\Response as Response;

class WrapResponseForESB
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
        if (env('APP_DEBUG', false)) {
            app('log')->debug("WrapResponseForESB starting for path " . $request->getPathInfo());
        }

        /* @var $response Response */
        $response = $next($request);
        
        if (!($response->exception && env('APP_DEBUG', false))) {
            $content = json_decode($response->getContent()) ?: $response->getContent();
            $response->setContent(['status' => $response->getStatusCode(), 'data' => $content]);
            $response->setStatusCode(Response::HTTP_OK);
        }

        if (env('APP_DEBUG', false)) {
            app('log')->debug('WrapResponseForESB success');
        }
        
        return $response;
    }
}
