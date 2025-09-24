<?php

use App\Http\Middleware\RedirectAuthenticated;
use App\Models\MaintenanceMode;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Barryvdh\DomPDF\ServiceProvider;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\ServiceUnavailableHttpException;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Exceptions\ThrottleRequestsException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        // Middleware aliases
        $middleware->alias([
            'redirect.authenticated' => RedirectAuthenticated::class,
            'maintenance.mode' => \App\Http\Middleware\MaintenanceMode::class,
        ]);
    })
    ->withProviders([
        ServiceProvider::class,
    ])
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->renderable(function (Throwable $e) {
            // Default values
            $code = null;
            $title = null;
            $message = null;
            $maintenance_end = null;
            $data = ['exception' => $e];

            // Handle 400 Bad Request
            if ($e instanceof BadRequestHttpException) {
                $code = 400;
                $title = 'Bad Request';
                $message = 'The request could not be understood due to malformed syntax or invalid parameters.';
            }
            // Handle 401 Unauthorized
            elseif ($e instanceof AuthenticationException) {
                $code = 401;
                $title = 'Unauthorized Access';
                $message = 'You need to be authenticated to access this resource. Please log in to continue.';
            }
            // Handle 403 Forbidden
            elseif ($e instanceof AccessDeniedHttpException) {
                $code = 403;
                $title = 'Access Forbidden';
                $message = 'You don\'t have permission to access this resource.';
            }
            // Handle 404 Not Found
            elseif ($e instanceof NotFoundHttpException || $e instanceof ModelNotFoundException) {
                $code = 404;
                $title = 'Page Not Found';
                $message = 'The page you\'re looking for seems to have vanished into the digital void.';
            }
            // Handle 419 Session Expired
            elseif ($e instanceof HttpException && $e->getStatusCode() === 419) {
                $code = 419;
                $title = 'Session Expired';
                $message = 'Your session has expired for security reasons. Please refresh the page and try again.';
            }
            // Handle 422 Unprocessable Entity
            elseif ($e instanceof ValidationException) {
                $code = 422;
                $title = 'Unprocessable Entity';
                $message = 'There were validation errors in your request.';
                $data['errors'] = $e->errors();
            }
            // Handle 429 Too Many Requests
            elseif ($e instanceof ThrottleRequestsException) {
                $code = 429;
                $title = 'Too Many Requests';
                $message = 'You have exceeded the request limit. Please try again in a moment.';
            }
            // Handle 503 Service Unavailable
            elseif ($e instanceof ServiceUnavailableHttpException) {
                $maintenance = MaintenanceMode::first();
                $code = 503;
                $title = 'Service Unavailable';
                $message = $maintenance ? ($maintenance->maintenance_message ?? 'The service is temporarily unavailable due to maintenance.') : 'The service is temporarily unavailable.';
                $maintenance_end = $maintenance && $maintenance->maintenance_end ? now()->diffInSeconds($maintenance->maintenance_end) : null;
            }
            // Handle 500 Internal Server Error
            elseif ($e instanceof Exception) {
                $code = 500;
                $title = 'Internal Server Error';
                $message = 'An unexpected error occurred. Our technical team has been notified.';
            }

            // Render the error view with consistent data
            return response()->view('errors.error', array_merge($data, [
                'code' => $code,
                'title' => $title,
                'message' => $message,
                'maintenance_end' => $maintenance_end
            ]), $code);
        });
    })
    ->create();
