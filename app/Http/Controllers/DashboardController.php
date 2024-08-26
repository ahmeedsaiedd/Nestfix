<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    // In DashboardController.php or the appropriate controller

public function index()
{
    // Fetch the data for the charts
    $ticketCount = Ticket::count();
    $inProgressTicketsCount = Ticket::where('status', 'in progress')->count();
    $solvedTicketsCount = Ticket::where('status', 'solved')->count();
    $activeTicketsCount = Ticket::where('status', 'open')->count();
    
    // Example data for pie chart
    $pieData = [
        'labels' => ['All Tickets', 'In Progress', 'Solved', 'Active'],
        'values' => [$ticketCount, $inProgressTicketsCount, $solvedTicketsCount, $activeTicketsCount]
    ];
    
    return view('dashboard', [
        'ticketCount' => $ticketCount,
        'inProgressTicketsCount' => $inProgressTicketsCount,
        'solvedTicketsCount' => $solvedTicketsCount,
        'activeTicketsCount' => $activeTicketsCount,
        'pieData' => $pieData
    ]);
}

}
