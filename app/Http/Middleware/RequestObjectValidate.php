<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Validation\ValidationException;

class RequestObjectValidate
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $errorClass)
    {
        $errors = [];
        $deserializedRequestObject = $request->attributes->get('deserializedRequestObject');
        $path = $request->getPathInfo();

        if (env('APP_DEBUG', false)) {
            app('log')->debug("RequestObjectValidate starting for path $path");
            app('log')->debug('RequestObjectValidate Request content: ' . var_export($deserializedRequestObject, true));
        }
        
        if (is_array($deserializedRequestObject)) {
            foreach ($deserializedRequestObject as $key => $deserialized) {
                if (is_subclass_of($deserialized, 'App\apiModels\ApiModel')) {
                    $errors = $deserialized->validate($key)->merge($errors);
                }
            }
        } else {
            $errors = $deserializedRequestObject->validate();
        }

        if ($errors->count()) {
            if (env('APP_DEBUG', false)) {
                app('log')->debug('RequestObjectValidate validation error');
                app('log')->debug('RequestObjectValidate Errors: ' . var_export($errors, true));
            }

            $wrapedErrors = [];

            foreach ($errors->messages() as $property => $messages) {
                $errorWrapper = new $errorClass();
                $errorWrapper->setProperty($property);
                $errorWrapper->setErrors($messages);
                $wrapedErrors[] = $errorWrapper;
            }

            throw new ValidationException($wrapedErrors);
        } else {
            if (env('APP_DEBUG', false)) {
                app('log')->debug('RequestValidate success');
            }
        }
        
        return $next($request);
    }
}
