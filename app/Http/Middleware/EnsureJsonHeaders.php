<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureJsonHeaders
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!($request->header('content-type') == 'application/json' ||
            $request->header('accept') == 'application/json')) {
            return response()->json([
                'message' => 'API requests must accept JSON & Content-Type must be application/json.',
            ], 406);
        }

        return $next($request);
    }
}
