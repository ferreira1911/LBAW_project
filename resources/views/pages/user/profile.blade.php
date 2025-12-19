@extends('layouts.app')

@section('title', $user->name . "'s Profile")

@section('content')
<div class="container py-5">
    
    {{-- Breadcrumb --}}
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('auctions.index') }}" class="text-decoration-none">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">User Profile</li>
        </ol>
    </nav>

    <div class="row g-4">
        
        {{-- Left Column: User Info Card --}}
        <div class="col-md-4">
            <div class="card shadow-sm border-0 text-center p-4 h-100">
                
                {{-- Profile Photo --}}
                <div class="mb-3">
                    @if($user->url)
                        <img src="{{ $user->getProfileImage() }}"
                            alt="{{ $user->name }}"
                            class="rounded-circle img-thumbnail object-fit-cover"
                            style="width: 150px; height: 150px;">
                    @else
                        <div class="rounded-circle bg-light d-inline-flex align-items-center justify-content-center mb-3"
                            style="width: 150px; height: 150px;">
                            <i class="bi bi-person-fill display-1 text-secondary"></i>
                        </div>
                    @endif
                </div>

                {{-- Name + Email --}}
                <h3 class="fw-bold mb-1">{{ $user->name }}</h3>
                <p class="text-muted mb-3">{{ $user->email }}</p>

                {{-- Rating Badge --}} 
                @can('viewPersonalData', $user)
                    <div class="mb-4"> 
                    <a href="{{ route('reviews.index', ['seller_id' => $user->id]) }}" 
                        class="text-decoration-none">
                        <span class="badge bg-warning text-dark fs-6 hover-shadow" style="cursor: pointer;"> 
                            <i class="bi bi-star-fill me-1"></i> 
                            @php $avg = $user->getAverageRating(); @endphp
                            @if($avg > 0)
                                {{ number_format($avg, 1) }} / 5.0
                            @else
                                N/A
                            @endif
                        </span>
                    </a>
                </div>
                {{-- Bio --}}
                <div class="text-start mb-4">
                    <h6 class="fw-bold text-uppercase small text-muted">About</h6>
                    <p class="small text-secondary">
                        {{ $user->description ?? 'This user has not added a bio yet.' }}
                    </p>
                </div>
                @endcan
                

                {{-- WALLET SECTION (Only for own profile or admin) --}}
                @if (!empty($canViewBalance) && $canViewBalance && !$user->is_admin)
                    <div class="card shadow-sm border-0 mb-4 bg-primary text-white">
                        <div class="card-body p-4">
                            <h5 class="mb-1 opacity-75">Available Balance</h5>
                            <h3 class="fw-bold mb-0">€{{ number_format($user->credit, 2) }}</h3>

                            @if($user->held_credit > 0)
                                <small class="text-white-50 d-block mt-1">
                                    <i class="bi bi-lock-fill me-1"></i>
                                    Held in active bids: €{{ number_format($user->held_credit, 2) }}
                                </small>
                            @endif

                            @if(Auth::id() === $user->id)
                                <div class="d-flex justify-content-center gap-3 mt-4">
                                    <a href="{{ route('credit.create') }}"
                                    class="btn btn-light fw-bold text-primary px-4">
                                        <i class="bi bi-plus-lg me-1"></i>Add Funds
                                    </a>

                                    <a href="{{ route('withdrawal.create') }}"
                                    class="btn btn-outline-light px-4">
                                        <i class="bi bi-cash-stack me-1"></i>Withdraw
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>
                @endif

                {{-- OWNER ACTIONS --}}
                @can('update', $user)
                    <div class="d-grid gap-2">
                        <a href="{{ route('users.edit', $user) }}" class="btn btn-outline-primary">
                            <i class="bi bi-pencil-square me-2"></i>Edit Profile
                        </a>

                        @can('viewPersonalData', $user)
                            <a href="{{ route('transactions.index') }}" class="btn btn-outline-secondary">
                                <i class="bi bi-receipt me-2"></i>Transaction History
                            </a>
                            <a href="{{ route('bidding-history.index') }}" class="btn btn-outline-secondary">
                                <i class="bi bi-receipt me-2"></i>Bidding History
                            </a>
                        @endif

                        <form action="{{ route('users.destroy', $user) }}"
                            method="POST"
                            onsubmit="return confirm('Are you sure you want to delete your profile?');">
                            @csrf
                            <button type="submit" class="btn btn-outline-danger w-100">
                                <i class="bi bi-trash me-2"></i>Delete Profile
                            </button>
                        </form>
                    </div>
                @endcan

                @can('message', $user)
                    <a href="{{ route('messages.show', $user->id) }}" class="btn btn-outline-primary w-100 mt-3 fw-bold">
                        <i class="bi bi-chat-dots me-2"></i>Chat with User
                    </a>
                @endcan

                {{-- REPORT USER (Only for other users) --}}
                @can('create', [App\Models\Report::class, $user])
                    <a href="{{ route('report.create', ['reported_user_id' => $user->id]) }}"
                        class="btn btn-outline-danger w-100 mt-3 fw-bold">
                        <i class="bi bi-flag me-2"></i>Report User
                    </a>
                @endcan
            </div>
        </div>

        {{-- Right Column: Details & Auctions --}}
        <div class="col-md-8">

            @can('viewPersonalData', $user)
                {{-- TABS --}}
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-white border-bottom">
                        <ul class="nav nav-tabs card-header-tabs" id="profileTabs" data-user-id="{{ $user->id }}">
                            <li class="nav-item">
                                <button class="nav-link active" data-target="auctions">My Auctions</button>
                            </li>
                            <li class="nav-item">
                                <button class="nav-link" data-target="active-bids">My Active Bids</button>
                            </li>
                            <li class="nav-item">
                                <button class="nav-link" data-target="watchlist">Watchlist</button>
                            </li>
                            <li class="nav-item">
                                <button class="nav-link" data-target="won">Won Auctions</button>
                            </li>
                            <li class="nav-item">
                                <button class="nav-link" data-target="messages">Messages</button>
                            </li>
                        </ul>
                    </div>

                    {{-- CONTENT LOADED BY AJAX --}}
                    <div id="tabContent" class="p-3">
                        <div class="text-center text-muted py-5">
                            <div class="spinner-border"></div>
                            <p class="mt-3 mb-0 small">Loading...</p>
                        </div>
                    </div>
                </div>

            @else
                @if(!$user->isAdmin())
                {{-- STATIC AUCTION LIST (when viewing other users) --}}
                    <div class="card shadow-sm border-0">
                        <div class="card-header bg-white py-3 border-bottom">
                            <h5 class="fw-bold mb-0">
                                <i class="bi bi-hammer me-2 text-primary"></i>
                                {{ $user->name }}'s Auctions
                            </h5>
                        </div>
                        <div class="card-body p-0">
                            @if($auctions->count() > 0)
                                <div class="list-group list-group-flush">
                                    @foreach($auctions as $auction)
                                        <a href="{{ route('auctions.show', $auction) }}" 
                                           class="list-group-item list-group-item-action p-3 d-flex justify-content-between align-items-center">
                                            <div class="d-flex align-items-center">
                                                {{-- Thumbnail --}}
                                                <div class="rounded bg-light me-3 d-flex align-items-center justify-content-center text-secondary" 
                                                     style="width: 60px; height: 60px;">
                                                    @if(isset($auction->images) && $auction->images->count() > 0)
                                                        <img src="{{ asset('images/auction/' . $auction->images->first()->path) }}" 
                                                             class="w-100 h-100 object-fit-cover rounded" 
                                                             alt="{{ $auction->title }}">
                                                    @else
                                                        <i class="bi bi-image fs-4"></i>
                                                    @endif
                                                </div>
                                                <div>
                                                    <h6 class="fw-bold mb-1 text-dark">
                                                        {{ $auction->title }}
                                                        @if ($auction->is_featured)
                                                            <span class="badge bg-warning text-dark ms-1" style="font-size: 0.7em;">Featured</span>
                                                        @endif
                                                    </h6>
                                                    <div class="small text-muted">
                                                        Status: 
                                                        @php
                                                            $statusClass = match($auction->status) {
                                                                'Active' => 'text-success',
                                                                'Ending' => 'text-danger', 
                                                                default => 'text-secondary',
                                                            };
                                                        @endphp
                                                        <span class="fw-bold {{ $statusClass }}">
                                                            {{ $auction->status === 'Ending' ? 'Ending Soon' : $auction->status }}
                                                        </span>
                                                        • Current Price: €{{ number_format($auction->current_price, 2) }}
                                                    </div>
                                                </div>
                                            </div>
                                            <i class="bi bi-chevron-right text-muted"></i>
                                        </a>
                                    @endforeach
                                </div>
                            @else
                                <div class="text-center py-5 text-muted">
                                    <i class="bi bi-inbox display-4 opacity-25 mb-2 d-block"></i>
                                    <p class="mb-0">This user has no auctions yet.</p>
                                </div>
                            @endif
                        </div>
                    </div>
                    @endif
                @endcan

        </div>
    </div>
</div>

@can('viewPersonalData', $user)
<script>
document.addEventListener('DOMContentLoaded', function () {
    const profileTabs = document.getElementById('profileTabs');
    const contentBox = document.getElementById('tabContent');

    const userId = profileTabs.getAttribute('data-user-id');
    console.log(userId);

    function loadTab(target) {
        contentBox.innerHTML = `
            <div class="text-center text-muted py-5">
                <div class="spinner-border"></div>
                <p class="mt-3 mb-0 small">Loading...</p>
            </div>`;

        const url = `${baseUrl}/users/${userId}/${target}`;
        

        fetch(url)
            .then(res => res.text())
            .then(html => contentBox.innerHTML = html)
            .catch(() => contentBox.innerHTML = "<p class='text-danger'>Error loading content.</p>");
    }

    // Add click handlers
    document.querySelectorAll('#profileTabs button').forEach(btn => {
        btn.addEventListener('click', function () {
            document.querySelector('#profileTabs .active')?.classList.remove('active');
            this.classList.add('active');
            loadTab(this.dataset.target);
        });
    });

    // Load first tab on page load
    loadTab('auctions');
});
</script>
@endif

@endsection