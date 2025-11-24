@extends('layouts.app')

@section('title', 'Edit Profile')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-10 col-lg-8">
            
            {{-- Breadcrumb --}}
            <nav aria-label="breadcrumb" class="mb-4">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('auctions.index') }}" class="text-decoration-none">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('users.show', $user) }}" class="text-decoration-none">My Profile</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Edit</li>
                </ol>
            </nav>

            <div class="card shadow-sm border-0">
                <div class="card-body p-4 p-md-5">
                    
                    {{-- Header --}}
                    <div class="d-flex align-items-center mb-4 border-bottom pb-3">
                        <i class="bi bi-person-gear fs-3 text-primary me-3"></i>
                        <h2 class="h3 fw-bold mb-0">Edit Profile</h2>
                    </div>

                    <form method="POST" action="{{ route('users.update', $user) }}" enctype="multipart/form-data">
                        @csrf
                        
                        {{-- Profile Information Section --}}
                        <h5 class="fw-bold text-secondary mb-3">Public Information</h5>
                        
                        <div class="row g-3 mb-3">
                            {{-- Name Input --}}
                            <div class="col-md-6">
                                <label for="name" class="form-label fw-bold">Full Name</label>
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" 
                                       name="name" value="{{ old('name', $user->name) }}" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Email Input --}}
                            <div class="col-md-6">
                                <label for="email" class="form-label fw-bold">Email Address</label>
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" 
                                       name="email" value="{{ old('email', $user->email) }}" required>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        {{-- Bio Input --}}
                        <div class="mb-4">
                            <label for="description" class="form-label fw-bold">Description (Bio)</label>
                            <textarea id="description" name="description" class="form-control @error('description') is-invalid @enderror" 
                                      rows="4" placeholder="Tell us a bit about yourself...">{{ old('description', $user->description) }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Profile Picture Section --}}
                        <div class="mb-5">
                            <label for="url" class="form-label fw-bold">Profile Picture</label>
                            <div class="d-flex align-items-center gap-3">
                                @if ($user->url)
                                    <img src="{{ $user->getProfileImage() }}" alt="Current Profile" 
                                         class="rounded-circle object-fit-cover border" width="60" height="60">
                                @else
                                    <div class="rounded-circle bg-light d-flex align-items-center justify-content-center border" 
                                         style="width: 60px; height: 60px;">
                                        <i class="bi bi-person text-secondary fs-4"></i>
                                    </div>
                                @endif
                                <div class="flex-grow-1">
                                    <input id="url" type="file" class="form-control @error('url') is-invalid @enderror" name="url">
                                    <div class="form-text text-muted small">Upload a new image to update your profile picture.</div>
                                </div>
                            </div>
                            @error('url')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <hr class="my-4">

                        {{-- Security Section --}}
                        <h5 class="fw-bold text-secondary mb-3">
                            <i class="bi bi-shield-lock me-2"></i>Change Password
                        </h5>
                        <p class="text-muted small mb-3">Leave these fields blank if you don't want to change your password.</p>

                        <div class="row g-3 mb-4">
                            {{-- New Password --}}
                            <div class="col-md-6">
                                <label for="password" class="form-label fw-bold">New Password</label>
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" 
                                       name="password" autocomplete="new-password">
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Confirm Password --}}
                            <div class="col-md-6">
                                <label for="password_confirmation" class="form-label fw-bold">Confirm Password</label>
                                <input id="password_confirmation" type="password" class="form-control" 
                                       name="password_confirmation" autocomplete="new-password">
                            </div>
                        </div>

                        {{-- Actions --}}
                        <div class="d-flex gap-2 justify-content-end">
                            <a href="{{ route('users.show', $user) }}" class="btn btn-outline-secondary px-4">Cancel</a>
                            <button type="submit" class="btn btn-primary px-4">
                                <i class="bi bi-check-lg me-2"></i>Update Profile
                            </button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection