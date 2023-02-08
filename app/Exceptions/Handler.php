<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    public function render($request, Throwable $exception)
    {


        if( method_exists($exception,'responseJson') )
        {
            return $exception->responseJson();
        }

        if($request->ajax() || $request->wantsJson())
        {
            // this part is from render function in Illuminate\Foundation\Exceptions\Handler.php
            // works well for json
            $exception = $this->prepareException($exception);

            // we prepare custom response for other situation such as modelnotfound
            $response = [];
            $response['error'] = [
                'message' => 'Error Found',
                'status_code' => 500,
                'error' => 'Ooops, something went wrong, please contact us.',
            ];

            // we look for assigned status code if there isn't we assign 500
            $statusCode = method_exists($exception, 'getStatusCode')
                            ? $exception->getStatusCode()
                            : 500;

            if(config('app.debug')) {
                $response['error']['error'] = $exception->getMessage();
                $response['error']['trace'] = convert_from_latin1_to_utf8_recursively($exception->getTrace());
                $response['error']['code'] = $exception->getCode();
                $response['error']['status_code'] = $statusCode;
            }

            return response()->json($response, $statusCode);
        }
        return parent::render($request, $exception);
    }

    /**
     * [unauthenticated description]
     * @param  [type]                                   $request   [description]
     * @param  \Illuminate\Auth\AuthenticationException $exception [description]
     * @return [type]                                              [description]
     */
    protected function unauthenticated($request, \Illuminate\Auth\AuthenticationException $exception)
    {
        throw new AuthenticationException(trans('auth.failed'));
    }
}
