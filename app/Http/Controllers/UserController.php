<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

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

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password), // Use Hash::make for security
            'role' => $request->role,
        ]);

        return redirect()->route('manage-users')->with('success', 'User created successfully.');
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
        $request->validate([
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user->password = Hash::make($request->password); // Use Hash::make for security
        $user->save();

        return redirect()->route('admin.manage-users')->with('success', 'Password reset successfully.');
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

}
