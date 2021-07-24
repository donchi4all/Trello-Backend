<?php

namespace App\Exceptions;

use GuzzleHttp\Exception\RequestException;
use Illuminate\Database\Eloquent\MassAssignmentException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Validation\UnauthorizedException;
use Laravel\Passport\Exceptions\OAuthServerException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

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
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        $this->reportable(function ( Throwable $e) {


        });
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Throwable  $exception
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \Throwable
     */
    public function render($request, Throwable $exception)
    {
       // return parent::render($request, $exception);
        return $this->handleException($request, $exception);
    }
    private function handleException($request, Throwable $exception)
    {
        if ($exception instanceof ConnectionException){
            return error($exception->getMessage(), 500);
        }
        if ($exception instanceof RequestException){
            return badRequest($exception->getMessage(), 400);
        }
        // TODO: try to inlcude the name of model
        if($exception instanceof ModelNotFoundException){
            $modelName = explode( "\\", $exception->getModel() );
            return notFound(" Requested " . end( $modelName ) ." was not found");
        }
        if($exception instanceof MassAssignmentException){
            return unAuthorized('You are trying to fill an unfillable property. I am watching you!');
        }
        if($exception instanceof UnauthorizedException){
            return unAuthorized($exception->getMessage());
        }
        if($exception instanceof QueryException){
            return error('A query exception occurred', 500);
        }
        if($exception instanceof OAuthServerException){
            return error('Invalid login credential', 401);
        }
        if($exception instanceof MethodNotAllowedHttpException){
            return error('Http method used is not valid for requested resource', 404);
        }
        if($exception instanceof NotFoundHttpException){
            return error('Not found', 404);
        }
        if($exception instanceof \InvalidArgumentException){
            return error($exception->getMessage(), 400);
        }
        if($exception instanceof \TypeError){
            return error($exception->getMessage(), 400);
        }
        if($exception instanceof \Error){
            return error($exception->getMessage(), 500);
        }
        if($exception instanceof \ErrorException){
            return error($exception->getMessage(), 500);
        }
        if($exception instanceof \UnexpectedValueException){
            return error($exception->getMessage(), 500);
        }

        if($exception instanceof \Symfony\Component\ErrorHandler\Error\FatalError){
            return error($exception->getMessage(), 400);
        }

        // TODO: also handle this one properly
        return parent::render($request, $exception);
    }
}
