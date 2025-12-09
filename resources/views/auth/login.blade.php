@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5">
            <div class="card shadow-sm">
                <div class="card-header bg-white text-center py-4">
                    <h3 class="mb-0 fw-bold">Login</h3>
                </div>

                <div class="card-body p-4">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="mb-3">
                            <label for="email" class="form-label">E-mail Address</label>
                            <input 
                                id="email" 
                                type="email" 
                                class="form-control @error('email') is-invalid @enderror" 
                                name="email" 
                                value="{{ old('email') }}" 
                                required 
                                autocomplete="email" 
                                autofocus
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
                                autocomplete="current-password"
                            >
                            @error('password')
                                <div class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </div>
                            @enderror
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary btn-lg">
                                Login
                            </button>
                        </div>

                        <div class="position-relative my-4">
                            <hr class="text-muted">
                            <span class="position-absolute top-50 start-50 translate-middle px-2 bg-white text-muted small">
                                OR
                            </span>
                        </div>

                        <div class="d-grid gap-2">
                            <a href="{{ route('google-auth') }}" class="btn btn-outline-secondary btn-lg d-flex align-items-center justify-content-center">
                                <i class="bi bi-google me-2"></i>
                                Continue with Google
                            </a>
                        </div>

                        <div class="text-center mt-4">
                            <p class="mb-0 text-muted">Don't have an account?</p>
                            <a href="{{ route('register') }}" class="text-decoration-none fw-bold">Register here</a>
                        </div>

                        <div class="text-center mt-4">
                            <p class="mb-0 text-muted">Forgot your password?</p>
                            <a href="{{ route('password.request') }}" class="text-decoration-none fw-bold">Get it here</a>
                        </div>

                        @if (session('status'))
                            <div class="alert alert-success mt-3" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection