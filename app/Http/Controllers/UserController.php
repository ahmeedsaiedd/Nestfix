<?php

namespace App\Http\Controllers;

use App\Mail\UserCreated;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\URL;

class UserController extends Controller
{
    // Display the form to create a new user
    public function create()
    {
        return view('admin.create-user'); // Returns the view for creating a new user
    }

    // Handle the creation of a new user
    public function store(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email',
        'password' => 'required|string|min:8|confirmed',
        'role' => 'required|in:admin,moderator,operator', // Updated validation rule
    ]);

    // Create the user
    $user = User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make($request->password),
        'role' => $request->role,
    ]);

    // Generate a password reset token
    $token = Password::createToken($user);

    // Generate a temporary signed URL for password reset
    $resetUrl = URL::temporarySignedRoute(
        'password.reset',
        now()->addMinutes(60),
        ['token' => $token, 'email' => $user->email]
    );

    // Send the password reset email with the reset URL
    Mail::to($user->email)->send(new UserCreated($user, $resetUrl));

    return redirect()->back()->with('success', 'User created and password reset email sent.');
}


    // Display the list of users for management
    public function manage()
    {
        $users = User::all();
        return view('admin.manage-users', compact('users')); // Returns the view for managing users
    }

    // Change the role of a user
    public function changeRole(Request $request, User $user)
    {
        $request->validate([
            'role' => 'required|in:admin,moderator,operator', // Updated validation rule
        ]);

        $user->role = $request->role;
        $user->save();

        return redirect()->route('manage-users')->with('success', 'User role updated successfully.');
    }

    // Delete a user
    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('manage-users')->with('success', 'User deleted successfully.');
    }

    // Display the form to reset a user's password
    public function showResetPasswordForm(User $user)
    {
        return view('admin.reset-password', compact('user'));
    }

    // Handle the password reset
    public function resetPassword(Request $request, User $user)
    {
        // Validate to ensure no other input is required
        $request->validate([
            'password' => 'required|string|min:8|confirmed', // This validation might be redundant as the password is fixed
        ]);

        // Set the password to '12345678'
        $user->password = Hash::make('12345678');
        $user->save();

        return redirect()->route('admin.manage-users')->with('success', 'Password reset successfully.');
    }
    public function updatePassword(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'password' => 'required|confirmed|min:8',
        ]);

        $user = User::find($request->user_id);
        $user->password = bcrypt($request->password);
        $user->save();

        return redirect()->back()->with('status', 'Password updated successfully.');
    }



    public function index(Request $request)
    {
        $query = User::query();

        // Apply search filter
        if ($request->has('search') && $request->search) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        // Apply role filter
        if ($request->has('role') && $request->role) {
            $query->where('role', $request->role);
        }

        // Get users with pagination (or use get() if you don't want pagination)
        $users = $query->paginate(10);

        return view('admin.manage-users', compact('users'));
    }
    public function addCategory()
    {
        // Your code to handle the request
        return view('admin.add-category'); // Adjust as needed
    }
    public function showResetForm(Request $request, $token = null)
    {
        // Pass the token and email to the view
        return view('auth.reset-password', [
            'token' => $token,
            'email' => $request->email, // Ensure email is available for the view
        ]);
    }
}    
