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
        $responseBody = json_decode($request->getContent());
        $path = $request->getPathInfo();

        if (env('APP_DEBUG', false)) {
            app('log')->debug("RequestValidate starting for path $path");
            app('log')->debug('RequestValidate Request content: ' . var_export($request->getContent(), true));
        }

        // Parametry GET nie są walidowane
        // $params = $request->input();
        $httpMethod = $request->getMethod();
        $httpCode = Response::HTTP_OK;

        // Use file:// for local files
        $uri = 'file://' . $apiDefinitionPath;
        $schemaManager = new RequestSchemaManager($uri);

        $responseSchema = $schemaManager->getResponseSchema($path, $httpMethod, $httpCode);

        $request->attributes->add(['requestSchema' => $responseSchema]);
        $validator = new Validator();
        $validator->check($responseBody, $responseSchema);

        if (!$validator->isValid()) {
            $errors = [];

            foreach ($validator->getErrors() as $error) {
                if (array_key_exists($error['property'], $errors)) {
                    $e = & $errors[$error['property']];
                } else {
                    $e = new $errorClass();
                    $e->setProperty($error['property']);
                    $e->setErrors([]);
                    $errors[] = & $e;
                }

                $e->setErrors(array_merge($e->getErrors(), [$error['message']]));
            }

            if (env('APP_DEBUG', false)) {
                app('log')->debug('RequestValidate validation error');
                app('log')->debug('RequestValidate Errors: ' . var_export($errors, true));
            }

            abort(Response::HTTP_BAD_REQUEST, json_encode($errors));
        }

        if (env('APP_DEBUG', false)) {
            app('log')->debug('RequestValidate success');
        }

        return $next($request);
    }
}
