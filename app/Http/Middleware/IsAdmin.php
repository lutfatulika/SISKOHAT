<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsAdmin
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if (!$user) {
            return response()->json([
                'message' => 'Unauthenticated',
            ], 401);
        }

        // Cek role, bukan email
        if ($user->role !== 'admin') {
            return response()->json([
                'message' => 'Forbidden: only admin can access this area.',
            ], 403);
        }

        return $next($request);
    }
}