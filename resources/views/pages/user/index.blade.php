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

    <div id="usersContainer" class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
        {{-- O estado inicial de carregamento --}}
        <div class="col-12 text-center py-5">
            <div class="spinner-border text-primary" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
        </div>
    </div>

    {{-- Load More Button --}}
    <div class="text-center mt-5">
        <button id="loadMoreBtn" class="btn btn-outline-primary btn-lg px-5 rounded-pill d-none">
            Load More Users
        </button>
    </div>

</div>
@endsection