<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ModeratorController extends Controller
{
    public function index()
    {
        return view('moderator.home'); // Ensure this view file exists
    }
}

