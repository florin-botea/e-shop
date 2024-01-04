<?php

namespace App\Exceptions;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\ValidationException;
use Laravel\Lumen\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Throwable;
use Illuminate\Support\Facades\Session;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        AuthorizationException::class,
        HttpException::class,
        ModelNotFoundException::class,
        ValidationException::class,
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Throwable  $exception
     * @return void
     *
     * @throws \Exception
     */
    public function report(Throwable $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Throwable  $exception
     * @return \Illuminate\Http\Response|\Illuminate\Http\JsonResponse
     *
     * @throws \Throwable
     */
    public function render($request, Throwable $exception)
    {
        //dd(get_class_methods($exception->validator), $exception->validator->errors()->first());
        //throw ($exception);
        if ($exception instanceof \Illuminate\Validation\ValidationException) {
            if ($request->wantsJson()) {
                return response($exception->validator->errors(), 423);
            }

            return redirect()
            ->to($_SERVER['HTTP_REFERER'])
            ->withErrors($exception->validator->errors());
        }
        
        if ($exception instanceof \LumenCart\Exceptions\ConfirmationRequired) {
            $data = $request->all();
            $data['_confirmation_required'] = [
                'message' => $exception->getMessage(),
                'flag' => '_confirm'
            ];
            
            return response($data);
        }
        
        return parent::render($request, $exception);
    }
}
