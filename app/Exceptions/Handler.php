<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Validation\ValidationException;
use Illuminate\Validation\Validator;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Laravel\Lumen\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpFoundation\Response as Response;

class Handler extends ExceptionHandler
{

    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        // AuthorizationException::class,
        HttpException::class,
        // ModelNotFoundException::class,
        ValidationException::class,
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception  $e
     * @return void
     */
    public function report(Exception $e)
    {
        if (app()->runningInConsole()) {
            app('ScheduleTaskLogger')->error('ERROR: ' . $e->getMessage());
            app('ScheduleTaskLogger')->error($e);
        }

        if ($e instanceof ValidationException || $e instanceof HttpException) {
            app('log')->notice($e);
        } else {
            return parent::report($e);
        }
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $e
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $e)
    {
        if (env('APP_DEBUG', false)) {
            return parent::render($request, $e);
        }

        if ($e instanceof ValidationException) {
            if ($e->validator instanceof Validator) {
                $response = $e->validator->errors();              
            } else {
                $response = $e->validator;
            }
            return response($response, Response::HTTP_UNPROCESSABLE_ENTITY);
        } elseif ($e instanceof HttpException) {
            return response(json_decode($e->getMessage()) ? : $e->getMessage(), $e->getStatusCode());
        } else {
            return response(null, Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
