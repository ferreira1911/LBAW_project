@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5">
            <div class="card shadow-sm">
                <div class="card-header bg-white text-center py-4">
                    <h3 class="mb-0 fw-bold">Register</h3>
                </div>

                <div class="card-body p-4">
                    <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data">
                        @csrf

                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input 
                                id="name" 
                                type="text" 
                                class="form-control @error('name') is-invalid @enderror" 
                                name="name" 
                                value="{{ old('name') }}" 
                                required 
                                autocomplete="name" 
                                autofocus
                            >
                            @error('name')
                                <div class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">E-Mail Address</label>
                            <input 
                                id="email" 
                                type="email" 
                                class="form-control @error('email') is-invalid @enderror" 
                                name="email" 
                                value="{{ old('email') }}" 
                                required 
                                autocomplete="email"
                            >
                            @error('email')
                                <div class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input 
                                id="password" 
                                type="password" 
                                class="form-control @error('password') is-invalid @enderror" 
                                name="password" 
                                required 
                                autocomplete="new-password"
                            >
                            @error('password')
                                <div class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password-confirm" class="form-label">Confirm Password</label>
                            <input 
                                id="password-confirm" 
                                type="password" 
                                class="form-control" 
                                name="password_confirmation" 
                                required 
                                autocomplete="new-password"
                            >
                        </div>

                        <div class="mb-4">
                            <label for="profile_image" class="form-label">Profile Image <span class="text-muted small">(Optional)</span></label>
                            <input 
                                id="profile_image" 
                                type="file" 
                                class="form-control @error('profile_image') is-invalid @enderror" 
                                name="profile_image"
                            >
                            @error('profile_image')
                                <div class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </div>
                            @enderror
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary btn-lg">
                                Register
                            </button>
                        </div>

                        <div class="text-center mt-4">
                            <p class="mb-0 text-muted">Already have an account?</p>
                            <a href="{{ route('login') }}" class="text-decoration-none fw-bold">Login here</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection