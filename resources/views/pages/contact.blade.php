@extends('layouts.app')

@section('title', 'Contact Support')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6"> 
            <div class="card shadow-sm">
                
                <div class="card-header bg-white text-center py-4">
                    <h3 class="mb-0 fw-bold">Contact Support</h3>
                    <p class="text-muted small mb-0 mt-2">
                        Need help? Fill out the form below.
                    </p>
                </div>

                <div class="card-body p-4">

                    @if ($errors->any())
                        <div class="alert alert-danger mb-4">
                            <ul class="mb-0 ps-3">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('contact.send') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label for="name" class="form-label">Your Name</label>
                            <input type="text" 
                                   name="name" 
                                   id="name" 
                                   class="form-control" 
                                   value="{{ old('name') }}" 
                                   required 
                                   autofocus>
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Your Email</label>
                            <input type="email" 
                                   name="email" 
                                   id="email" 
                                   class="form-control" 
                                   value="{{ old('email') }}" 
                                   required>
                        </div>

                        <div class="mb-3">
                            <label for="subject" class="form-label">Subject</label>
                            <input type="text" 
                                   name="subject" 
                                   id="subject" 
                                   class="form-control" 
                                   value="{{ old('subject') }}" 
                                   required>
                        </div>

                        <div class="mb-4">
                            <label for="message" class="form-label">Message</label>
                            <textarea name="message" 
                                      id="message" 
                                      rows="5" 
                                      class="form-control" 
                                      required>{{ old('message') }}</textarea>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary btn-lg">
                                Send Message
                            </button>
                        </div>

                    </form>
                </div>
            </div>
            
            <div class="text-center mt-4">
                <a href="{{ url('/') }}" class="text-decoration-none fw-bold text-muted">
                    <i class="bi bi-arrow-left me-1"></i> Back to Home
                </a>
            </div>

        </div>
    </div>
</div>
@endsection