<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ExportController extends Controller
{
    public function exportTickets()
    {
        $tickets = Ticket::all();

        $response = new StreamedResponse(function() use ($tickets) {
            $handle = fopen('php://output', 'w+');
            
            // Output UTF-8 BOM for Excel compatibility
            fwrite($handle, "\xEF\xBB\xBF");

            // Add CSV headers
            fputcsv($handle, [
                'Ticket ID',
                'Trace ID',
                'Provider Name',
                'Issue Category',
                'Issue Description',
                'Assigned To',
                'Priority',
                'Status',
                'Attachment',
                'Created At',
                'Closed At',
                'Comment'
            ]);

            // Add CSV data
            foreach ($tickets as $ticket) {
                fputcsv($handle, [
                    $ticket->id,
                    $ticket->trace_id,
                    $ticket->provider_name,
                    $ticket->issue_category,
                    $ticket->issue_description,
                    $ticket->assigned_to,
                    $ticket->priority,
                    $ticket->status,
                    $ticket->attachment,
                    $ticket->created_at->format('Y-m-d H:i'),
                    $ticket->closed_at ? $ticket->closed_at->format('Y-m-d H:i') : 'N/A',
                    $ticket->comment
                ]);
            }

            fclose($handle);
        });

        $response->headers->set('Content-Type', 'text/csv; charset=utf-8');
        $response->headers->set('Content-Disposition', 'attachment; filename="tickets.csv"');

        return $response;
    }
}
