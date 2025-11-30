<div class="mb-4">
    <h2 class="fw-bold text-dark mb-3">Painel de Administração</h2>
    
    <div class="card border-0 shadow-sm rounded-top-4 overflow-hidden">
        <div class="card-header bg-white border-bottom px-4 pt-3 pb-0">
            <ul class="nav nav-tabs card-header-tabs border-0 gap-2">
                
                {{-- 1. Aba de Utilizadores --}}
                <li class="nav-item">
                    <a href="{{ route('users.index') }}" 
                       class="nav-link py-3 px-4 fw-bold {{ request()->routeIs('users.index') ? 'active border-primary border-top-0 border-start-0 border-end-0 border-bottom-3 text-primary' : 'text-muted border-0' }}">
                        <i class="fas fa-users me-2"></i> Gestão de Utilizadores
                    </a>
                </li>

                {{-- 2. Aba de Leilões (Admin) --}}
                <li class="nav-item">
                    {{-- Nota: Precisamos de criar a rota 'admin.auctions' no próximo passo --}}
                    <a href="{{ route('auctions.admin') }}" 
                       class="nav-link py-3 px-4 fw-bold {{ request()->routeIs('auctions.admin') ? 'active border-primary border-top-0 border-start-0 border-end-0 border-bottom-3 text-primary' : 'text-muted border-0' }}">
                        <i class="fas fa-gavel me-2"></i> Leilões
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>