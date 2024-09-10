<?php

namespace App\Http\Controllers;

use App\Mail\TicketCreated;
use App\Models\Category;
use App\Models\Provider;
use App\Models\Status;
use App\Models\Team;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Ticket;
use App\Models\TicketAttachment;
use App\Models\User;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;

class TicketController extends Controller
{


    public function showAddCategory()
    {
        return view('admin.add-category');
    }

    public function create()
    {
        // Fetch all required data
        $categories = Category::all(); // Fetch categories
        $teams = Team::all(); // Fetch teams
        $users = User::all(); // Fetch users
        $providers = Provider::all(); // Fetch providers

        $environments = ['Staging', 'Pre-production', 'Production', 'Add Provider'];

        // Render the 'add-ticket' view with the required data
        return view('admin.add-ticket', compact('categories', 'teams', 'providers', 'users', 'environments'));
    }





    public function all()
    {
        return view('admin.all-tickets');
    }

    // app/Http/Controllers/TicketController.php

    public function active(Request $request)
{
    // Initialize the query
    $query = Ticket::query();

    // Filter by Trace ID
    if ($request->filled('trace_id')) {
        $query->where('trace_id', 'like', '%' . $request->input('trace_id') . '%');
    }

    // Filter by Status
    if ($request->filled('status')) {
        $status = $request->input('status');
        $query->where('status', $status);
    }

    // Filter tickets that are not 'closed'
    $query->where('status', '<>', 'closed');

    // Order by the creation date from newest to oldest
    $query->orderBy('created_at', 'desc');

    // Paginate results, 10 per page
    $tickets = $query->paginate(10);

    // Fetch all teams
    $teams = Team::all();

    // Fetch all statuses
    $statuses = Status::all(); // Ensure Status model is correctly referenced

    // Pass tickets, teams, and statuses to the view
    return view('admin.active-tickets', compact('tickets', 'teams', 'statuses'));
}




    public function store(Request $request)
    {
        // Validate the incoming request
        $request->validate([
            'trace_id' => 'required|string',
            'provider_name' => 'required|string',
            'issue_category' => 'required|string',
            'issue_description' => 'required|string',
            'assigned_to' => 'nullable|string',
            'status' => 'nullable|string',
            'priority' => 'nullable|string|in:high,medium,low',
            'attachments' => 'nullable|array',
            'attachments.*' => 'file|mimes:jpg,jpeg,png,pdf,mp4,avi,doc,docx,xls,xlsx|max:51200', // Updated mime types and size limit
            'environment' => 'nullable|string|in:Staging,Pre-production,Production',
            'created_by' => 'nullable|exists:users,id',
            'comment' => 'nullable|string',
            'test' => 'nullable|string'
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
        $ticket = Ticket::create([
            'trace_id' => $request->trace_id,
            'provider_name' => $request->provider_name,
            'issue_category' => $request->issue_category,
            'issue_description' => $request->issue_description,
            'assigned_to' => $request->assigned_to,
            'status' => $request->status ?? 'open',
            'priority' => $request->priority ?? 'medium',
            'environment' => $request->environment,
            'comment' => $request->comment,
            'created_by' => $request->created_by ?? Auth::id(), // Use authenticated user ID if not provided
            'attachments' => !empty($attachments) ? json_encode($attachments) : null,
            'test' => $request->test
        ]);

        // Send email notification
        Mail::to('Wakty.ticketing@ebetech.com.eg')->send(new TicketCreated($ticket));

        return redirect()->back()->with('success', 'Ticket created successfully!');
    }



    // app/Http/Controllers/TicketController.php

    public function index(Request $request)
    {
        $query = Ticket::query();
        
        // Filter by Trace ID
        if ($request->filled('trace_id')) {
            $query->where('trace_id', 'like', '%' . $request->input('trace_id') . '%');
        }
        
        // Filter by Status
        if ($request->filled('status')) {
            $status = $request->input('status');
            $query->where('status', $status);
        }
        
        // Order by creation date from newest to oldest
        $query->orderBy('created_at', 'desc');
    
        // Handle exporting logic
        if ($request->has('export')) {
            // Apply the same filters for exporting
            $tickets = $query->get();
        
            // Handle case where there are no tickets to export
            if ($tickets->isEmpty()) {
                return redirect()->back()->with('error', 'No tickets to export.');
            }
        
            $headers = [
                "Content-Type" => "text/csv; charset=utf-8",
                "Content-Disposition" => "attachment; filename=filtered_tickets.csv",
                "Pragma" => "no-cache",
                "Cache-Control" => "private, max-age=0, must-revalidate",
            ];
        
            $callback = function () use ($tickets) {
                $handle = fopen('php://output', 'w');
                fwrite($handle, "\xEF\xBB\xBF"); // UTF-8 BOM
        
                // Add CSV headers
                fputcsv($handle, [
                    'Created By',
                    'Ticket ID',
                    'Trace ID',
                    'Provider Name',
                    'Issue Category',
                    'Issue Description',
                    'Assigned To',
                    'Priority',
                    'Status',
                    'Test',
                    'Environment',
                    'Comment',
                ]);
        
                // Add CSV data
                foreach ($tickets as $ticket) {
                    $formattedId = 'W-' . $ticket->created_at->format('Ymd') . '-' . str_pad($ticket->id, 3, '0', STR_PAD_LEFT);
        
                    fputcsv($handle, [
                        $ticket->creator->name ?? 'No user assigned',
                        $formattedId,
                        $ticket->trace_id,
                        $ticket->provider_name,
                        $ticket->issue_category,
                        $ticket->issue_description,
                        $ticket->assigned_to ?: 'No team assigned',
                        ucfirst($ticket->priority),
                        ucfirst($ticket->status),
                        !empty($ticket->test) ? ucfirst($ticket->test) : '----',
                        $ticket->environment,
                        $ticket->comment ?? 'No comment',
                    ]);
                }
        
                fclose($handle);
            };
        
            return response()->stream($callback, 200, $headers);
        }
        
        // Paginate results, 10 per page
        $tickets = $query->paginate(10);
        
        // Fetch all teams and statuses for filters
        $teams = Team::all();
        $statuses = Status::all();
        
        // Pass the current status filter to the view
        $currentStatus = $request->input('status');
        
        return view('admin.all-tickets', compact('tickets', 'teams', 'statuses', 'currentStatus'));
    }
    
    


public function activeTickets(Request $request)
{
    $query = Ticket::query();

    // Filter only active tickets (e.g., status is 'open')
    $query->where('status', 'open'); // Modify 'open' to whatever status you consider active

    // Filter by Trace ID if provided
    if ($request->filled('trace_id')) {
        $query->where('trace_id', 'like', '%' . $request->input('trace_id') . '%');
    }

    // Filter by Status if provided
    if ($request->filled('status')) {
        $status = $request->input('status');
        $query->where('status', $status);
    }

    // Order by creation date from newest to oldest
    $query->orderBy('created_at', 'desc');

    // Paginate results, 4 per page
    $tickets = $query->paginate(4);

    // Fetch all teams and statuses for filters
    $teams = Team::all();
    $statuses = Status::all();

    // Pass the current status filter to the view
    $currentStatus = $request->input('status');

    return view('admin.active-tickets', compact('tickets', 'teams', 'statuses', 'currentStatus'));
}





    public function notification()
    {
        // Fetch all statuses
        $statuses = Status::all(); // Ensure Status model is correctly referenced

        // Fetch tickets if needed
        $tickets = Ticket::all(); // Adjust as needed, e.g., filter or paginate

        // Fetch teams if needed
        $teams = Team::all(); // Ensure Team model is correctly referenced

        // Pass statuses, tickets, and teams to the view
        return view('admin.notification', compact('tickets', 'teams', 'statuses'));
    }



    public function show($id)
    {
        $ticket = Ticket::findOrFail($id);
        return response()->json($ticket);
    }



    public function updateStatus(Request $request)
    {
        try {
            // Validate the incoming request
            $request->validate([
                'ticket_id' => 'required|exists:tickets,id',
                'status' => 'required|in:open,in progress,solved,closed',
                'comment' => 'nullable|string',
                'priority' => 'nullable|in:high,medium,low' // Ensure priority is valid
            ]);

            // Find the ticket
            $ticket = Ticket::findOrFail($request->ticket_id);

            $previousStatus = $ticket->status;
            $previousPriority = $ticket->priority;

            // Update ticket status and comment
            $ticket->status = $request->status;
            $ticket->comment = $request->comment;

            // Update priority if provided
            if ($request->filled('priority')) {
                $ticket->priority = $request->priority;
            }

            // Handle closed and solved timestamps
            $ticket->closed_at = $request->status === 'closed' ? now() : null;
            $ticket->solved_at = $request->status === 'Solved' ? now() : null;

            // Save the updated ticket
            $ticket->save();

            // Create notifications for status and priority changes
            $this->createNotification('status_change', $previousStatus, $ticket->status, $ticket->id);

            if ($request->filled('priority') && $previousPriority !== $ticket->priority) {
                $this->createNotification('priority_change', $previousPriority, $ticket->priority, $ticket->id);
            }

            return response()->json(['message' => 'Status and priority updated successfully']);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Server error', 'error' => $e->getMessage()], 500);
        }
    }

    /**
     * Create a notification for the given change type.
     *
     * @param  string  $type
     * @param  string  $previousValue
     * @param  string  $newValue
     * @param  int  $ticketId
     * @return void
     */
    private function createNotification($type, $previousValue, $newValue, $ticketId)
    {
        $notification = [
            'message' => auth()->user()->name . " changed the $type from $previousValue to $newValue",
            'type' => $type,
            'user' => auth()->user()->name,
            'ticket_id' => $ticketId,
            'created_at' => now()
        ];
        session()->push('notifications', $notification);
    }









    public function up()
    {
        Schema::table('tickets', function (Blueprint $table) {
            $table->timestamp('closed_at')->nullable()->after('status');
            $table->timestamp('solved_at')->nullable()->after('closed_at');
        });
    }

    public function down()
    {
        Schema::table('tickets', function (Blueprint $table) {
            $table->dropColumn('solved_at');
            $table->dropColumn('closed_at');
        });
    }
    public function update(Request $request, $id)
    {
        // Validate the incoming request
        $request->validate([
            'status' => 'required|string',
            'assigned_to' => 'nullable|string',
            'priority' => 'nullable|string|in:high,medium,low',
            'comment' => 'nullable|string',
            'test' => 'nullable|string'
        ]);

        // Find the ticket
        $ticket = Ticket::find($id);

        if (!$ticket) {
            return redirect()->back()->withErrors('Ticket not found');
        }

        // Update ticket fields
        $ticket->status = $request->input('status');
        $ticket->assigned_to = $request->input('assigned_to');
        $ticket->priority = $request->has('priority') ? $request->input('priority') : null;
        $ticket->comment = $request->input('comment');
        $ticket->test = $request->input('test');

        // Handle solved timestamp
        $ticket->solved_at = $request->input('status') === 'Solved' ? now() : null;
        $ticket->closed_at = $request->input('status') === 'Closed' ? now() : null;

        // Save the updated ticket
        $ticket->save();

        return redirect()->route('active-tickets')->with('success', 'Ticket updated successfully');
    }

    public function destroy($id)
    {
        // Find the ticket by ID or fail if not found
        $ticket = Ticket::findOrFail($id);

        // Delete the ticket
        $ticket->delete();

        // Redirect back with a success message
        return redirect()->back()->with('success', 'Ticket deleted successfully.');
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

    public function download($filename)
    {
        $path = storage_path('app/public/attachments/' . $filename);

        if (!file_exists($path)) {
            abort(404);
        }

        return response()->download($path);
    }
    public function storeCategory(Request $request)
    {
        // Validate the request data
        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name',

        ]);

        // Create a new category
        Category::create([
            'name' => $request->input('name'),
        ]);
        $categories = Category::all();

        // Redirect back with a success message
        return view('admin.add-category', compact('categories'))
            ->with('success', 'Category added successfully!');

        // Redirect back with a success message
        return redirect()->back()->with('success', 'Category added successfully!');
    }
    public function downloadImage($trace_id)
    {
        // Retrieve the ticket
        $ticket = Ticket::where('trace_id', $trace_id)->firstOrFail();

        // Get the file path from the ticket (assuming image_path contains the path)
        $filePath = $ticket->image_path;

        // Ensure the file exists
        if (Storage::exists($filePath)) {
            // Get the file's MIME type
            $mimeType = Storage::mimeType($filePath);

            // Return the file as a download
            return Storage::download($filePath, basename($filePath), ['Content-Type' => $mimeType]);
        } else {
            // Redirect back with an error if the file doesn't exist
            return redirect()->back()->with('error', 'File not found.');
        }
    }
    public function createTeam()
    {
        $teams = Team::all(); // Fetch all teams
        return view('admin.add-team', compact('teams')); // Pass teams to the view

    }

    // Method to handle the form submission
    public function storeTeam(Request $request)
    {
        // Validate the request
        $request->validate([
            'name' => 'required|string|max:255|unique:teams,name',
        ]);

        // Create a new team
        Team::create([
            'name' => $request->input('name'),
        ]);

        // Redirect back with a success message
        return redirect()->back()->with('success', 'Team added successfully!');
    }
    public function showAddStatusForm()
    {
        $statuses = Status::all(); // Fetch all statuses
        return view('admin.add-status', compact('statuses')); // Pass statuses to the view
    }

    public function storeStatus(Request $request)
    {
        $request->validate([
            'status_name' => 'required|string|unique:statuses,name', // Add 'statuses' model and table for storing status names
        ]);
        // Create a new status
        Status::create([
            'name' => $request->status_name,
        ]);

        return redirect()->back()->with('success', 'Status added successfully!');
    }
    public function exportActiveTickets(Request $request)
    {
        $query = Ticket::query();
    
        // Exclude tickets with status 'closed'
        $query->where('status', '!=', 'closed');
    
        // Apply the status filter if provided
        if ($request->has('status') && $request->status !== '') {
            $query->where('status', $request->status);
        }
    
        $tickets = $query->get();
    
        // Handle case where there are no tickets to export
        if ($tickets->isEmpty()) {
            return redirect()->back()->with('error', 'No active tickets to export.');
        }
    
        $headers = [
            "Content-Type" => "text/csv; charset=utf-8",
            "Content-Disposition" => "attachment; filename=active_tickets.csv",
            "Pragma" => "no-cache",
            "Cache-Control" => "private, max-age=0, must-revalidate",
        ];
    
        $callback = function () use ($tickets) {
            $handle = fopen('php://output', 'w');
            fwrite($handle, "\xEF\xBB\xBF"); // UTF-8 BOM
    
            // Add CSV headers
            fputcsv($handle, [
                'Created By',
                'Ticket ID',
                'Trace ID',
                'Provider Name',
                'Issue Category',
                'Issue Description',
                'Assigned To',
                'Priority',
                'Status',
                'Test',
                'Environment',
                'Comment',
            ]);
    
            // Add CSV data
            foreach ($tickets as $ticket) {
                $formattedId = 'W-' . $ticket->created_at->format('Ymd') . '-' . str_pad($ticket->id, 3, '0', STR_PAD_LEFT);
    
                fputcsv($handle, [
                    $ticket->creator->name ?? 'No user assigned',
                    $formattedId,
                    $ticket->trace_id,
                    $ticket->provider_name,
                    $ticket->issue_category,
                    $ticket->issue_description,
                    $ticket->assigned_to ?: 'No team assigned',
                    ucfirst($ticket->priority),
                    ucfirst($ticket->status),
                    !empty($ticket->test) ? ucfirst($ticket->test) : '----',
                    $ticket->environment,
                    $ticket->comment ?? 'No comment',
                ]);
            }
    
            fclose($handle);
        };
    
        return response()->stream($callback, 200, $headers);
    }
    
public function exportAllTickets(Request $request)
{
    $query = Ticket::query();

    $tickets = $query->get();

    // Handle case where there are no tickets to export
    if ($tickets->isEmpty()) {
        return redirect()->back()->with('error', 'No tickets to export.');
    }

    $headers = [
        "Content-Type" => "text/csv; charset=utf-8",
        "Content-Disposition" => "attachment; filename=all_tickets.csv",
        "Pragma" => "no-cache",
        "Cache-Control" => "private, max-age=0, must-revalidate",
    ];

    $callback = function () use ($tickets) {
        $handle = fopen('php://output', 'w');
        fwrite($handle, "\xEF\xBB\xBF"); // UTF-8 BOM

        // Add CSV headers
        fputcsv($handle, [
            'Created By',
            'Ticket ID',
            'Trace ID',
            'Provider Name',
            'Issue Category',
            'Issue Description',
            'Assigned To',
            'Priority',
            'Status',
            'Test',
            'Environment',
            'Comment',
        ]);

        // Add CSV data
        foreach ($tickets as $ticket) {
            $formattedId = 'W-' . $ticket->created_at->format('Ymd') . '-' . str_pad($ticket->id, 3, '0', STR_PAD_LEFT);

            fputcsv($handle, [
                $ticket->creator->name ?? 'No user assigned',
                $formattedId,
                $ticket->trace_id,
                $ticket->provider_name,
                $ticket->issue_category,
                $ticket->issue_description,
                $ticket->assigned_to ?: 'No team assigned',
                ucfirst($ticket->priority),
                ucfirst($ticket->status),
                !empty($ticket->test) ? ucfirst($ticket->test) : '----',
                $ticket->environment,
                $ticket->comment ?? 'No comment',
            ]);
        }

        fclose($handle);
    };

    return response()->stream($callback, 200, $headers);
}




    public function showCategories()
    {
        $categories = Category::all(); // Retrieve all categories
        return view('admin.add-category', compact('categories')); // Pass categories to the view
    }
    public function destroyProvider($id)
    {
        // Find the provider by ID and delete it
        $provider = Provider::findOrFail($id);
        $provider->delete();

        // Redirect back with a success message
        return redirect()->back()->with('status', 'Provider deleted successfully!');
    }
    public function destroystatus($id)
    {
        // Find the status by ID and delete it
        $status = Status::findOrFail($id);
        $status->delete();

        // Redirect back with a success message
        return redirect()->back()->with('status', 'Status deleted successfully!');
    }
    public function destroyteam($id)
    {
        // Find the team by ID and delete it
        $team = Team::findOrFail($id);
        $team->delete();

        // Redirect back with a success message
        return redirect()->back()->with('status', 'Team deleted successfully!');
    }






    /**
     * Store a newly created provider in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
}
