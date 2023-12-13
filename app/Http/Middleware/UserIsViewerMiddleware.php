<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class UserIsViewerMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (\Auth::user()->isViewer() || \Auth::user()->isRoot() || \Auth::user()->isAdmin()) return $next($request);
        else {
            alert_error('Vous n\'êtes pas autorisé à accéder à cette partie de l\'application');
            return redirect()->back();
        }

    }
}
