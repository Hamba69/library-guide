<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RequireStudentOrLibrarian
{
    public function handle(Request $request, Closure $next): Response
    {
        // Must be logged in first
        if (!Auth::check()) {
            return redirect()->route('login')
                ->with('error', 'Please log in to browse resources.');
        }

        // Must have an allowed role
        $allowedRoles = ['student', 'librarian', 'admin'];
        if (!in_array(Auth::user()->role, $allowedRoles)) {
            Auth::logout();
            return redirect()->route('login')
                ->with('error', 'You do not have permission to access this area.');
        }

        return $next($request);
    }
}