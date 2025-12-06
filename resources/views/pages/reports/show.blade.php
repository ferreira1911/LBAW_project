@extends('layouts.app')

@section('title', 'Report Details #' . $report->id)

@section('content')
@php
$statusColor = match($report->status->name) {
    'Resolved' => 'success',
    'Dismissed' => 'secondary',
    'InReview' => 'primary',
    default => 'warning'
};
$statusIcon = match($report->status->name) {
    'Resolved' => 'bi-check-lg',
    'Dismissed' => 'bi-x-lg',
    'InReview' => 'bi-eye',
    default => 'bi-exclamation-triangle'
};
@endphp

<div class="bg-light py-5" style="min-height: calc(100vh - 200px);">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">
                
                <div class="mb-3">
                    <a href="{{ route('reports.admin') }}" class="text-decoration-none text-muted small">
                        <i class="bi bi-arrow-left me-1"></i> Back to Reports
                    </a>
                </div>

                <div class="card border-0 shadow-sm rounded-4">
                    <div class="card-body p-4 p-lg-5">
                        
                        {{-- Header Section --}}
                        <div class="text-center mb-4">
                            <div class="d-inline-flex align-items-center justify-content-center bg-{{ $statusColor }} bg-opacity-10 text-{{ $statusColor }} rounded-circle mb-3" style="width: 60px; height: 60px;">
                                <i class="bi {{ $statusIcon }} display-4" style="font-size: 2rem;"></i>
                            </div>
                            
                            <h2 class="fw-bold text-dark mb-1">Report #{{ $report->id }}</h2>
                            <div class="mb-2">
                                <span class="badge bg-{{ $statusColor }}-subtle text-{{ $statusColor }}-emphasis rounded-pill px-3 py-2">
                                    {{ $report->status }}
                                </span>
                            </div>
                            <p class="text-muted small">
                                Created on {{ $report->create_date->format('M d, Y') }} at {{ $report->create_date->format('H:i') }}
                            </p>
                        </div>

                        {{-- Section 1: The Target (Who/What was reported) --}}
                        <div class="mb-4">
                            <label class="form-label fw-bold text-dark small text-uppercase ls-1">Report Target</label>
                            
                            @if($report->reportedUser)
                                {{-- Target is a User --}}
                                <div class="p-3 bg-light border rounded-3 d-flex align-items-center">
                                    <div class="bg-white p-2 rounded-circle shadow-sm me-3 text-primary">
                                        <i class="bi bi-person-fill fs-4"></i>
                                    </div>
                                    <div class="flex-grow-1">
                                        <small class="text-uppercase text-muted fw-bold" style="font-size: 0.7rem;">Reported User</small>
                                        <div class="fw-bold text-dark">{{ $report->reportedUser->name }}</div>
                                        <small class="text-muted">{{ $report->reportedUser->email }}</small>
                                    </div>
                                    <a href="{{ route('users.show', $report->reportedUser->id) }}" class="btn btn-sm btn-outline-primary rounded-pill">
                                        Profile
                                    </a>
                                </div>
                            @elseif($report->auction)
                                {{-- Target is an Auction --}}
                                <div class="p-3 bg-light border rounded-3 d-flex align-items-center">
                                    <div class="bg-white p-2 rounded-circle shadow-sm me-3 text-warning">
                                        <i class="bi bi-hammer fs-4"></i>
                                    </div>
                                    <div class="flex-grow-1">
                                        <small class="text-uppercase text-muted fw-bold" style="font-size: 0.7rem;">Reported Auction</small>
                                        <div class="fw-bold text-dark">{{ $report->auction->title }}</div>
                                    </div>
                                    <a href="{{ route('auctions.show', $report->auction->id) }}" class="btn btn-sm btn-outline-warning text-dark rounded-pill">
                                        View
                                    </a>
                                </div>
                            @else
                                <div class="p-3 bg-light border rounded-3 text-muted fst-italic">
                                    Target information unavailable.
                                </div>
                            @endif
                        </div>

                        {{-- Section 2: The Reporter --}}
                        <div class="mb-4">
                            <label class="form-label fw-bold text-dark small text-uppercase ls-1">Reported By</label>
                            <div class="d-flex align-items-center ps-2">
                                <i class="bi bi-arrow-return-right text-secondary me-2"></i>
                                <span class="fw-medium text-dark">{{ $report->reporter->name }}</span>
                                <span class="text-muted mx-2">&bull;</span>
                                <span class="text-muted small">User ID: {{ $report->reporter->id }}</span>
                            </div>
                        </div>
                        
                        {{-- Section 3: Description --}}
                        <div class="mb-5">
                            <label class="form-label fw-bold text-dark small text-uppercase ls-1">Description / Reason</label>
                            <div class="p-3 bg-light border rounded-3 text-secondary">
                                <p class="mb-0 ps-2 text-break">
                                    {{ $report->description }}
                                </p>
                            </div>
                        </div>

                        <hr class="my-4 border-secondary-subtle">

                        {{-- Section 4: Admin Actions --}}
                        <div>
                            <label class="form-label fw-bold text-dark small text-uppercase ls-1 mb-3">Admin Actions</label>
                            
                            {{-- Assign Logic --}}
                            @if(is_null($report->admin_id))
                                <div class="alert alert-warning border-0 d-flex align-items-center mb-3">
                                    <i class="bi bi-exclamation-circle-fill me-2"></i>
                                    <div class="flex-grow-1 small">This report is not assigned to anyone.<br>If you want to solve the report, you can assign it to yourself.</div>
                                    <form action="{{ route('report.assign', $report) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-warning fw-bold text-dark">Assign to Me</button>
                                    </form>
                                </div>
                            @else
                                <div class="d-flex align-items-center mb-3 ps-2">
                                    <small class="text-muted me-2">Assigned to:</small>
                                    <span class="badge bg-secondary text-white">
                                        <i class="bi bi-person-fill me-1"></i>
                                        {{ $report->admin_id == Auth::id() ? 'You' : ($report->admin->name ?? 'Admin #'.$report->admin_id) }}
                                    </span>
                                </div>
                            @endif

                            {{-- Action Buttons (Only show if is In Review) --}}
                            @if(in_array($report->status->name, ['InReview']))
                                @can('resolve', $report)
                                    <div class="mb-3">
                                        @if($report->auction)
                                            @if($report->auction->status !== 'Cancelled' && $report->auction->status !== 'Ended') 
                                                <form action="{{ route('auctions.cancel', $report->auction) }}" method="POST">
                                                    @csrf
                                                    <button type="submit" class="btn btn-danger w-100 rounded-pill fw-bold mb-2" onclick="return confirm('Are you sure you want to CANCEL this auction? This cannot be undone.')">
                                                        <i class="bi bi-hammer me-2"></i>Cancel Auction (Punish)
                                                    </button>
                                                </form>
                                            @else
                                                <div class="alert alert-danger py-2 text-center fw-bold rounded-pill mb-2 opacity-75">
                                                    <i class="bi bi-ban me-2"></i>Auction is already Cancelled/Ended
                                                </div>
                                            @endif
                                        @endif

                                        @if($report->reportedUser)
                                            @if(!$report->reportedUser->is_blocked) 
                                                <form action="{{ route('users.block', $report->reportedUser) }}" method="POST">
                                                    @csrf
                                                    <button type="submit" class="btn btn-danger w-100 rounded-pill fw-bold mb-2" onclick="return confirm('Are you sure you want to BLOCK this user?')">
                                                        <i class="bi bi-person-x-fill me-2"></i>Block User (Punish)
                                                    </button>
                                                </form>
                                            @else
                                                <div class="alert alert-danger py-2 text-center fw-bold rounded-pill mb-2">
                                                    <i class="bi bi-person-slash me-2"></i>User is already Blocked
                                                </div>
                                            @endif
                                        @endif
                                    </div>
                                    
                                    @if($report->auction || $report->reportedUser)
                                        <hr class="border-secondary-subtle mb-4">
                                    @endif
                                    <div class="d-grid gap-2 d-md-flex justify-content-md-center mt-4">
                                        {{-- Resolve Button --}}
                                        <form action="{{ route('report.resolve', $report) }}" method="POST" class="flex-grow-1">
                                            @csrf
                                            <input type="hidden" name="status" value="Resolved">
                                            <button type="submit" class="btn btn-success btn-lg w-100 rounded-pill fw-bold shadow-sm" onclick="return confirm('Mark as Resolved?')">
                                                <i class="bi bi-check-circle me-2"></i>Resolve
                                            </button>
                                        </form>

                                        {{-- Dismiss Button --}}
                                        <form action="{{ route('report.dismiss', $report) }}" method="POST" class="flex-grow-1">
                                            @csrf
                                            <input type="hidden" name="status" value="Dismissed">
                                            <button type="submit" class="btn btn-outline-secondary btn-lg w-100 rounded-pill fw-bold" onclick="return confirm('Dismiss this report?')">
                                                <i class="bi bi-x-circle me-2"></i>Dismiss
                                            </button>
                                        </form>
                                    </div>
                                @endcan
                            @else
                                <div class="text-center mt-3 text-muted fst-italic">
                                    This report is resolved. No further actions available.
                                </div>
                            @endif
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection