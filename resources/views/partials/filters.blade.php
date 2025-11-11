<form method="GET" action="{{ route('auctions.search') }}" id="filter-form">
  <div class="filter-section">
      <div class="filter">
          <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
               viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2"
               stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-filter">
              <polygon points="22 3 2 3 10 12.46 10 19 14 21 14 12.46 22 3"/>
          </svg>
          <span>Filtros</span>
      </div>

      {{-- Search --}}
      <div class="search-container mb-3">
          <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
               viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2"
               stroke-linecap="round" stroke-linejoin="round" class="search-icon">
              <circle cx="11" cy="11" r="8" />
              <path d="m21 21-4.3-4.3" />
          </svg>
          <input type="search" name="query" id="query" class="form-control"
                 placeholder="Pesquisar leilões..." value="{{ request('query') }}">
      </div>

      {{-- Category --}}
      <div class="category">
          <label for="category-select">Categoria:</label>
          <select name="category" id="category-select" onchange="this.form.submit()">
              <option value="">Todas as Categorias</option>
              @foreach($categories as $category)
                  <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                      {{ $category->name }}
                  </option>
              @endforeach
          </select>
      </div>

      {{-- Price range --}}
      <div class="price-range">
          <label>Preço (€)</label>
          <div class="price-inputs">
              <input type="number" name="min_price" placeholder="Min"
                     value="{{ request('min_price') }}" min="0">
              <span>-</span>
              <input type="number" name="max_price" placeholder="Max"
                     value="{{ request('max_price') }}" min="0">
          </div>
      </div>

      <div class="sort-by">
          <label for="sort-select">Ordenar por:</label>
          <select name="sort" id="sort-select" onchange="this.form.submit()">
              <option value="">Padrão</option>
              <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>Preço: Baixo para Alto</option>
              <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Preço: Alto para Baixo</option>
              <option value="ending_soon" {{ request('sort') == 'ending_soon' ? 'selected' : '' }}>A Terminar em Breve</option>
          </select>
      </div>

      {{-- Buttons --}}
      <button type="submit" class="apply-filters">Aplicar Filtros</button>
      <a href="{{ route('auctions.index') }}" class="clear-filters">Limpar Filtros</a>
  </div>
</form>
