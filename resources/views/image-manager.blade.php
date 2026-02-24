<!DOCTYPE html>
<html>
<head>
    <title>Image Manager</title>
</head>
<body>

@if(session('success'))
    <p style="color:green;">{{ session('success') }}</p>
@endif
@if(session('warning'))
    <p style="color:orange;">{{ session('warning') }}</p>
@endif

<h2>Upload Image</h2>
<form method="POST" action="{{ route('images.upload') }}" enctype="multipart/form-data">
    @csrf
    <input type="file" name="image" required>
    <button type="submit">Upload</button>
</form>

<hr>

<h2>Image Gallery</h2>
@foreach($images as $image)
    <div style="margin-bottom:20px;">
        <img src="{{ asset('uploads/' . $image->file_name) }}" width="150">
        <br>
        <a href="{{ route('images.delete', $image->id) }}" onclick="return confirm('Delete this image?')">Delete</a>
    </div>
@endforeach

</body>
</html>
