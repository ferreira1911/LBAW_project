@extends('layouts.app')

@section('title', 'User Management')

@section('content')
<div class="container py-5">
    
    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="fw-bold text-dark mb-0">User Management</h1>
            <p class="text-muted">Manage all registered users, administrators and their permissions.</p>
        </div>
        <a href="{{ route('user.create') }}" class="btn btn-primary">
            <i class="bi bi-person-plus-fill me-2"></i>Create New User
        </a>
    </div>

    {{-- Search Bar --}}
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-body p-2">
            <form action="{{ route('users.index') }}" method="GET" class="row g-2 align-items-center">
                <div class="col-md-10">
                    <div class="input-group">
                        <span class="input-group-text bg-white border-0">
                            <i class="bi bi-search text-muted"></i>
                        </span>
                        <input type="text" name="search" class="form-control border-0 shadow-none" 
                               placeholder="Search users by name or email..." 
                               value="{{ request('search') }}">
                    </div>
                </div>
                <div class="col-md-2 d-grid">
                    <button type="submit" class="btn btn-dark">Search</button>
                </div>
            </form>
        </div>
    </div>

    {{-- Users Table --}}
    <div class="card shadow-sm border-0">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="ps-4 py-3" style="width: 50px;">#</th>
                            <th class="py-3">User</th>
                            <th class="py-3">Role</th>
                            <th class="py-3">Status</th>
                            <th class="py-3 text-end pe-4">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($users as $user)
                            <tr>
                                <td class="ps-4 fw-bold text-secondary">{{ $user->id }}</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        @if($user->url)
                                            <img src="{{ $user->getProfileImage() }}" alt="" class="rounded-circle me-3 object-fit-cover" width="40" height="40">
                                        @else
                                            <div class="rounded-circle bg-light d-flex align-items-center justify-content-center me-3 border" style="width: 40px; height: 40px;">
                                                <i class="bi bi-person text-secondary"></i>
                                            </div>
                                        @endif
                                        <div>
                                            <div class="fw-bold text-dark">{{ $user->name }}</div>
                                            <div class="small text-muted">{{ $user->email }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    @if($user->is_admin)
                                        <span class="badge bg-primary-subtle text-primary border border-primary-subtle rounded-pill">Admin</span>
                                    @else
                                        <span class="badge bg-secondary-subtle text-secondary border border-secondary-subtle rounded-pill">User</span>
                                    @endif
                                </td>
                                <td>
                                    @if(!$user->is_blocked)
                                        <span class="badge bg-success-subtle text-success rounded-pill"><i class="bi bi-check-circle me-1"></i>Active</span>
                                    @else
                                        <span class="badge bg-danger-subtle text-danger rounded-pill"><i class="bi bi-slash-circle me-1"></i>Blocked</span>
                                    @endif
                                </td>
                                <td class="text-end pe-4">
                                    <a href="{{ route('user.show', $user) }}" class="btn btn-sm btn-outline-secondary me-1" title="View Profile">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <a href="{{ route('user.edit', $user) }}" class="btn btn-sm btn-outline-primary me-1" title="Edit User">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    
                                    
                                    @if(Auth::id() !== $user->id)                                        
                                        <a href="{{ route('user.destroy', $user) }}" class="btn btn-sm btn-outline-danger" title="Delete User">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-5 text-muted">
                                    <i class="bi bi-people display-4 opacity-25 d-block mb-3"></i>
                                    No users found matching your search.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        
        {{-- Pagination Footer --}}
        @if($users->hasPages())
            <div class="card-footer bg-white py-3 border-top-0 d-flex justify-content-center">
                {{ $users->withQueryString()->links() }}
            </div>
        @endif
    </div>
</div>
@endsection