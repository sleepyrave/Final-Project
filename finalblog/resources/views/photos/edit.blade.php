<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Photo</title>
</head>
<body>
    <h1>Edit Photo</h1>
    
    <form action="{{ route('photos.update', $photo) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        
        <label for="photo">Choose a new photo</label>
        <input type="file" name="photo">

        <label for="description">Description</label>
        <textarea name="description">{{ $photo->description }}</textarea>

        <button type="submit">Update Photo</button>
    </form>

    <a href="{{ route('dashboard') }}">Back to Dashboard</a>
</body>
</html>
