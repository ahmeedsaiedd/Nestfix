<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

use App\Models\User;

class HomeController extends Controller
{
    public function redirect()
    {
        $role = Auth::user()->role;

        if ($role === 'admin') {
            return redirect()->route('admin.home');
        } elseif ($role === 'moderator') {
            return redirect()->route('admin.home');
        } elseif ($role === 'operator') {
            return redirect()->route('admin.home');
        } else {
            // Handle unknown roles or unauthenticated users
            return redirect()->route('login'); // Redirect to login or any other route
        }
    }
}
