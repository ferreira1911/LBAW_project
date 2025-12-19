<form method="GET" action="{{ route('auctions.search') }}" id="filter-form" class="card border-0 shadow-sm sticky-top" style="top: 90px; z-index: 100;">
    
    <div class="card-header bg-white border-bottom py-3">
        <div class="d-flex align-items-center justify-content-between">
            <h5 class="mb-0 fw-bold text-dark">
                <i class="bi bi-sliders me-2 text-primary"></i> Filters
            </h5>
            @if(request()->anyFilled(['query', 'category', 'min_price', 'max_price', 'sort']))
                <a href="{{ route('auctions.search') }}" class="text-decoration-none small text-danger fw-bold">
                    Clear All
                </a>
            @endif
        </div>
    </div>

    <div class="card-body p-4">
        
        <div class="mb-4">
            <label for="query" class="form-label text-uppercase text-muted small fw-bold ls-1">Keywords</label>
            <div class="input-group">
                <span class="input-group-text bg-light border-end-0 text-muted">
                    <i class="bi bi-search"></i>
                </span>
                <input type="search" name="query" id="query" 
                       class="form-control border-start-0 bg-light" 
                       placeholder="What are you looking for?" 
                       value="{{ request('query') }}">
            </div>
        </div>

        <div class="mb-4">
            <label for="category-select" class="form-label text-uppercase text-muted small fw-bold ls-1">Category</label>
            <select name="category" id="category-select" class="form-select bg-light" onchange="this.form.submit()">
                <option value="">All Categories</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-4">
            <label class="form-label text-uppercase text-muted small fw-bold ls-1">Price Range</label>
            <div class="input-group">
                <span class="input-group-text bg-light text-muted">€</span>
                <input type="number" name="min_price" class="form-control bg-light" placeholder="Min" 
                       value="{{ request('min_price') }}" min="0">
                <span class="input-group-text bg-white border-start-0 border-end-0 text-muted">-</span>
                <input type="number" name="max_price" class="form-control bg-light" placeholder="Max" 
                       value="{{ request('max_price') }}" min="0">
            </div>
        </div>

        <div class="mb-4">
            <label for="sort-select" class="form-label text-uppercase text-muted small fw-bold ls-1">Sort By</label>
            <select name="sort" id="sort-select" class="form-select bg-light" onchange="this.form.submit()">
                <option value="ending_soon" {{ request('sort') == 'ending_soon' ? 'selected' : '' }}>Ending Soonest</option>
                <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>Price: Low to High</option>
                <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Price: High to Low</option>
            </select>
        </div>

        <div class="d-grid">
            <button type="submit" class="btn btn-primary fw-bold py-2">
                Apply Filters
            </button>
        </div>

    </div>
</form>