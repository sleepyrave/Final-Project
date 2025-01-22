<x-app-layout>
    <div class="container mt-5">
        <!-- Welcome message -->
        <h1 class="text-center mb-4">Welcome to the Dashboard</h1>

        @auth
        <!-- Logout Button -->
        <div class="text-end mb-4">
            <a href="{{ route('logout') }}" class="btn btn-danger btn-hover" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">@csrf</form>
        </div>
        @else
        <!-- Login and Register Links -->
        <div class="text-center mt-3">
            <a href="{{ route('login') }}" class="btn btn-primary mx-2 btn-hover">Login</a>
            <a href="{{ route('register') }}" class="btn btn-secondary mx-2 btn-hover">Register</a>
        </div>
        @endauth

        <!-- Photo Upload Form -->
        @auth
        <div class="card p-4 mt-4">
            <h3 class="card-title">Upload Photo</h3>
            <form action="{{ route('photos.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label for="photo" class="form-label">Choose Photo</label>
                    <input type="file" name="photo" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea name="description" class="form-control" placeholder="Enter description"></textarea>
                </div>
                <button type="submit" class="btn btn-primary w-100 btn-hover">Upload</button>
            </form>
        </div>
        @endauth

        <!-- Display Photos -->
        @auth
        <h2 class="mt-5">Your Uploaded Photos</h2>
        <div class="row mt-3">
            @if ($photos->isEmpty())
                <p>No photos uploaded yet.</p>
            @else
                @foreach ($photos as $photo)
                    <div class="col-md-4">
                        <div class="card mb-4">
                            <img src="{{ asset('storage/' . $photo->photo) }}" class="card-img-top" alt="Uploaded Photo" style="height: 200px; object-fit: cover;">
                            <div class="card-body">
                                <p class="card-text">{{ $photo->description }}</p>

                                <!-- View, Edit, and Delete buttons -->
                                <div class="d-flex justify-content-between">
                                    <a href="{{ route('photos.show', $photo) }}" class="btn btn-info btn-sm btn-hover">View</a>
                                    <a href="{{ route('photos.edit', $photo) }}" class="btn btn-warning btn-sm btn-hover">Edit</a>
                                    <form action="{{ route('photos.destroy', $photo) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm btn-hover">Delete</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
        @endauth
    </div>

    <!-- Add custom CSS for hover effect -->
    <style>
        .btn-hover:hover {
            transform: scale(1.05);
            transition: transform 0.2s ease-in-out;
        }
    </style>
</x-app-layout>
