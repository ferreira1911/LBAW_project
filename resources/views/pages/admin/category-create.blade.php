@extends('layouts.app')

@section('title', 'Manage Categories')

@section('content')
<div class="bg-light py-5" style="min-height: calc(100vh - 200px);">
    <div class="container">
        
        @include('partials.admin-tabs')

        {{-- Header Section --}}
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="fw-bold text-dark mb-0">Category Management</h2>
                <p class="text-muted mb-0">Organize your auction categories and view statistics.</p>
            </div>
            
            {{-- Trigger Modal Button --}}
            <button type="button" class="btn btn-primary btn-lg rounded-pill px-4 shadow-sm" data-bs-toggle="modal" data-bs-target="#createCategoryModal">
                <i class="bi bi-plus-lg me-2"></i>New Category
            </button>
        </div>

        {{-- Categories Table --}}
        <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light border-bottom">
                            <tr>
                                <th class="ps-4 py-3 text-secondary small text-uppercase fw-bold" style="width: 10%;">ID</th>
                                <th class="py-3 text-secondary small text-uppercase fw-bold" style="width: 50%;">Name</th>
                                <th class="py-3 text-secondary small text-uppercase fw-bold text-center" style="width: 20%;">Active Auctions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($categories as $category)
                                <tr>
                                    <td class="ps-4 fw-bold text-muted">#{{ $category->id }}</td>
                                    <td>
                                        <span class="fw-bold text-dark fs-5">{{ $category->name }}</span>
                                    </td>
                                    <td class="text-center">
                                        {{-- Shows number of auctions in this category --}}
                                        <span class="badge bg-primary-subtle text-primary rounded-pill px-3 py-2">
                                            {{ $category->auctions()->count() }} Auctions
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center py-5 text-muted">
                                        <div class="mb-3"><i class="bi bi-tags display-4 opacity-25"></i></div>
                                        <h5 class="fw-bold">No categories found</h5>
                                        <p>Click the button above to create your first category.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
</div>

{{-- CREATE CATEGORY MODAL --}}
<div class="modal fade" id="createCategoryModal" tabindex="-1" aria-labelledby="createCategoryModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow rounded-4">
            <div class="modal-header border-bottom-0 pb-0">
                <h5 class="modal-title fw-bold" id="createCategoryModalLabel">Create New Category</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <form action="{{ route('categories.store') }}" method="POST">
                    @csrf
                    
                    <div class="mb-4">
                        <label for="name" class="form-label fw-bold text-secondary small text-uppercase">Category Name</label>
                        <div class="input-group input-group-lg">
                            <span class="input-group-text bg-light border-0"><i class="bi bi-tag-fill text-muted"></i></span>
                            <input type="text" class="form-control bg-light border-0" 
                                   id="name" name="name" placeholder="e.g. Electronics, Art..." required autofocus>
                        </div>
                        @error('name')
                            <div class="text-danger small mt-2"><i class="bi bi-exclamation-circle me-1"></i>{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary btn-lg rounded-pill fw-bold">
                            Save Category
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection