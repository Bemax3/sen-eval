<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class UserIsAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response) $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (\Auth::user()->isAdmin() || \Auth::user()->isRoot()) return $next($request);
        else {
            alert_error('Vous n\'êtes pas autorisé à accéder à cette partie de l\'application');
            return redirect()->back();
        }
    }
}
