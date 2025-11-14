<form method="GET" action="{{ route('auctions.search') }}" id="filter-form" class="card p-4 mb-4 shadow-sm">

    <!-- Header -->
    <div class="d-flex align-items-center mb-3">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
            stroke-linecap="round" stroke-linejoin="round" class="me-2">
            <polygon points="22 3 2 3 10 12.46 10 19 14 21 14 12.46 22 3"/>
        </svg>
        <h5 class="mb-0">Filtros</h5>
    </div>

    {{-- Search --}}
    <div class="mb-3">
        <label for="query" class="form-label">Pesquisar</label>
        <div class="input-group">
            <span class="input-group-text bg-light">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                    stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="11" cy="11" r="8" />
                    <path d="m21 21-4.3-4.3" />
                </svg>
            </span>
            <input type="search" name="query" id="query" class="form-control"
                   placeholder="Pesquisar leilões..."
                   value="{{ request('query') }}">
        </div>
    </div>

    {{-- Category --}}
    <div class="mb-3">
        <label for="category-select" class="form-label">Categoria</label>
        <select name="category" id="category-select" class="form-select" onchange="this.form.submit()">
            <option value="">Todas as Categorias</option>
            @foreach($categories as $category)
                <option value="{{ $category->id }}" 
                    {{ request('category') == $category->id ? 'selected' : '' }}>
                    {{ $category->name }}
                </option>
            @endforeach
        </select>
    </div>

    {{-- Price Range --}}
    <div class="mb-3">
        <label class="form-label">Preço (€)</label>
        <div class="d-flex align-items-center gap-2">
            <input type="number" name="min_price"
                   class="form-control" placeholder="Min"
                   value="{{ request('min_price') }}" min="0">

            <span class="fw-bold">—</span>

            <input type="number" name="max_price"
                   class="form-control" placeholder="Max"
                   value="{{ request('max_price') }}" min="0">
        </div>
    </div>

    {{-- Sort --}}
    <div class="mb-4">
        <label for="sort-select" class="form-label">Ordenar por</label>
        <select name="sort" id="sort-select" class="form-select" onchange="this.form.submit()">
            <option value="">Padrão</option>
            <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>Preço: Baixo para Alto</option>
            <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Preço: Alto para Baixo</option>
            <option value="ending_soon" {{ request('sort') == 'ending_soon' ? 'selected' : '' }}>A Terminar em Breve</option>
        </select>
    </div>

    {{-- Buttons --}}
    <div class="d-flex gap-3">
        <button type="submit" class="btn btn-primary px-4">
            Aplicar filtros
        </button>

        <a href="{{ route('auctions.index') }}" class="btn btn-outline-secondary">
            Limpar filtros
        </a>
    </div>
</form>
