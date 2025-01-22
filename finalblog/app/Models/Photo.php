<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Photo extends Model
{
    use HasFactory;

    // Add the columns to the $fillable property
    protected $fillable = [
        'user_id',     // Ensure the user_id is fillable
        'photo',       // The filename of the uploaded photo
        'description', // The description of the photo
    ];
}
