<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    protected function redirectTo($request)
    {
        if (!$request->expectsJson()) {
            // Para llamadas web normales (por navegador), puedes devolver null o una redirección personalizada
            return response()->json(['message' => 'Unauthenticated.'], 401);
        }

        // Para peticiones JSON (como desde Next.js con fetch)
        abort(response()->json(['message' => 'Unauthenticated.'], 401));
    }
}
