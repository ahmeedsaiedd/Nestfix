<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Provider extends Model
{
    use HasFactory;

    // Specify the table name if it's different from the plural form of the model name
    protected $table = 'providers'; 

    // Define the fillable attributes
    protected $fillable = ['name'];
}
