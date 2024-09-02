<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\ValidateAdminPassword;
use App\Models\Provider;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function index()
    {
        return view('admin.home');
    }

    public function showNotifications()
    {
        $notifications = session()->get('notifications', []);
        return view('admin.notification', ['notifications' => $notifications]);
    }

    public function storeProvider(Request $request)
    {
        // Validate the input
        $request->validate([
            'provider_name' => 'required|string|max:255',
        ]);

        // Create a new provider
        Provider::create([
            'name' => $request->provider_name,
        ]);

        // Redirect back with a success message
        return redirect()->route('add-provider')->with('success', 'Provider added successfully!');
    }
    public function showAddProviderForm()
{
    return view('admin.add-provider');
}
public function createProvider()
    {
        $providers = Provider::all(); // Fetch all providers
        return view('admin.add-provider', compact('providers')); // Pass providers to the view
    }

  public function confirmAction(ValidateAdminPassword $request)
    {
        // The password has been validated
        // Proceed with the action
    }
    public function store(StoreUserRequest $request)
    {
        // The request is automatically validated by StoreUserRequest
    
        // Retrieve validated data
        $validated = $request->validated();
    
        // Check if admin password validation failed
        if ($request->has('admin_password') && !Hash::check($request->input('admin_password'), Auth::user()->password)) {
            return redirect()->back()->withErrors(['admin_password' => 'The admin password is incorrect.']);
        }
    
        // Create the user
        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => $validated['role'],
        ]);
    
        // Redirect or return response
        return redirect()->route('users.index')->with('success', 'User created successfully.');
    }
   
}    
