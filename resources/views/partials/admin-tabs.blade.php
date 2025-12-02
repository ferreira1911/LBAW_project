<div class="mb-4">
    <div class="card border-0 shadow-sm rounded-3 overflow-hidden">
        <div class="card-header bg-white border-bottom px-4 pt-2 pb-0">
            <nav class="nav nav-tabs card-header-tabs border-0 gap-4">
                
                {{-- 1. Users Tab --}}
                <a href="{{ route('users.index') }}" 
                   class="nav-link py-3 px-1 fw-bold d-flex align-items-center border-0 border-bottom border-3 
                   {{ request()->routeIs('users.*') ? 'border-primary text-primary' : 'border-transparent text-secondary hover-text-primary' }}"
                   style="margin-bottom: -1px; transition: all 0.2s ease;">
                    <i class="bi bi-people-fill me-2 fs-5"></i>
                    User Management
                </a>

                {{-- 2. Auctions Tab --}}
                <a href="{{ route('auctions.admin') }}" 
                   class="nav-link py-3 px-1 fw-bold d-flex align-items-center border-0 border-bottom border-3 
                   {{ request()->routeIs('auctions.admin') ? 'border-primary text-primary' : 'border-transparent text-secondary hover-text-primary' }}"
                   style="margin-bottom: -1px; transition: all 0.2s ease;">
                    <i class="bi bi-hammer me-2 fs-5"></i>
                    Auction Management
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