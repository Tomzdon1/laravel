<?php

namespace App\Http\Middleware;

use Closure;

use App\apiModels\RequestSchemaManager;
use JsonSchema\Validator;
use Symfony\Component\HttpFoundation\Response as Response;

class RequestValidate
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
        \Log::debug('RequestValidate starting');

        $responseBody = json_decode($request->input('data'));

        $path = $request->getPathInfo();
        // Parametry GET nie są walidowane
        // $params = $request->input();
        $httpMethod = $request->getMethod();
        $httpCode = Response::HTTP_OK;

        // Use file:// for local files
        $uri = 'file://' . $apiDefinitionPath;
        $schemaManager = new RequestSchemaManager($uri);

        $responseSchema = $schemaManager->getResponseSchema($path, $httpMethod, $httpCode);
        
        $validator = new Validator();
        $validator->check($responseBody, $responseSchema);                
        
        if (!$validator->isValid()) {
            \Log::debug('RequestValidate validation error');

            $errors = [];
            
            foreach ($validator->getErrors() as $error) {
                if (array_key_exists($error['property'], $errors)) {
                    $e =& $errors[$error['property']];
                }
                else {
                    $e = new $errorClass();
                    $e->setProperty($error['property']);
                    $e->setErrors([]);
                    $errors[] =& $e;
                }

                $e->setErrors(array_merge($e->getErrors(), [$error['message']]));
            }

            return response(array_values($errors), Response::HTTP_BAD_REQUEST);
        }
        
        \Log::debug('RequestValidate success');

        return $next($request);
    }
}
