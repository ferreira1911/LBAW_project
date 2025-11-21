<form method="GET" action="{{ route('auctions.search') }}" id="filter-form" class="card shadow-sm border-0">
    <div class="card-body p-4">
        
        {{-- Header --}}
        <div class="d-flex align-items-center mb-4 border-bottom pb-3">
            <h5 class="mb-0 fw-bold text-secondary">
                <i class="bi bi-funnel-fill me-2"></i>Filters
            </h5>
        </div>

        {{-- Search --}}
        <div class="mb-4">
            <label for="query" class="form-label fw-bold small text-uppercase">Search</label>
            <div class="input-group">
                <span class="input-group-text bg-light border-end-0">
                    <i class="bi bi-search text-muted"></i>
                </span>
                <input type="search" name="query" id="query" class="form-control border-start-0 ps-0" 
                       placeholder="Keywords..." 
                       value="{{ request('query') }}">
            </div>
        </div>

        {{-- Category --}}
        <div class="mb-4">
            <label for="category-select" class="form-label fw-bold small text-uppercase">Category</label>
            <select name="category" id="category-select" class="form-select" onchange="this.form.submit()">
                <option value="">All Categories</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- Price Range --}}
        <div class="mb-4">
            <label class="form-label fw-bold small text-uppercase">Price Range (€)</label>
            <div class="d-flex align-items-center gap-2">
                <input type="number" name="min_price" class="form-control" placeholder="Min" 
                       value="{{ request('min_price') }}" min="0">
                <span class="text-muted fw-bold">—</span>
                <input type="number" name="max_price" class="form-control" placeholder="Max" 
                       value="{{ request('max_price') }}" min="0">
            </div>
        </div>

        {{-- Sort --}}
        <div class="mb-4">
            <label for="sort-select" class="form-label fw-bold small text-uppercase">Sort By</label>
            <select name="sort" id="sort-select" class="form-select" onchange="this.form.submit()">
                <option value="">Default</option>
                <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>Price: Low to High</option>
                <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Price: High to Low</option>
                <option value="ending_soon" {{ request('sort') == 'ending_soon' ? 'selected' : '' }}>Ending Soon</option>
            </select>
        </div>

        {{-- Actions --}}
        <div class="d-grid gap-2">
            <button type="submit" class="btn btn-primary fw-bold">
                Apply Filters
            </button>
            <a href="{{ route('auctions.index') }}" class="btn btn-outline-secondary btn-sm">
                Clear All
            </a>
        </div>

    </div>
</form>