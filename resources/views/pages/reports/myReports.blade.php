@extends('layouts.app')

@section('title', 'Reports Management')

@section('content')
<div class="container py-5">
    
    @include('partials.admin-tabs')

    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="fw-bold text-dark mb-0">Reports Management</h1>
            <p class="text-muted">Manage all reports, monitor statuses and updates.</p>
        </div>
    </div>

    {{-- Search Bar --}}
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-body p-2">
            <form action="{{ route('reports.admin') }}" method="GET" class="row g-2 align-items-center">
                <div class="col-md-10">
                    <div class="input-group">
                        <span class="input-group-text bg-white border-0">
                            <i class="bi bi-search text-muted"></i>
                        </span>
                        <input type="text" name="search" class="form-control border-0 shadow-none" 
                               placeholder="Search reports by title..." 
                               value="{{ request('search') }}">
                    </div>
                </div>
                <div class="col-md-2 d-grid">
                    <button type="submit" class="btn btn-dark">Search</button>
                </div>
            </form>
        </div>
    </div>

    {{-- Reports Table --}}
    <div class="card shadow-sm border-0">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="ps-4 py-3" style="width: 60px;">ID</th>
                            <th class="py-3">Target</th>
                            <th class="py-3">Reporter</th>
                            <th class="py-3">Reason</th>
                            <th class="py-3">Status</th>
                            <th class="py-3">Date</th>
                            <th class="py-3 text-end pe-4">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($reports as $report)
                            <tr>
                                <td class="ps-4 fw-bold text-secondary">#{{ $report->id }}</td>

                                <td>
                                    @if($report->reportedUser)
                                        <div class="d-flex align-items-center">
                                            <div class="rounded-circle bg-primary-subtle text-primary d-flex align-items-center justify-content-center me-2 flex-shrink-0" style="width: 35px; height: 35px;">
                                                <i class="bi bi-person-fill"></i>
                                            </div>
                                            <div>
                                                <div class="small text-muted" style="line-height: 1;">User</div>
                                                <a href="{{ route('users.show', $report->reportedUser->id) }}" class="fw-bold text-dark text-decoration-none">
                                                    {{ Str::limit($report->reportedUser->name, 20) }}
                                                </a>
                                            </div>
                                        </div>
                                    @elseif($report->auction)
                                        <div class="d-flex align-items-center">
                                            <div class="rounded bg-warning-subtle text-warning-emphasis d-flex align-items-center justify-content-center me-2 flex-shrink-0" style="width: 35px; height: 35px;">
                                                <i class="bi bi-hammer"></i>
                                            </div>
                                            <div>
                                                <div class="small text-muted" style="line-height: 1;">Auction</div>
                                                <a href="{{ route('auctions.show', $report->auction->id) }}" class="fw-bold text-dark text-decoration-none">
                                                    {{ Str::limit($report->auction->title, 20) }}
                                                </a>
                                            </div>
                                        </div>
                                    @else
                                        <span class="text-muted fst-italic">System / Unknown</span>
                                    @endif
                                </td>

                                <td>
                                    <div class="d-flex align-items-center">
                                        <a href="{{ route('users.show', $report->reporter) }}" class="text-decoration-none text-secondary">
                                            <span class="fw-medium">{{ $report->reporter->name }}</span>
                                        </a>
                                    </div>
                                </td>

                                <td>
                                    <span class="text-muted" title="{{ $report->description }}">
                                        {{ Str::limit($report->description, 35) }}
                                    </span>
                                </td>

                                <td>
                                    @switch($report->status->name ?? $report->status)
                                        @case('Pending')
                                            <span class="badge bg-warning-subtle text-warning-emphasis rounded-pill">
                                                <i class="bi bi-hourglass-split me-1"></i>Pending
                                            </span>
                                        @break
                                        @case('InReview')
                                            <span class="badge bg-primary-subtle text-info-emphasis rounded-pill">
                                                <i class="bi bi-eye me-1"></i>In Review
                                            </span>
                                        @break
                                        @case('Resolved')
                                            <span class="badge bg-success-subtle text-success-emphasis rounded-pill">
                                                <i class="bi bi-check-circle me-1"></i>Resolved
                                            </span>
                                        @break
                                        @case('Dismissed')
                                            <span class="badge bg-secondary-subtle text-secondary-emphasis rounded-pill">
                                                <i class="bi bi-x-circle me-1"></i>Dismissed
                                            </span>
                                        @break
                                        @default
                                            <span class="badge bg-light text-dark border rounded-pill">
                                                {{ $report->status }}
                                            </span>
                                    @endswitch
                                </td>
                                <td class="text-muted small">
                                    {{ $report->create_date->format('M d, Y H:i') }}
                                </td>
                                <td class="text-end pe-4">
                                    <div class="d-flex justify-content-end gap-1">
                                        <a href="{{ route('reports.show', $report) }}" class="btn btn-sm btn-outline-secondary" title="View Report">
                                            <i class="bi bi-eye"></i>
                                        </a>

                                        @if(is_null($report->admin_id))
                                            <form action="{{ route('report.assign', $report) }}" method="POST" class="d-inline">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-outline-info" title="Assign to Me">
                                                    <i class="bi bi-person-plus"></i>
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-5 text-muted">
                                    <i class="bi bi-hammer display-4 opacity-25 d-block mb-3"></i>
                                    No reports found matching your criteria.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Pagination --}}
        @if($reports->hasPages())
            <div class="card-footer bg-white py-3 border-top-0 d-flex justify-content-center">
                {{ $reports->withQueryString()->links() }}
            </div>
        @endif
    </div>
</div>
@endsection