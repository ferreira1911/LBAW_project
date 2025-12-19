@extends('layouts.app')

@section('title', 'User Management')

@section('content')
<div class="container py-5">

    @include('partials.admin-tabs')
    
    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="fw-bold text-dark mb-0">User Management</h1>
            <p class="text-muted">Manage all registered users, administrators and their permissions.</p>
        </div>
        <a href="{{ route('users.create') }}" class="btn btn-primary">
            <i class="fas fa-user-plus me-2"></i>Create New User
        </a>
    </div>

    {{-- Search Bar (Sem tag <form> para não submeter) --}}
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-body p-2">
            <div class="row g-2 align-items-center">
                <div class="col-md-10">
                    <div class="input-group">
                        <span class="input-group-text bg-white border-0">
                            <i class="fas fa-search text-muted"></i>
                        </span>
                        {{-- ID searchInput para o JS --}}
                        <input type="text" id="searchInput" class="form-control border-0 shadow-none" 
                               placeholder="Search users by name or email..." 
                               autocomplete="off">
                    </div>
                </div>
                <div class="col-md-2 d-grid">
                    {{-- ID searchButton e type="button" --}}
                    <button id="searchButton" type="button" class="btn btn-dark">Search</button>
                </div>
            </div>
        </div>
    </div>

    {{-- Auctions Table Design applied to Users --}}
    <div class="card shadow-sm border-0">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="ps-4 py-3" style="width: 60px;">ID</th>
                            <th class="py-3">User</th>
                            <th class="py-3">Role</th>
                            <th class="py-3">Status</th>
                            <th class="py-3 text-end pe-4">Actions</th>
                        </tr>
                    </thead>
                    <tbody id="usersTableBody">
                        {{-- O JavaScript vai preencher isto --}}
                    </tbody>

                    <tfoot id="loadMoreContainer" class="d-none">
                        <tr>
                            <td colspan="5" class="p-0">
                                <button id="loadMoreBtn" type="button" class="btn btn-light w-100 py-3 text-primary fw-bold border-0 rounded-0" style="transition: all 0.2s;">
                                    Load More Users <i class="bi bi-chevron-down ms-1"></i>
                                </button>
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>

    <div id="loadingSpinner" class="text-center py-5">
        <div class="spinner-border text-primary" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
    </div>

</div>
@endsection