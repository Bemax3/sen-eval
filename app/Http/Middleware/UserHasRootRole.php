<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class UserHasRootRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if(\Auth::user()->isRoot() || \Auth::user()->isAdmin()) return $next($request);
        else {
            alert_error('Vous n\'êtes pas autorisé à accéder à cette partie de l\'application');
            return redirect()->back();
        }
    }
}
