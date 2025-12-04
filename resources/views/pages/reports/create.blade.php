@extends('layouts.app')

@section('title', 'Report Issue')

@section('content')
<div class="bg-light py-5" style="min-height: calc(100vh - 200px);">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">
                
                <div class="card border-0 shadow-sm rounded-4">
                    <div class="card-body p-4 p-lg-5">
                        
                        <div class="text-center mb-4">
                            <div class="d-inline-flex align-items-center justify-content-center bg-danger bg-opacity-10 text-danger rounded-circle mb-3" style="width: 60px; height: 60px;">
                                <i class="bi bi-shield-exclamation display-4"></i>
                            </div>
                            <h2 class="fw-bold text-dark">Report Issue</h2>
                            <p class="text-muted">Help us keep the community safe. Please describe the issue below.</p>
                        </div>

                        <form action="{{ route('report.store') }}" method="POST">
                            @csrf

                            
                            <div class="mb-4">
                                    <input type="hidden" name="auction_id" value="{{ $auction_id }}">
                                    <div class="p-3 bg-light border rounded-3 d-flex align-items-center">
                                        <i class="fas fa-gavel me-3 text-secondary fa-lg"></i>
                                        <div>
                                            <small class="text-uppercase text-muted fw-bold" style="font-size: 0.7rem;">Reporting Auction</small>
                                            <div class="fw-bold text-dark">ID #{{ $auction_id }}</div>
                                        </div>
                                    </div>
                                
                            </div>

                            
                            <div class="mb-4">
                                <label for="description" class="form-label fw-bold text-dark small text-uppercase ls-1">Reason for Report</label>
                                <textarea 
                                    name="description" 
                                    id="description" 
                                    rows="5" 
                                    class="form-control bg-white border-secondary-subtle rounded-3 @error('description') is-invalid @enderror" 
                                    placeholder="Please provide details about the violation (e.g., offensive content, counterfeit item, spam)..." 
                                    required 
                                    autofocus
                                >{{ old('description') }}</textarea>
                                
                                @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            
                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-danger btn-lg rounded-pill fw-bold shadow-sm">
                                    Submit Report
                                </button>
                                <a href="{{ url()->previous() }}" class="btn btn-link text-muted text-decoration-none text-center">
                                    Cancel
                                </a>
                            </div>

                        </form>

                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection