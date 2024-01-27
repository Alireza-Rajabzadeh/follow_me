<?php

namespace App\Exceptions;

use Exception;
use Throwable;
use Illuminate\Validation\ValidationException;
use PHPUnit\Event\Code\Throwable as CodeThrowable;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            // dd($e);
        });
    }


    public function render($request, Throwable $exception)
    {

        // dd($exception);
        if ($exception instanceof ValidationException) {

            return apiResponse(false, [], $exception->getMessage(), 422);
        }

        $message = $exception->getMessage() ?? __('messages.error');
        $code = $exception->getCode() ?? 500;

        if ($code == 1) {
            $code = 500;
        }
        
        return apiResponse(false, [], $message, $code);
        // return parent::render($request, $exception);
    }
}
