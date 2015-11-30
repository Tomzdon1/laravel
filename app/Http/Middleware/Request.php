<?php

namespace App\Http\Middleware;

use Closure;

use App\apiModels\RequestSchemaManager;
use JsonSchema\Validator;
use Symfony\Component\HttpFoundation\Response as Response;

class Request
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $apiDefinitionPath, $errorClass)
    {

        
        return $next($request);
    }
}
