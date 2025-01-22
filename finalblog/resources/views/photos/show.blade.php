<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $photo->description }}</title>
</head>
<body>
    <h1>{{ $photo->description }}</h1>
    <img src="{{ asset('storage/' . $photo->photo) }}" alt="Photo">
    
    <a href="{{ route('photos.edit', $photo) }}">Edit</a>
    <form action="{{ route('photos.destroy', $photo) }}" method="POST" style="display:inline;">
        @csrf
        @method('DELETE')
        <button type="submit">Delete</button>
    </form>

    <a href="{{ route('dashboard') }}">Back to Dashboard</a>
</body>
</html>
