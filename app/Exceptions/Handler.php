<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\ValidationException;
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
    protected $dontFlash = ['password', 'password_confirmation'];

    /**
     * Report or log an exception.
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
     * Setup errors.
     *
     * @param  \Throwable  $exception
     * @return array
     */
    private static function setupErrors(Throwable $exception)
    {
        $methods = collect(get_class_methods($exception));

        $error = null;

        if ($methods->contains('getMessage')) {
            if (mb_detect_encoding($exception->getMessage()) !== 'UTF-8') {
                $error = utf8_encode($exception->getMessage());
            } else {
                $error = $exception->getMessage();
            }
        }

        return [$error];
    }

    /**
     * Return errors.
     *
     * @param  array  $errors
     * @param  int  $httpCode  500
     * @return \Illuminate\Http\JsonResponse
     */
    private static function returnErrors($errors, $httpCode = 400)
    {
        return response()->json(
            [
                'errors' => $errors
            ],
            $httpCode
        );
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
        if ($this->isHttpException($exception)) {
            switch ($exception->getStatusCode()) {
                case 401:
                    $error = __('messages.routes.error.401');
                    break;
                case 403:
                    $error = __('messages.routes.error.403');
                    break;
                case 404:
                    $error = __('messages.routes.error.404');
                    break;
                case 405:
                    $error = __('messages.routes.error.405');
                    break;
                case 419:
                    $error = __('messages.routes.error.419');
                    break;
                case 429:
                    $error = __('messages.routes.error.429');
                    break;
                case 500:
                    $error = __('messages.routes.error.500');
                    break;
                case 503:
                    $error = __('messages.routes.error.503');
                    break;
                default:
                    $error = __('messages.routes.error.other_code', [
                        'code' => $exception->getStatusCode()
                    ]);
                    break;
            }

            return self::returnErrors([$error], $exception->getStatusCode());
        }

        if ($exception instanceof ValidationException) {
            return self::returnErrors(
                collect($exception->errors())
                    ->flatten()
                    ->toArray(),
                400
            );
        }

        if (config('app.env') == 'production') {
            $erros = [$exception->getMessage()];
        } else {
            $erros = self::setupErrors($exception);
        }

        return self::returnErrors($erros);
    }
}
