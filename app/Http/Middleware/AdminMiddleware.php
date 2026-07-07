<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (! $request->user()) {
            return redirect()->route('login');
        }

        if (! $request->user()->isAdmin()) {
            return redirect()->route('home')->with('error', 'You do not have access to the admin dashboard.');
        }

        return $next($request);
    }
}
