<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception  $exception
     * @return void
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $exception)
    {
        $e = $this->prepareException($exception);
        if ($e instanceof ModelNotFoundException) {
            return $this->notFound($request, $e);
        }

        if ($e instanceof NotFoundHttpException){
            return $this->notFoundEndpoint($request, $e);
        }

        if ($e instanceof QueryException){
            return $this->invalidParameters($request, $e);
        }
        return parent::render($request, $exception);
    }

    /**
     * Convert an not found exception into an not found response.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Symfony\Component\HttpKernel\Exception\NotFoundHttpException $exception
     * @return \Illuminate\Http\Response
     */
    protected function notFound($request, NotFoundHttpException $exception)
    {
        return response()->json(['error' => ['message' => 'Not Found.']], 404);
    }

    protected function notFoundEndpoint($request, NotFoundHttpException $exception)
    {
        return response()->json(['error' => ['message' => 'Wrong endpoint.']], 404);
}

    private function invalidParameters($request, $e)
    {
        return response()->json(['error' => ['message' => 'Invalid parameters']], 422);
    }
}
