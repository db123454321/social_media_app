// resources/views/profiles/upload-picture.blade.php

@extends('layouts.app')

@section('content')
    <h1>Upload Profile Picture</h1>
    <form method="POST" action="{{ route('profile.picture.upload') }}" enctype="multipart/form-data">
        @csrf
        <!-- Form fields for uploading profile picture -->
        <div>
            <label for="picture">Profile Picture:</label>
            <input type="file" id="picture" name="picture">
        </div>
        <button type="submit">Upload Picture</button>
    </form>
@endsection