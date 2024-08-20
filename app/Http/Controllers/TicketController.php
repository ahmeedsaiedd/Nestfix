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
        $validator = Validator::make($request->all(), [
            'trace_id' => 'required|string',
            'provider_name' => 'required|string',
            'issue_category' => 'required|string',
            'issue_description' => 'required|string',
            'assigned_to' => 'required|string',
            'priority' => 'required|string',
            'attachments.*' => 'file|mimes:jpg,jpeg,png,mp4,avi|max:20480', // Validate files
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Store the ticket
        $ticket = Ticket::create($request->except('attachments'));

        // Handle file uploads
        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $file) {
                $path = $file->store('attachments', 'public'); // Store files in the public/attachments directory

                // Save attachment paths to the database
                TicketAttachment::create([
                    'ticket_id' => $ticket->id,
                    'file_path' => $path,
                ]);
            }
        }

        return redirect()->route('add-ticket')->with('success', 'Ticket added successfully!');
    }
    public function index()
    {
        // Fetch all tickets
        $tickets = Ticket::all();

        // Pass tickets to the view
        return view('admin/all-tickets', compact('tickets'));
    }
    public function updateStatus(Request $request)
{
    try {
        $request->validate([
            'ticket_id' => 'required|exists:tickets,id',
            'status' => 'required|in:open,in progress,solved,done,closed',
            'comment' => 'nullable|string'
        ]);

        $ticket = Ticket::find($request->ticket_id);
        if (!$ticket) {
            return response()->json(['message' => 'Ticket not found'], 404);
        }

        $ticket->status = $request->status;
        $ticket->comment = $request->comment;

        if ($request->status === 'closed') {
            $ticket->closed_at = now();
        } else {
            $ticket->closed_at = null;
        }

        $ticket->save();

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
            'comment' => 'nullable|string',
        ]);

        // Find the ticket by ID
        $ticket = Ticket::find($id);
        if (!$ticket) {
            return redirect()->back()->withErrors('Ticket not found');
        }

        // Update the ticket with new data
        $ticket->status = $request->input('status');
        $ticket->comment = $request->input('comment');

        // Optionally update closed_at based on status
        if ($request->input('status') === 'closed' && !$ticket->closed_at) {
            $ticket->closed_at = now(); // Set to current date/time
        }

        $ticket->save();

        // Redirect or return a response
        return redirect()->route('all-tickets')->with('success', 'Ticket updated successfully');
    }
}
