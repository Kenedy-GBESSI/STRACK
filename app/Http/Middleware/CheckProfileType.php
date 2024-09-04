<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckProfileType
{
     /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  $profileType
     * @return mixed
     */
    public function handle(Request $request, Closure $next, string $profileType)
    {
        $user = $request->user();

        // Vérifier si l'utilisateur est authentifié et si le type de profil correspond
        if ($user && $user->profile_type === $profileType) {
            return $next($request);
        }

        abort(401, 'Not available for this user\'s type');
    }
}
