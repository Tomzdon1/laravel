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
        app('log')->debug('RequestValidate starting');
        app('log')->debug('RequestValidate Request content: ' . var_export($request->getContent(), true));

        $responseBody = json_decode($request->getContent());

        $path = $request->getPathInfo();

        app('log')->debug("RequestValidate for path $path");
        
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
            app('log')->debug('RequestValidate validation error');

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

            app('log')->debug('RequestValidate Errors: ' . var_export($errors, true));

            return response(array_values($errors), Response::HTTP_BAD_REQUEST);
        }
        
        app('log')->debug('RequestValidate success');

        return $next($request);
    }
}
