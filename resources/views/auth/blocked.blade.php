@extends('layouts.app')

@section('title', 'Account Suspended')

@section('content')
<div class="d-flex align-items-center justify-content-center bg-light" style="min-height: calc(100vh - 200px);">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">
                
                <div class="card border-0 shadow-lg rounded-4 overflow-hidden">
                    {{-- Header Vermelho para Alerta --}}
                    <div class="card-header bg-danger text-white p-4 text-center">
                        <div class="mb-3">
                            <i class="bi bi-shield-lock-fill" style="font-size: 4rem;"></i>
                        </div>
                        <h2 class="fw-bold mb-0">Account Suspended</h2>
                    </div>

                    <div class="card-body p-5 text-center">
                        <h4 class="fw-bold text-dark mb-3">Access to this account is currently restricted.</h4>
                        
                        <p class="text-muted mb-4 lead" style="font-size: 1.1rem;">
                            Our administrators have flagged this account for reviewing due to potential violations of our platform's terms of service or suspicious activity.
                        </p>

                        <div class="alert alert-warning border-0 rounded-3 text-start d-inline-block mb-4">
                            <div class="d-flex">
                                <i class="bi bi-exclamation-triangle-fill me-3 fs-4 text-warning-emphasis"></i>
                                <div>
                                    <strong>Why am I seeing this?</strong>
                                    <ul class="mb-0 ps-3 mt-1 small text-muted">
                                        <li>Reports of suspicious behavior.</li>
                                        <li>Security concerns regarding your credentials.</li>
                                        <li>Pending manual review by our staff.</li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <p class="text-secondary mb-4">
                            If you believe this is an error, please contact our support team immediately. 
                            We typically respond within 24-48 hours.
                        </p>

                        <div class="d-grid gap-2 col-md-8 mx-auto">
                            <a href="mailto:support@lbaw-auction.com?subject=Account%20Blocked%20Appeal%20-%20ID%20{{ session('blocked_user_id') ?? 'Unknown' }}" 
                               class="btn btn-dark btn-lg rounded-pill fw-bold">
                                <i class="bi bi-envelope-fill me-2"></i> Contact Support
                            </a>
                            <a href="{{ route('home') }}" class="btn btn-outline-secondary rounded-pill fw-bold mt-2">
                                <i class="bi bi-arrow-left me-2"></i> Return to Homepage
                            </a>
                        </div>
                    </div>
                    
                </div>

            </div>
        </div>
    </div>
</div>
@endsection