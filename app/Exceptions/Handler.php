<?php

namespace App\Exceptions;

use App\Traits\ApiResponser;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\ValidationException;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Laravel\Lumen\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Throwable;

// If you're using Guzzle for HTTP client calls
use GuzzleHttp\Exception\ClientException;

class Handler extends ExceptionHandler
{
    use ApiResponser;

    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        AuthorizationException::class,
        AuthenticationException::class,
        HttpException::class,
        ModelNotFoundException::class,
        ValidationException::class,
    ];

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
        // HTTP Exception (e.g., 404 Not Found)
        if ($exception instanceof HttpException) {
            $code = $exception->getStatusCode();
            $message = Response::$statusTexts[$code] ?? 'Unknown HTTP Error';
            return $this->errorResponse($message, $code);
        }

        // Model Not Found Exception
        if ($exception instanceof ModelNotFoundException) {
            $model = strtolower(class_basename($exception->getModel()));
            return $this->errorResponse(
                "Does not exist any instance of {$model} with the given ID",
                Response::HTTP_NOT_FOUND
            );
        }

        // Validation Exception
        if ($exception instanceof ValidationException) {
            $errors = $exception->validator->errors()->getMessages();
            return $this->errorResponse($errors, Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        // Authorization Exception
        if ($exception instanceof AuthorizationException) {
            return $this->errorResponse($exception->getMessage(), Response::HTTP_FORBIDDEN);
        }

        // Authentication Exception (Unauthorized Access)
        if ($exception instanceof AuthenticationException) {
            return $this->errorResponse($exception->getMessage(), Response::HTTP_UNAUTHORIZED);
        }

        // Guzzle ClientException (when calling external services)
        if ($exception instanceof ClientException) {
            $message = $exception->getResponse()->getBody()->getContents();
            $code = $exception->getCode();
            return $this->errorResponse($message, $code ?: Response::HTTP_BAD_REQUEST);
        }

        // Show full error in debug mode
        if (env('APP_DEBUG', false)) {
            return parent::render($request, $exception);
        }

        // Generic Internal Server Error
        return $this->errorResponse('Unexpected error. Try again later.', Response::HTTP_INTERNAL_SERVER_ERROR);
    }
}
