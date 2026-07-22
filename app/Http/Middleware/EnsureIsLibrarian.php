<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureIsLibrarian
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check()) {
            return redirect()->route('login')
                ->with('error', 'Please log in to access the admin portal.');
        }

        if (!in_array(Auth::user()->role, ['librarian', 'admin'])) {
            // Student tried to access admin — boot them back to browse
            abort(403, 'Access denied. This area is for library staff only.');
        }

        return $next($request);
    }
}