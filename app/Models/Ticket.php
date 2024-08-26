<?php

// app/Models/Ticket.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    // Columns that can be mass-assigned
    protected $fillable = [
        'trace_id',
        'provider_name',
        'issue_category',
        'issue_description',
        'status',
        'assigned_to',
        'priority',
        'attachments'
    ];
    

    // Cast the date fields to Carbon instances
    protected $dates = ['created_at', 'closed_at'];

    // Define relationships if any
    public function attachments()
    {
        return $this->hasMany(TicketAttachment::class);
    }
}
