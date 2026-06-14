<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  string  ...$roles
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        if (!$request->user()) {
            abort(401, 'Non authentifié.');
        }

        if (!$request->user()->is_active) {
            abort(403, 'Votre compte est désactivé.');
        }

        if (!in_array($request->user()->role, $roles)) {
            abort(403, 'Accès interdit. Rôle insuffisant.');
        }

        return $next($request);
    }
}
