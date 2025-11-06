@extends('layouts.app')

@section('title', 'Edit Profile')

@section('content')
<div class="container">
    <h2>Edit Profile</h2>
    <p>Update your public profile information.</p>

    <div class="edit-form">
        <form method="POST" action="{{ route('user.update', $user) }}" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="column">
                    {{-- Name Field --}}
                    <label for="name">Name</label>
                    <input id="name" type="text" name="name" 
                           value="{{ old('name', $user->name) }}" required>
                    
                    {{-- Shows validation errors for 'name' --}}
                    @error('name')
                        <span class="error" role="alert">{{ $message }}</span>
                    @enderror
                </div>
                <div class="column">
                    {{-- Email Field --}}
                    <label for="email">Email</label>
                    <input id="email" type="email" name="email" 
                           value="{{ old('email', $user->email) }}" required>
                    
                    @error('email')
                        <span class="error" role="alert">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            {{-- Description (Bio) Field --}}
            <label for="description">Description (Bio)</label>
            <textarea id="description" name="description" 
                      placeholder="Tell us a bit about yourself...">{{ old('description', $user->description) }}</textarea>
            
            @error('description')
                <span class="error" role="alert">{{ $message }}</span>
            @enderror

            {{-- Profile Picture (URL) Field --}}
            <label for="url">Profile Picture</label>
            
            {{-- Show the user's current picture, if they have one --}}
            @if ($user->url)
                <div class="current-image">
                    <img src="{{ $user->getProfileImage() }}" alt="{{ $user->name }}'s Profile Picture" height="100">
                </div>
            @endif

            <input id="url" type="file" name="url">
            <p><small>Leave blank to keep your current picture.</small></p>
            
            @error('url')
                <span class="error" role="alert">{{ $message }}</span>
            @enderror

            <hr>

            {{-- Password Change Section --}}
            <h4>Change Password</h4>
            <p><small>Leave these fields blank to keep your current password.</small></p>

            <div class="row">
                <div class="column">
                    <label for="password">New Password</label>
                    <input id="password" type="password" name="password" autocomplete="new-password">
                    
                    @error('password')
                        <span class="error" role="alert">{{ $message }}</span>
                    @enderror
                </div>
                <div class="column">
                    <label for="password_confirmation">Confirm New Password</label>
                    <input id="password_confirmation" type="password" 
                           name="password_confirmation" autocomplete="new-password">
                </div>
            </div>
            
            <button type="submit" class="button-primary">Update Profile</button>
            <a href="{{ route('user.show', $user) }}" class="button button-outline">Cancel</a>

        </form>
    </div>
</div>
@endsection
