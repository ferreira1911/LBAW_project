<div class="mb-4">
    <div class="card border-0 shadow-sm rounded-3">
        <div class="card-header bg-white border-bottom px-4 pt-2 pb-0">
            <nav class="nav nav-tabs card-header-tabs border-0 gap-4">
                
                {{-- 1. Users Tab --}}
                <a href="{{ route('users.index') }}" 
                   class="nav-link py-3 px-1 fw-bold d-flex align-items-center border-0 border-bottom border-3 
                   {{ request()->routeIs('users.*') ? 'border-transparent text-primary' : 'border-transparent text-secondary hover-text-primary' }}"
                   style="margin-bottom: -1px; transition: all 0.2s ease;border: transparent !important;background: transparent !important;">
                    <i class="bi bi-people-fill me-2 fs-5"></i>
                    User Management
                </a>

                {{-- 2. Auctions Tab --}}
                <a href="{{ route('auctions.admin') }}" 
                   class="nav-link py-3 px-1 fw-bold d-flex align-items-center border-0 border-bottom border-3 
                   {{ request()->routeIs('auctions.admin') ? 'border-transparent text-primary' : 'border-transparent text-secondary hover-text-primary' }}"
                   style="margin-bottom: -1px; transition: all 0.2s ease;border: transparent !important;background: transparent !important;">
                    <i class="bi bi-hammer me-2 fs-5"></i>
                    Auction Management
                </a>

                {{-- 3. Reports Tabs (Dropdown) --}}
                <div class="dropdown">
                    <a href="#" 
                    class="nav-link dropdown-toggle py-3 px-1 fw-bold d-flex align-items-center border-0 border-bottom border-3 
                    {{ (request()->routeIs('reports.admin') || request()->routeIs('admin.myReports')) ? 'border-transparent text-primary' : 'border-transparent text-secondary hover-text-primary' }}" id="reportsDropdown" role="button"  data-bs-toggle="dropdown"  aria-expanded="false" style="margin-bottom: -1px; transition: all 0.2s ease;border: transparent !important;background: transparent !important;">
                        
                        <i class="bi bi-file-earmark-bar-graph me-2 fs-5"></i>
                        Reports Management
                    </a>

                    {{-- O Menu Dropdown --}}
                    <ul class="dropdown-menu shadow border-0 mt-2" aria-labelledby="reportsDropdown">
                        <li>
                            <a class="dropdown-item py-2 {{ request()->routeIs('reports.admin') ? 'active' : '' }}" 
                            href="{{ route('reports.admin') }}">
                                All Reports
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item py-2 {{ request()->routeIs('admin.myReports') ? 'active' : '' }}" 
                            href="{{ route('admin.myReports') }}">
                                Assigned to Me
                            </a>
                        </li>
                    </ul>
                </div>
                

                <a href="{{ route('categories.create') }}" 
                   class="nav-link py-3 px-1 fw-bold d-flex align-items-center border-0 border-bottom border-3 
                   {{ request()->routeIs('categories.create') || request()->routeIs('category.*') ? 'border-transparent text-primary' : 'border-transparent text-secondary hover-text-primary' }}"
                   style="margin-bottom: -1px; transition: all 0.2s ease;border: transparent !important;background: transparent !important;">
                    <i class="bi bi-tags-fill me-2 fs-5"></i>
                    Category Management
                </a>
            </nav>
        </div>
    </div>
</div>

<style>
    .hover-text-primary:hover {
        color: var(--bs-primary) !important;
        border-color: rgba(var(--bs-primary-rgb), 0.3) !important;
    }
</style>