<?php

namespace App\Exceptions;

use http\Exception\BadMethodCallException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

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
        $this->renderable(function (NotFoundHttpException $e, $request) {
            if ($request->is('api/*')) {
                return response()->json([
                    'message' => 'Record not found.',
                    'success' => false,
                    'code' => 404
                ], 404);
            }
        });

        $this->renderable(function (BadMethodCallException $e, $request) {
            if ($request->is('api/*')) {
                return response()->json([
                    'message' => 'Bad Method Call.',
                    'success' => false,
                    'code' => 404
                ], 404);
            }
        });
        $this->renderable(function (MethodNotAllowedHttpException $e, $request) {
            if ($request->is('api/*')) {
                return response()->json([
                    'message' => 'Method Not Allowed.',
                    'success' => false,
                    'code' => 405
                ], 405);
            }
        });
        $this->reportable(function (Throwable $e) {
            //
        });
    }
}
