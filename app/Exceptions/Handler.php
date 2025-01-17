<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
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
        $this->renderable(function (UnauthorizedException $unauthorized) {
            return response()->json([
                'message' => $unauthorized->getMessage(),
            ], 401);
        });
        $this->renderable(function (ForbiddenException $forbiddenException) {
            return response()->json([
                'message' => $forbiddenException->getMessage(),
            ], 403);
        });
        $this->renderable(function (NotFoundException $notFound) {
            return response()->json([
                'message' => $notFound->getMessage(),
            ], 404);
        });
        $this->renderable(function (ConflictExceptions $conflictException) {
            return response()->json([
                'message' => $conflictException->getMessage(),
            ], 409);
        });
    }
}
