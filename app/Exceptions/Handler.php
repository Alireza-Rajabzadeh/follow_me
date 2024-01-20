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

        if ($exception instanceof ValidationException) {

            return apiResponse(false, [], $exception->getMessage(), 422);
        }

        return apiResponse(false, [], $exception->getMessage() ?? __('messages.error'), $exception->getCode() ?? 500);
        // return parent::render($request, $exception);
    }
}
