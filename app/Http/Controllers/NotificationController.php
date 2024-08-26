<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\User;
use App\Notifications\UserFollowNotification;
use Illuminate\Support\Facades\Notification;

class UserController extends Controller
{
    public function dashboard()
{
    // Get tickets with a specific status (e.g., 'open')
    $tickets = Ticket::where('status', 'open')->get();

    // Pass tickets to the view
    return view('admin.notification', compact('tickets'));
}

    

    public function sendNotification()
    {
        // Retrieve the user to whom you want to send the notification
        $user = User::find(1);

        if ($user) {
            // Send the notification
            Notification::send($user, new UserFollowNotification($user));

            // Optionally, you might want to return a response or redirect
            return redirect()->back()->with('status', 'Notification sent successfully!');
        } else {
            return redirect()->back()->with('error', 'User not found.');
        }
        
    }
}
