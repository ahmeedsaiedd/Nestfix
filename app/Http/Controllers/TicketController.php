<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Ticket;
use App\Models\TicketAttachment;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class TicketController extends Controller
{
    public function create()
    {
        return view('admin.add-ticket');
    }

    public function all()
    {
        return view('admin.all-tickets');
    }

    public function active()
    {
        // Fetch all tickets where status is not 'closed'
        $tickets = Ticket::where('status', '<>', 'closed')->get();

        // Pass tickets to the view
        return view('admin.active-tickets', compact('tickets'));
    }

    public function store(Request $request)
    {
        // Validate the request
        $request->validate([
            'trace_id' => 'required|string',
            'provider_name' => 'required|string',
            'issue_category' => 'required|string',
            'issue_description' => 'required|string',
            'assigned_to' => 'required|string',
            'status' => 'nullable|string',
            'priority' => 'nullable|string',
            'attachments' => 'nullable|array',
            // 'attachments.*' => 'file|mimes:jpg,jpeg,png,pdf|max:2048',
            'attachments.*' => 'file|mimes:jpg,jpeg,png,pdf|max:2048',
            'new_category' => 'nullable|string'
        ]);

        // Handle file uploads
        $attachments = [];
        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $file) {
                $path = $file->store('attachments', 'public');
                $attachments[] = $path;
            }
        }


        // Create a new ticket
        Ticket::create([
            'trace_id' => $request->trace_id,
            'provider_name' => $request->provider_name,
            'issue_category' => $request->issue_category,
            'issue_description' => $request->issue_description,
            'assigned_to' => $request->assigned_to,
            'status' => $request->status ?? 'open',
            'priority' => $request->priority ?? 'medium',
            'attachments' => !empty($attachments) ? json_encode($attachments) : null
        ]);

        return redirect()->back()->with('success', 'Ticket created successfully!');
    }



    public function index(Request $request)
    {
        $query = Ticket::query();

        if ($request->filled('trace_id')) {
            $query->where('trace_id', 'like', '%' . $request->input('trace_id') . '%');
        }

        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        if ($request->filled('sort')) {
            $sort = $request->input('sort') === 'newest' ? 'desc' : 'asc';
            $query->orderBy('created_at', $sort);
        }

        $tickets = $query->paginate(15);

        return view('admin.all-tickets', compact('tickets'));
    }

    public function updateStatus(Request $request)
{
    try {
        $request->validate([
            'ticket_id' => 'required|exists:tickets,id',
            'status' => 'required|in:open,in progress,solved,done,closed',
            'comment' => 'nullable|string'
        ]);

        // Find the ticket
        $ticket = Ticket::find($request->ticket_id);
        if (!$ticket) {
            return response()->json(['message' => 'Ticket not found'], 404);
        }

        // Store the previous status for logging purposes
        $previousStatus = $ticket->status;

        // Update the ticket's status and comment
        $ticket->status = $request->status;
        $ticket->comment = $request->comment;

        // Set closed_at if the status is "closed"
        if ($request->status === 'closed') {
            $ticket->closed_at = now();
        } else {
            $ticket->closed_at = null;
        }

        // Save the ticket
        $ticket->save();

        // Log the status change notification
        $notification = [
            'message' => auth()->user()->name . ' changed the status from ' . $previousStatus . ' to ' . $ticket->status,
            'type' => 'status_change',
            'user' => auth()->user()->name,
            'ticket_id' => $ticket->id,
            'created_at' => now()
        ];
        session()->push('notifications', $notification);
        session()->put('notifications', [
    [
        'message' => 'Test notification message',
        'type' => 'status_change',
        'user' => 'Test User',
        'ticket_id' => 1,
        'created_at' => now()
    ]
]);


        return response()->json(['message' => 'Status updated successfully']);
    } catch (\Exception $e) {
        return response()->json(['message' => 'Server error', 'error' => $e->getMessage()], 500);

            return response()->json(['message' => 'Status updated successfully']);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Server error', 'error' => $e->getMessage()], 500);
        }
    }





    public function up()
    {
        Schema::table('tickets', function (Blueprint $table) {
            $table->timestamp('closed_at')->nullable()->after('status');
        });
    }

    public function down()
    {
        Schema::table('tickets', function (Blueprint $table) {
            $table->dropColumn('closed_at');
        });
    }
    public function update(Request $request, $id)
    {
        // Validate incoming request
        $request->validate([
            'status' => 'required|string',
            'assigned_to' => 'nullable|string', // Validation rule for assignee
            'priority' => 'nullable|string', // Validation rule for priority
            'comment' => 'nullable|string',
        ]);


        // Find the ticket by ID
        $ticket = Ticket::find($id);
        if (!$ticket) {
            return redirect()->back()->withErrors('Ticket not found');
        }

        // Update the ticket with new data
        $ticket->status = $request->input('status');
        $ticket->assigned_to = $request->input('assigned_to'); // Update the assigned_to field
        $ticket->comment = $request->input('comment');

        // Optionally update closed_at based on status
        if ($request->input('status') === 'closed' && !$ticket->closed_at) {
            $ticket->closed_at = now(); // Set to current date/time
        }

        $ticket->save();

        // Redirect or return a response
        return redirect()->route('all-tickets')->with('success', 'Ticket updated successfully');
    }
    public function dashboard()
    {
        // Get the total number of tickets
        $ticketCount = Ticket::count();

        // Get the total number of solved tickets
        $solvedTicketsCount = Ticket::where('status', 'closed')->count();

        // Get the total number of active tickets
        $activeTicketsCount = Ticket::where('status', '<>', 'closed')->count();

        // Get the total number of tickets with 'in progress' status
        $inProgressTicketsCount = Ticket::where('status', 'in progress')->count();

        // Pass counts to the view
        return view('admin.home', [
            'ticketCount' => $ticketCount,
            'solvedTicketsCount' => $solvedTicketsCount,
            'activeTicketsCount' => $activeTicketsCount,
            'inProgressTicketsCount' => $inProgressTicketsCount,
        ]);
    }
}
