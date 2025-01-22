<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Photo;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PhotoController extends Controller
{
    public function store(Request $request)
    {
        // Validate the photo and description input
        $request->validate([
            'photo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // Ensure the file is an image
            'description' => 'nullable|string|max:255', // Optional description
        ]);

        // Handle the uploaded photo file
        $path = $request->file('photo')->store('photos', 'public'); // Store the photo in public/photos directory

        // Create a new photo record in the database
        Photo::create([
            'user_id' => Auth::id(), // Get the currently authenticated user
            'photo' => $path, // Store the file path
            'description' => $request->description, // Store the description
        ]);

        // Redirect back to the dashboard with a success message
        return redirect()->route('dashboard')->with('success', 'Photo uploaded successfully!');
    }

    // Show a single photo
    public function show(Photo $photo)
    {
        return view('photos.show', compact('photo')); // Display the photo
    }

    // Edit a photo
    public function edit(Photo $photo)
    {
        // Make sure the current user is the one who uploaded the photo
        if ($photo->user_id != Auth::id()) {
            return redirect()->route('dashboard')->with('error', 'Unauthorized action');
        }

        return view('photos.edit', compact('photo')); // Show the edit form
    }

    // Update the photo
    public function update(Request $request, Photo $photo)
    {
        // Validate the photo and description input
        $request->validate([
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Optional: validate photo
            'description' => 'nullable|string|max:255', // Optional: validate description
        ]);

        // Check if the photo has been updated
        if ($request->hasFile('photo')) {
            // Delete the old photo if a new one is uploaded
            if (Storage::exists('public/' . $photo->photo)) {
                Storage::delete('public/' . $photo->photo);
            }

            // Store the new photo
            $path = $request->file('photo')->store('photos', 'public');
            $photo->photo = $path; // Update the photo path
        }

        // Update the description if provided
        if ($request->has('description')) {
            $photo->description = $request->description;
        }

        $photo->save(); // Save the changes

        return redirect()->route('dashboard')->with('success', 'Photo updated successfully');
    }

    // Delete a photo
    public function destroy(Photo $photo)
    {
        // Check if the current user is the owner of the photo
        if ($photo->user_id != Auth::id()) {
            return redirect()->route('dashboard')->with('error', 'Unauthorized action');
        }

        // Delete the photo file from storage
        if (Storage::exists('public/' . $photo->photo)) {
            Storage::delete('public/' . $photo->photo);
        }

        // Delete the photo record from the database
        $photo->delete();

        return redirect()->route('dashboard')->with('success', 'Photo deleted successfully');
    }
}
