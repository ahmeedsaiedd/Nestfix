<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;

class Ticket extends Model
{
    protected $fillable = [
        'user_id',
        'trace_id',
        'provider_name',
        'issue_category',
        'issue_description',
        'assigned_to',
        'status',
        'priority', // Include priority
        'environment',
        'attachments',
        'created_by',
        'comment',
        'test',
        'closed_at',
        'solved_at'
    ];

    public $timestamps = false;

    protected $dates = ['created_at', 'closed_at', 'solved_at'];

    // Define relationships if any
    public function attachments()
    {
        return $this->hasMany(TicketAttachment::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
  
    public function getFormattedIdAttribute()
    {
        // Ensure the ticket ID is padded to 3 digits
        $id = str_pad($this->attributes['id'], 3, '0', STR_PAD_LEFT);

        // Format the date as YYYYMMDD
        $date = $this->created_at->format('Ymd');

        // Return the formatted ticket ID
        return "W-{$date}-{$id}";
    }
    protected $casts = [
        'solved_at' => 'datetime',
        'closed_at' => 'datetime',
    ];
    
}
