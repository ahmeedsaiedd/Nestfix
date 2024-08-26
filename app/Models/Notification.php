<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    // Specify the table if it's not following Laravel's convention (plural form of the model name)
    // protected $table = 'notifications'; 

    // Define which attributes are mass assignable
    protected $fillable = [
        'title', 
        'message',
        // Add other fields as needed
    ];

    // If you want to include timestamps in your model
    public $timestamps = true;
}

