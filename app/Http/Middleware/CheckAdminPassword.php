<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckAdminPassword
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        // Check if the password matches 'admin'
        if ($request->input('password') !== 'admin') {
            // Store an error message in the session
            $request->session()->put('password_error', 'Invalid password!');
            return redirect()->back();
        }

        return $next($request);
    }
}
