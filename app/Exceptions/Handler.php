<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Validation\ValidationException;
use Laravel\Lumen\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpFoundation\Response as Response;
use Symfony\Component\HttpFoundation\Request as Request;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
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
        if(app()->runningInConsole()) {
            app('ScheduleTaskLogger')->error('ERROR: ' . $e->getMessage());
            app('ScheduleTaskLogger')->error($e);
        }

        if ($e instanceof ValidationException) {
            app('log')->error('exception caused by request (esb_id: '
                .app('request')->input('request_id') . ') content: '. app('request')->getcontent());
        }

        return parent::report($e);
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

        if ($e instanceof HttpExceptionInterface) {
            return response(json_decode($e->getMessage()) ?: $e->getMessage(), $e->getStatusCode());
        } else {
            return response(null, Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
