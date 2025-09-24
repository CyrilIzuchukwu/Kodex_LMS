<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\ServiceUnavailableHttpException;

/**
 * @method static where(string $string, int $int)
 * @method static first()
 */
class MaintenanceMode
{
    /**
     * Handle an incoming request.
     *
     * @param Closure(Request): (Response) $next
     */
    public function handle(Request $request, Closure $next)
    {
        // Check if maintenance mode is active
        if (\App\Models\MaintenanceMode::where('maintenance_mode', 1)->exists()) {
            // Allow admins to bypass maintenance mode
            if (Auth::check() && Auth::user()->role === 'admin') {
                return $next($request);
            }

            // Get maintenance mode details
            $maintenance = \App\Models\MaintenanceMode::first();
            $retryAfter = $maintenance->maintenance_end ? now()->diffInSeconds($maintenance->maintenance_end) : null;

            // Throw exception 503 with optional retry-after header
            throw new ServiceUnavailableHttpException($retryAfter, $maintenance->maintenance_message ?? 'The service is temporarily unavailable due to maintenance.');
        }

        return $next($request);
    }
}
