<?php

namespace App\Http\Middleware;

use Closure;

use FR3D\SwaggerAssertions\SchemaManager;
use JsonSchema\Validator;
use FR3D\SwaggerAssertions\PhpUnit\ResponseBodyConstraint;

class RequestValidate
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

        return $next($request);
    }
}
