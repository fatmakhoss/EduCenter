<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (!$request->user() || strtolower($request->user()->role) !== 'admin') {
            return response()->json(['message' => 'Accès non autorisé'], 403);
        }

        return $next($request);
    }
} 