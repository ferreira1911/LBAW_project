@extends('layouts.app')

@section('title', 'Manage Categories')

@section('content')
<div class="bg-light py-5" style="min-height: calc(100vh - 200px);">
    <div class="container">
        
        @include('partials.admin-tabs')

        <div class="row g-4">
            
            {{-- COLUMN 1: CREATE FORM --}}
            <div class="col-md-4">
                <div class="card border-0 shadow-sm rounded-4">
                    <div class="card-header bg-white border-0 pt-4 px-4">
                        <h5 class="fw-bold text-dark m-0">
                            <i class="bi bi-plus-circle-fill text-primary me-2"></i>New Category
                        </h5>
                    </div>
                    <div class="card-body p-4">
                        <form action="{{ route('categories.store') }}" method="POST">
                            @csrf
                            
                            <div class="mb-3">
                                <label for="name" class="form-label fw-bold small text-uppercase text-muted">Name</label>
                                <input type="text" class="form-control form-control-lg bg-light border-0" 
                                       id="name" name="name" placeholder="e.g. Electronics" required autofocus>
                                @error('name')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary btn-lg fw-bold">
                                    Create Category
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            {{-- COLUMN 2: LIST TABLE --}}
            <div class="col-md-8">
                <div class="card border-0 shadow-sm rounded-4 h-100">
                    <div class="card-header bg-white border-bottom px-4 py-3 d-flex justify-content-between align-items-center">
                        <h5 class="fw-bold text-dark m-0">Existing Categories</h5>
                        <span class="badge bg-light text-dark border">{{ $categories->count() }} Total</span>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="bg-light">
                                    <tr>
                                        <th class="ps-4 py-3 text-secondary small text-uppercase">ID</th>
                                        <th class="py-3 text-secondary small text-uppercase w-100">Name</th>
                                        <th class="pe-4 py-3 text-end text-secondary small text-uppercase">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($categories as $category)
                                        <tr>
                                            <td class="ps-4 fw-bold text-muted">#{{ $category->id }}</td>
                                            <td class="fw-bold text-dark">{{ $category->name }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="3" class="text-center py-5 text-muted">
                                                No categories found. Start adding some!
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
    </div>
</div>
@endsection