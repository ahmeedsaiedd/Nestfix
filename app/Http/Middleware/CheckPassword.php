<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckPassword
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // Check if the user is already authenticated
        if (Auth::check()) {
            return $next($request);
        }

        // If not authenticated, prompt for password
        if ($request->isMethod('post')) {
            $password = $request->input('password');

            if ($password === env('ACCESS_PASSWORD')) {
                // Store password in session to validate future requests
                session(['password_authenticated' => true]);
                return redirect()->intended($request->path());
            }

            return redirect()->back()->withErrors(['password' => 'Incorrect password']);
        }

        if (!session('password_authenticated')) {
            return response()->view('auth.password', ['url' => route('create-user')]);
        }

        return $next($request);
    }
}
