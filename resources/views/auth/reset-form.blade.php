@extends('layouts.app')

@section('title', 'Reset Password')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5">
            
            <div class="card border-0 shadow-sm rounded-0">
                <div class="card-body p-4 p-md-5">
                    
                    <div class="text-center mb-4">
                        <h3 class="fw-bold text-dark">Reset Password</h3>
                        <p class="text-muted small">Please choose a new secure password for your account.</p>
                    </div>

                    <form method="POST" action="{{ route('password.update') }}">
                        @csrf

                        <input type="hidden" name="token" value="{{ $token }}">

                        <div class="mb-3">
                            <label for="email" class="form-label fw-bold small text-uppercase text-muted">E-Mail Address</label>
                            <input id="email" type="email" class="form-control rounded-0 bg-light" 
                                   name="email" value="{{ $email ?? old('email') }}" required readonly>
                            @error('email')
                                <span class="text-danger small mt-1 d-block">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label fw-bold small text-uppercase text-muted">Password</label>
                            <input id="password" type="password" class="form-control rounded-0 @error('password') is-invalid @enderror" 
                                   name="password" required autofocus autocomplete="new-password">
                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="password-confirm" class="form-label fw-bold small text-uppercase text-muted">Confirm Password</label>
                            <input id="password-confirm" type="password" class="form-control rounded-0" 
                                   name="password_confirmation" required autocomplete="new-password">
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary rounded-0 py-2 fw-bold">
                                Reset Password
                            </button>
                        </div>

                    </form>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection