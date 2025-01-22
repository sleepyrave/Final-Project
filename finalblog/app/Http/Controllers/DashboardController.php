<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Photo;

class DashboardController extends Controller
{
    public function index()
    {
        // Fetch photos uploaded by the authenticated user
        $photos = Photo::where('user_id', auth()->id())->get();

        // Pass the photos to the view
        return view('dashboard', compact('photos'));
    }
}
